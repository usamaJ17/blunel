<?php

namespace App\Http\Controllers\Vendor\DeliveryMan;

use App\Contracts\Repositories\DeliveryManWalletRepositoryInterface;
use App\Contracts\Repositories\WithdrawRequestRepositoryInterface;
use App\Enums\ViewPaths\Vendor\Auth;
use App\Enums\ViewPaths\Vendor\Dashboard;
use App\Enums\ViewPaths\Vendor\DeliveryManWallet;
use App\Enums\ViewPaths\Vendor\DeliveryManWithdraw;
use App\Events\WithdrawStatusUpdateEvent;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Vendor\DeliveryManWithdrawRequest;
use App\Services\DeliveryManService;
use App\Services\DeliveryManWalletService;
use App\Services\DeliveryManWithdrawService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Exports\DeliveryManWithdrawRequestExport;

class DeliveryManWithdrawController extends BaseController
{

    /**
     * @param WithdrawRequestRepositoryInterface $withdrawRequestRepo
     * @param DeliveryManWithdrawService $deliveryManWithdrawService
     * @param DeliveryManWalletRepositoryInterface $deliveryManWalletRepo
     * @param DeliveryManService $deliveryManService
     */
    public function __construct
    (
        private readonly WithdrawRequestRepositoryInterface $withdrawRequestRepo,
        private readonly DeliveryManWithdrawService $deliveryManWithdrawService,
        private readonly DeliveryManWalletRepositoryInterface $deliveryManWalletRepo,
        private readonly DeliveryManService $deliveryManService,
        private readonly DeliveryManWalletService $deliveryManWalletService,
    )
    {
    }

    /**
     * @param Request|null $request
     * @param string|null $type
     * @return View|Collection|LengthAwarePaginator|callable|RedirectResponse|null
     */
    public function index(?Request $request, string $type = null): View|Collection|LengthAwarePaginator|null|callable|RedirectResponse
    {
        return $this->getListView();
    }

    /**
     * @return RedirectResponse|View
     */
    public function getListView(): View|RedirectResponse
    {
        if (!$this->deliveryManService->checkConditions()){
            return redirect()->route(Dashboard::INDEX[ROUTE]);
        }
        $vendorId = auth('seller')->id();
        $withdrawRequests = $this->withdrawRequestRepo->getListWhere(
            filters:[
                'vendorId' => $vendorId,
                'whereNotNull' => 'delivery_man_id'
            ],
            relations:['deliveryMan'] ,
            dataLimit: getWebConfig(name: 'pagination_limit')
        );
        return view(DeliveryManWithdraw::INDEX[VIEW],compact('withdrawRequests'));
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getFiltered(Request $request): JsonResponse
    {
        $vendorId =auth('seller')->id() ;
        $withdrawRequests = $this->withdrawRequestRepo->getListWhere(
            filters: [
                'vendorId'=> $vendorId,
                'whereNotNull' => 'delivery_man_id',
                'status'=>$request['status']
            ],
            relations: ['deliveryMan'],
            dataLimit: getWebConfig('pagination_limit')
        );
        return response()->json([
            'view' => view(DeliveryManWithdraw::INDEX[TABLE_VIEW], compact('withdrawRequests'))->render(),
            'count' => $withdrawRequests->count(),
        ], 200);
    }

    /**
     * @param string|int $withdrawId
     * @return View
     */
    public function getDetails(string|int $withdrawId): View
    {
        $details = $this->withdrawRequestRepo->getFirstWhere(
            params: ['id' => $withdrawId,'seller_id' => auth('seller')->id()],
            relations:['deliveryMan']);
        return view(DeliveryManWithdraw::DETAILS[VIEW],compact('details'));
    }

    /**
     * @param DeliveryManWithdrawRequest $request
     * @param string|int $withdrawId
     * @return RedirectResponse
     */
    public function updateStatus(DeliveryManWithdrawRequest $request , string|int $withdrawId):RedirectResponse
    {
        $withdraw = $this->withdrawRequestRepo->getFirstWhere(params: ['id' => $withdrawId,'seller_id' => auth('seller')->id()],relations:['deliveryMan']);
        if(!$withdraw){
            Toastr::warning(translate('Invalid_withdraw'));
            return redirect()->route(DeliveryManWallet::INDEX[ROUTE]);
        }
        $wallet = $this->deliveryManWalletRepo->getFirstWhere(params:['delivery_man_id'=>$withdraw['delivery_man_id']]);
        $updateWalletData = $this->deliveryManWalletService->getDeliveryManWalletData(
            request:$request,wallet:$wallet,withdraw: $withdraw
        );
        $this->withdrawRequestRepo->update(
            id:$withdraw['id'],
            data: $this->deliveryManWithdrawService->getDeliveryManWithdrawData(request: $request)
        );
        $this->deliveryManWalletRepo->update(
            id:$wallet['id'],data: $updateWalletData
        );
        if(!empty($withdraw->deliveryMan?->fcm_token)) {
            WithdrawStatusUpdateEvent::dispatch('withdraw_request_status_message', 'delivery_man', $withdraw->delivery_men?->app_language ?? getDefaultLanguage(), $request['approved'], $withdraw->deliveryMan?->fcm_token);
        }
        if ($request['approved'] == 1) {
            Toastr::success(translate('Delivery_man_payment_has_been_approved_successfully'));
        }else{
            Toastr::info(translate('Delivery_man_payment_request_has_been_Denied_successfully'));
        }
        return redirect()->route(DeliveryManWallet::INDEX[ROUTE]);
    }


    /**
     *
     * @return BinaryFileResponse|RedirectResponse
     */
    public function exportList():BinaryFileResponse|RedirectResponse
    {

        $vendorId = auth('seller')->id();
        $withdrawRequests = $this->withdrawRequestRepo->getListWhere(
            filters:[
                'vendorId' => $vendorId,
                'whereNotNull' => 'delivery_man_id'
            ],
            relations:['deliveryMan'] ,
        );
        $pendingRequest = $withdrawRequests->where('approved',0)->count();
        $approvedRequest = $withdrawRequests->where('approved',1)->count();
        $deniedRequest = $withdrawRequests->where('approved',2)->count();
        $data = [
            'withdraw_request'=>$withdrawRequests,
            'filter' => session('delivery_withdraw_status_filter'),
            'pending_request'=>$pendingRequest,
            'approved_request'=>$approvedRequest,
            'denied_request'=>$deniedRequest,
        ];
        return Excel::download(export: new DeliveryManWithdrawRequestExport($data), fileName: DeliveryManWithdraw::EXPORT[FILE_NAME]);
    }



}
