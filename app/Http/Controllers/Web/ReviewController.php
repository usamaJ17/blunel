<?php

namespace App\Http\Controllers\Web;

use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Contracts\Repositories\ReviewRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Traits\FileManagerTrait;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use FileManagerTrait;

    public function __construct(
        private readonly ReviewRepositoryInterface $reviewRepo,
        private readonly OrderRepositoryInterface  $orderRepo,
    )
    {}

    public function add(Request $request): RedirectResponse
    {
        $imageArray = [];
        if ($request->has('fileUpload')) {
            foreach ($request->file('fileUpload') as $image) {
                $imageArray[] = $this->upload(dir: 'review/', format: 'webp', image: $image);
            }
        }
        $review = $this->reviewRepo->getFirstWhere(params: ['customer_id' => auth('customer')->id(), 'product_id' => $request['product_id']]);
        if ($review && $review['attachment'] && $request->has('fileUpload')) {
            foreach (json_decode($review['attachment']) as $image) {
                $this->delete(filePath: '/review/' . $image);
            }
        }

        $dataArray = [
            'comment' => $request['comment'], 'rating' => $request['rating'],
            'attachment' => $request->has('fileUpload') ? json_encode($imageArray) : ($review->attachment ?? null),
            'updated_at' => now(),
        ];

        if (!$review) {
            $dataArray['created_at'] = now();
        }

        $this->reviewRepo->updateOrInsert(
            params: ['delivery_man_id' => null, 'customer_id' => auth('customer')->id(), 'product_id' => $request['product_id']],
            data: $dataArray
        );

        Toastr::success(translate('successfully_added_review'));
        return redirect()->back();
    }

    public function addDeliveryManReview(Request $request): RedirectResponse
    {
        $order = $this->orderRepo->getFirstWhere(params: ['id' => $request['order_id'], 'customer_id' => auth('customer')->id(), 'payment_status' => 'paid']);
        if (!isset($order->delivery_man_id)) {
            Toastr::error(translate('Invalid_review'));
            return redirect('/');
        }

        $review = $this->reviewRepo->getFirstWhere(params: [
            'delivery_man_id' => $order['delivery_man_id'],
            'customer_id' => auth('customer')->id(),
            'order_id' => $request['order_id'],
        ]);

        $dataArray = [
            'customer_id' => auth('customer')->id(),
            'delivery_man_id' => $order['delivery_man_id'],
            'order_id' => $request['order_id'],
            'comment' => $request['comment'],
            'rating' => $request['rating'],
            'updated_at' => now(),
        ];

        if (!$review) {
            $dataArray['created_at'] = now();
        }

        $this->reviewRepo->updateOrInsert(params: [
            'delivery_man_id' => $order['delivery_man_id'],
            'customer_id' => auth('customer')->id(),
            'order_id' => $request['order_id']
        ], data: $dataArray
        );

        Toastr::success(translate('successfully_added_review'));
        return back();
    }
}
