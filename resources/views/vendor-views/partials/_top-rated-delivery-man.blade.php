<div class="card-header">
    <h4 class="d-flex align-items-center text-capitalize gap-10 mb-0">
        <img src="{{asset('public/assets/back-end/img/top-customers.png')}}" alt="">
        {{translate('top_Delivery_Man')}}
    </h4>
</div>

<div class="card-body">
    @if($topRatedDeliveryMan)
        <div class="grid-card-wrap">
            @foreach($topRatedDeliveryMan as $key=>$deliveryMan)
                    <div class="cursor-pointer" onclick="location.href='{{ route('vendor.delivery-man.wallet.index', ['id' => $deliveryMan['id']]) }}'">
                        <div class="grid-card basic-box-shadow">
                            <div class="text-center">
                                <img class="avatar rounded-circle avatar-lg get-view-by-onclick" alt=""
                                     data-link="{{route('vendor.delivery-man.wallet.earning',[$deliveryMan['id']])}}"
                                     src="{{ getValidImage(path: 'storage/app/public/delivery-man/'.$deliveryMan->image ?? 'delivery-man',type:'backend-profile') }}"
                                >
                            </div>
                            <h5 class="mb-0">
                                {{Str::limit($deliveryMan['f_name'], 15)}}
                            </h5>
                            <div class="orders-count d-flex gap-1">
                                <div>{{translate('delivered')}} : </div>
                                <div>{{$deliveryMan['orders_count']}}</div>
                            </div>
                        </div>
                    </div>
            @endforeach
        </div>
    @else
        <div class="text-center">
            <p class="text-muted">{{translate('no_Top_Selling_Products')}}</p>
            <img class="w-75" src="{{asset('/public/assets/back-end/img/no-data.png')}}" alt="">
        </div>
    @endif
</div>
