<?php

namespace App\Http\Controllers\Vendor;

use App\Contracts\Repositories\ChattingRepositoryInterface;
use App\Contracts\Repositories\CustomerRepositoryInterface;
use App\Contracts\Repositories\DeliveryManRepositoryInterface;
use App\Contracts\Repositories\ShopRepositoryInterface;
use App\Contracts\Repositories\VendorRepositoryInterface;
use App\Enums\ViewPaths\Vendor\Chatting;
use App\Events\ChattingEvent;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Vendor\ChattingRequest;
use App\Services\ChattingService;
use App\Traits\PushNotificationTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ChattingController extends BaseController
{
    use PushNotificationTrait;

    /**
     * @param ChattingRepositoryInterface $chattingRepo
     * @param ShopRepositoryInterface $shopRepo
     * @param ChattingService $chattingService
     * @param VendorRepositoryInterface $vendorRepo
     * @param DeliveryManRepositoryInterface $deliveryManRepo
     * @param CustomerRepositoryInterface $customerRepo
     */
    public function __construct(
        private readonly ChattingRepositoryInterface $chattingRepo,
        private readonly ShopRepositoryInterface $shopRepo,
        private readonly ChattingService $chattingService,
        private readonly VendorRepositoryInterface $vendorRepo,
        private readonly DeliveryManRepositoryInterface $deliveryManRepo,
        private readonly CustomerRepositoryInterface $customerRepo,
    )
    {
    }


    /**
     * @param Request|null $request
     * @param string|array|null $type
     * @return View|Collection|LengthAwarePaginator|callable|RedirectResponse|null
     */
    public function index(?Request $request, string|array $type = null): View|Collection|LengthAwarePaginator|null|callable|RedirectResponse
    {

        return $this->getListView(type:$type);
    }

    /**
     * @param string|array $type
     * @return View
     */
    public function getListView(string|array $type):View
    {
        $shop = $this->shopRepo->getFirstWhere(params: ['seller_id' => auth('seller')->id()]);
        $vendorId = auth('seller')->id();
        if ($type == 'delivery-man') {
            $lastChat = $this->chattingRepo->getFirstWhereNotNull(
                params: ['seller_id' =>$vendorId],
                filters: ['delivery_man_id', 'seller_id'],
                orderBy: ['created_at' => 'DESC']
            );
            if (isset($lastChat)) {
                $this->chattingRepo->updateAllWhere(
                    params: ['seller_id' => $vendorId, 'delivery_man_id' => $lastChat['delivery_man_id']],
                    data: ['seen_by_seller' => 1]
                );
                $chattings = $this->getChatList(
                    tableName: 'delivery_men',
                    orderBy : 'desc',
                    id: $lastChat['delivery_man_id'],
                );
                $chattingUser = $this->getChatList(
                    tableName: 'delivery_men',
                    orderBy : 'desc',
                )->unique('delivery_man_id');
                return view(Chatting::INDEX[VIEW], compact('chattings', 'chattingUser', 'lastChat', 'shop'));
            }
        } elseif ($type == 'customer') {
            $lastChat = $this->chattingRepo->getFirstWhereNotNull(
                params: ['seller_id' =>$vendorId],
                filters: ['user_id', 'seller_id'],
                orderBy: ['created_at' => 'DESC']
            );
            if (isset($lastChat)) {
                $this->chattingRepo->updateAllWhere(
                    params: ['seller_id' => $vendorId, 'user_id' => $lastChat['user_id']],
                    data: ['seen_by_seller' => 1]);

                $chattings = $this->getChatList(
                    tableName: 'users',
                    orderBy : 'desc',
                    id: $lastChat['user_id'],
                );
                $chattingUser = $this->getChatList(
                    tableName: 'users',
                    orderBy : 'desc',
                )->unique('user_id');
                return view(Chatting::INDEX[VIEW], compact('chattings', 'chattingUser', 'lastChat', 'shop'));
            }
        }
        return view(Chatting::INDEX[VIEW], compact( 'shop'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getMessageByUser(Request $request):JsonResponse
    {
        $vendorId = auth('seller')->id();
        if ($request->has(key: 'delivery_man_id')) {
            $this->chattingRepo->updateAllWhere(
                params: ['seller_id' => $vendorId, 'delivery_man_id' => $request['delivery_man_id']],
                data: ['seen_by_seller' => 1]);
            $chattings = $this->getChatList(
                tableName: 'delivery_men',
                orderBy : 'asc',
                id: $request['delivery_man_id'],
                );
        } elseif ($request->has(key: 'user_id')) {
            $this->chattingRepo->updateAllWhere(
                params: ['seller_id' => $vendorId, 'user_id' => $request['user_id']],
                data: ['seen_by_seller' => 1]
            );
            $chattings = $this->getChatList(
                tableName: 'users',
                orderBy : 'asc',
                id: $request['user_id'],
            );
        }
        foreach ($chattings as $chatting) {
            $imageNewData = [];
            foreach (json_decode($chatting['attachment']) as $data) {
                $imageNewData[] = getValidImage(path: 'storage/app/public/chatting/' . $data, type: 'backend-basic');
            }
            $chatting['attachment'] = json_encode($imageNewData);
        }
        return response()->json($chattings);
    }

    /**
     * @param ChattingRequest $request
     * @return JsonResponse
     */
    public function addVendorMessage(ChattingRequest $request):JsonResponse
    {
        $message = $request['message'];
        $time = now();
        $vendor = $this->vendorRepo->getFirstWhere(params: ['id' => auth('seller')->id()]);
        $shop = $this->shopRepo->getFirstWhere(params: ['seller_id' => auth('seller')->id()]);
        $attachment = $this->chattingService->getAttachment($request);
        if ($request->has(key: 'delivery_man_id')) {
            $this->chattingRepo->add(
                data: $this->chattingService->getDeliveryManChattingData(
                    request: $request,
                    shopId: $shop['id'],
                    vendorId: $vendor['id']
                )
            );
            $deliveryMan = $this->deliveryManRepo->getFirstWhere(params: ['id' => $request['user_id']]);
            ChattingEvent::dispatch('message_from_seller', 'delivery_man', $deliveryMan, $vendor);
        } elseif ($request->has(key: 'user_id')) {
            $this->chattingRepo->add(
                data: $this->chattingService->getCustomerChattingData(
                    request: $request,
                    shopId: $shop['id'],
                    vendorId: $vendor['id'])
            );
            $customer = $this->customerRepo->getFirstWhere(params: ['id' => $request['user_id']]);
            ChattingEvent::dispatch('message_from_seller', 'customer', $customer, $vendor);
        }
        $imageArray = [];
        foreach ($attachment as $singleImage) {
            $imageArray[] = getValidImage(path: 'storage/app/public/chatting/'.$singleImage, type: 'backend-basic');
        }
        return response()->json(['message' => $message, 'time' => $time, 'image' => $imageArray]);
    }

    /**
     * @param string $tableName
     * @param string $orderBy
     * @param string|int|null $id
     * @return Collection
     */
    protected function getChatList(string $tableName, string $orderBy, string|int $id = null) :Collection
    {
        $vendorId = auth('seller')->id();
        $columnName = $tableName == 'users' ? 'user_id' : 'delivery_man_id';
        $filters = isset($id) ? ['chattings.seller_id' => $vendorId, $columnName => $id] : ['chattings.seller_id' => $vendorId];
        return $this->chattingRepo->getListBySelectWhere(
            joinColumn: [$tableName, $tableName . '.id', '=', 'chattings.' . $columnName],
            select: ['chattings.*', $tableName . '.f_name', $tableName . '.l_name', $tableName . '.image'],
            filters: $filters,
            orderBy: ['chattings.created_at' => $orderBy],
        );
    }
}
