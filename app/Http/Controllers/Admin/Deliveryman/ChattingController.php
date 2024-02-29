<?php

namespace App\Http\Controllers\Admin\Deliveryman;

use App\Contracts\Repositories\ChattingRepositoryInterface;
use App\Contracts\Repositories\DeliveryManRepositoryInterface;
use App\Enums\ViewPaths\Admin\Chatting;
use App\Events\ChattingEvent;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ChattingRequest;
use App\Services\ChattingService;
use App\Traits\PushNotificationTrait;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChattingController extends BaseController
{
    use PushNotificationTrait;
    /**
     * @param ChattingRepositoryInterface $chattingRepo
     * @param DeliveryManRepositoryInterface $deliveryManRepo
     */
    public function __construct(
        private readonly ChattingRepositoryInterface    $chattingRepo,
        private readonly DeliveryManRepositoryInterface $deliveryManRepo,
    )
    {
    }

    /**
     * @param Request|null $request
     * @param string|null $type
     * @return View Index function is the starting point of a controller
     * Index function is the starting point of a controller
     */
    public function index(Request|null $request, string $type = null): \Illuminate\View\View
    {
        return $this->getView();
    }

    public function getView(): View
    {
        $lastChat = $this->chattingRepo->getFirstWhereNotNull(
            params: ['admin_id' => 0],
            filters: ['delivery_man_id', 'admin_id'],
            orderBy: ['chattings.created_at' => 'DESC']
        );

        if (isset($lastChat)) {
            $this->chattingRepo->updateAllWhere(
                params: ['admin_id' => 0, 'delivery_man_id' => $lastChat['delivery_man_id']],
                data: ['seen_by_admin' => 1]
            );
            $chattings = $this->getChatList(id: $lastChat['delivery_man_id'], tableName: 'delivery_men');
            $chattingUser = $this->getChatList(tableName: 'delivery_men')->unique('delivery_man_id');

            return view(Chatting::VIEW[VIEW], compact('chattings', 'chattingUser', 'lastChat'));
        }

        return view(Chatting::VIEW[VIEW], compact('lastChat'));
    }

    public function getMessages(Request $request): JsonResponse
    {
        $this->chattingRepo->updateAllWhere(
            params: ['admin_id' => 0, 'delivery_man_id' => $request['delivery_man_id']],
            data: ['seen_by_admin' => 1]
        );
        $chatting = $this->getChatList(id: $request['delivery_man_id'], tableName: 'delivery_men', orderBy: 'asc');
        foreach ($chatting as $value) {
            $imageNewData = [];
            foreach (json_decode($value['attachment']) as $data) {
                $imageNewData[] = getValidImage(path: 'storage/app/public/chatting/' . $data, type: 'backend-basic');
            }
            $value['attachment'] = json_encode($imageNewData);
        }
        return response()->json($chatting);
    }


    public function add(ChattingRequest $request, ChattingService $chattingService): JsonResponse
    {
        $attachment = $chattingService->getAttachment(request: $request);
        $dataArray = $chattingService->addChattingData(request: $request);
        $this->chattingRepo->add(data: $dataArray);
        $deliveryMan = $this->deliveryManRepo->getFirstWhere(params: ['id'=>$request['delivery_man_id']]);
        $messageForm = (object)[
            'f_name'=>'admin',
            'shop'=> [
                'name'=> getWebConfig(name: 'company_name')
            ]
        ];
        ChattingEvent::dispatch('message_from_admin', 'delivery_man', $deliveryMan, $messageForm);
        $imageArray = [];
        foreach ($attachment as $singleImage) {
            $imageArray[] = getValidImage(path: 'storage/app/public/chatting/'.$singleImage, type: 'backend-basic');
        }
        return response()->json(['status'=>1,'message' => $request['message'], 'time' => now(), 'image' => $imageArray]);
    }


    /**
     * @param string|int|null $id
     * @param string|null $tableName
     * @return Collection
     */
    protected function getChatList(string|int $id = null , string $tableName = null, string $orderBy='desc') :Collection
    {
        $columnName = $tableName == 'admins' ? 'admin_id' : 'delivery_man_id';
        $filters =  $id ? ['chattings.admin_id' => 0, $columnName => $id] : ['chattings.admin_id' => 0];
        return $this->chattingRepo->getListBySelectWhere(
            joinColumn: [$tableName, $tableName . '.id', '=', 'chattings.' . $columnName],
            select: ['chattings.*', $tableName . '.f_name', $tableName . '.l_name', $tableName . '.image'],
            filters: $filters,
            orderBy: ['chattings.created_at' => $orderBy],
        );
    }

}
