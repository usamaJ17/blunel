<?php

namespace App\Services;

use App\Traits\FileManagerTrait;

class ChattingService
{
    use FileManagerTrait;

    /**
     * @param object $request
     * @return array
     */
    public function getAttachment(object $request):array
    {
        $attachment = [];
        if ($request->file('image')) {
            foreach ($request['image'] as $key=>$value) {
                $attachment[] = $this->upload('chatting/', 'webp', $value);
            }
        }
        return $attachment;
    }

    /**
     * @param object $request
     * @param string|int $shopId
     * @param string|int $vendorId
     * @return array
     */
    public function getDeliveryManChattingData(object $request , string|int $shopId, string|int $vendorId):array
    {
        return [
            'delivery_man_id' => $request['delivery_man_id'],
            'seller_id' => $vendorId,
            'shop_id' => $shopId,
            'message' => $request['message'],
            'attachment' =>json_encode($this->getAttachment($request)),
            'sent_by_seller' => 1,
            'seen_by_seller' => 1,
            'seen_by_delivery_man' => 0,
            'created_at' => now(),
        ];
    }

    /**
     * @param object $request
     * @param string|int $shopId
     * @param string|int $vendorId
     * @return array
     */
    public function getCustomerChattingData(object $request , string|int $shopId, string|int $vendorId):array
    {
        return [
            'user_id' => $request['user_id'],
            'seller_id' => $vendorId,
            'shop_id' => $shopId,
            'message' => $request->message,
            'attachment' =>json_encode($this->getAttachment($request)),
            'sent_by_seller' => 1,
            'seen_by_seller' => 1,
            'seen_by_customer' => 0,
            'created_at' => now(),
        ];
    }

    /**
     * @param object $request
     * @return array
     */
    public function addChattingData(object $request):array
    {
        $attachment = $this->getAttachment(request: $request);
        return [
            'delivery_man_id' => $request['delivery_man_id'],
            'admin_id' => 0,
            'message' => $request['message'],
            'attachment' => json_encode($attachment),
            'sent_by_admin' => 1,
            'seen_by_admin' => 1,
            'created_at' => now(),
        ];
    }
}
