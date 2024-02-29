@extends('layouts.back-end.app-seller')

@section('title', translate('refund_details'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')

    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/public/assets/back-end/img/refund-request-list.png')}}" alt="">
                {{translate('refund_details')}}
            </h2>
        </div>

        <div class="row gy-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row gy-1 justify-content-between align-items-center flex-grow-1">
                            <div class="col-md-4">
                                <h5 class="mb-0">{{translate('refund_id')}} : {{$refund->id}}</h5>
                            </div>

                            <h5 class="col-md-4 mb-0 text-capitalize">{{translate('refund_status')}}:
                                @if ($refund['status'] == 'pending')
                                    <span class="text--primary"> {{translate($refund['status'])}}</span>
                                @elseif($refund['status'] == 'approved')
                                    <span class="text-success"> {{translate($refund['status'])}}</span>
                                @elseif($refund['status'] == 'refunded')
                                    <span class="text-info"> {{translate($refund['status'])}}</span>
                                @elseif($refund['status'] == 'rejected')
                                    <span class="text-danger"> {{translate($refund['status'])}}</span>
                                @endif
                            </h5>

                            <div class="col-md-4 d-flex justify-content-md-end">
                                @if ($refund['change_by'] != 'admin')
                                    <button class="btn btn--primary" data-toggle="modal"
                                            data-target="#refund-status">{{translate('change_refund_status')}}</button>
                                @endif
                            </div>

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row gy-2">
                            <div class="col-sm-4 col-lg-2 onerror-image">
                                <img src="{{getValidImage(path:  'storage/app/public/product/thumbnail/'.($refund->product ? $refund->product->thumbnail:''),type: 'backend-product')}}" alt="">
                            </div>
                            <div class="col-sm-8 col-md-4 col-lg-6">
                                <h4>
                                    @if ($refund->product!=null)
                                        <a href="{{route('vendor.products.view',[$refund->product->id])}}">
                                            {{$refund->product->name}}
                                        </a>
                                    @else
                                        {{translate('product_name_not_found')}}
                                    @endif
                                </h4>
                                <div>{{translate('QTY')}} : {{$refund->orderDetails->qty}}</div>
                                <div>{{translate('price')}}
                                    : {{setCurrencySymbol(amount: usdToDefaultCurrency(amount: $refund->orderDetails->price), currencyCode: getCurrencyCode())}}
                                </div>
                                @if ($refund->orderDetails->variant)
                                    <strong><u>{{translate('variation')}} : </u></strong>

                                    <div class="font-size-sm text-body">
                                        <span class="font-weight-bold">{{$refund->orderDetails->variant}}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="row justify-content-md-end mb-3">
                                    <div class="col-md-10">
                                        <dl class="row text-md-right">
                                            <dt class="col-md-7">{{translate('total_price')}} :</dt>
                                            <dd class="col-md-5 ">
                                                <strong>
                                                    {{setCurrencySymbol(amount: usdToDefaultCurrency(amount: $refund->orderDetails->price*$refund->orderDetails->qty), currencyCode: getCurrencyCode())}}
                                                </strong>
                                            </dd>

                                            <dt class="col-sm-7">{{translate('total_discount')}} :</dt>
                                            <dd class="col-sm-5 ">
                                                <strong>
                                                    {{setCurrencySymbol(amount: usdToDefaultCurrency(amount: $refund->orderDetails->discount), currencyCode: getCurrencyCode())}}
                                                </strong>
                                            </dd>

                                            <dt class="col-sm-7">{{translate('total_tax')}} :</dt>
                                            <dd class="col-sm-5">
                                                <strong>
                                                    {{setCurrencySymbol(amount: usdToDefaultCurrency(amount: $refund->orderDetails->tax), currencyCode: getCurrencyCode())}}
                                                </strong>
                                            </dd>
                                        </dl>
                                        <!-- End Row -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex flex-wrap flex-column flex-md-row gap-10 justify-content-between">
                            <span
                                class="title-color">{{translate('subtotal')}} : {{setCurrencySymbol(amount: usdToDefaultCurrency(amount: $subtotal), currencyCode: getCurrencyCode())}}</span>
                            <span
                                class="title-color">{{translate('coupon_discount')}} : {{setCurrencySymbol(amount: usdToDefaultCurrency(amount: $couponDiscount), currencyCode: getCurrencyCode())}}</span>
                            <span
                                class="title-color">{{translate('total_refund_amount')}} : {{setCurrencySymbol(amount: usdToDefaultCurrency(amount: $refundAmount), currencyCode: getCurrencyCode())}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 ">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">{{translate('additional_information')}}</h4>
                    </div>

                    <div class="card-body">
                        <div class="row gy-2">
                            <div class="col-sm-6 col-md-4 d-flex flex-column gap-10">
                                <h5>{{translate('deliveryman_info')}} : </h5>
                                <span>{{translate('deliveryman_name')}} : {{$order->delivery_man!=null?$order->delivery_man->f_name . ' ' .$order->delivery_man->l_name:translate('not_assigned')}}</span>
                                <span>{{translate('deliveryman_email')}} : {{$order->delivery_man!=null?$order->delivery_man->email :translate('not_found')}}</span>
                                <span>{{translate('deliveryman_phone')}} : {{$order->delivery_man!=null?$order->delivery_man->phone :translate('not_found')}}</span>
                            </div>

                            <div class="col-sm-6 col-md-4 d-flex flex-column gap-10">
                                <span>{{translate('payment_method')}} : {{str_replace('_',' ',$order->payment_method)}}</span>
                                <span>{{translate('order_details')}} : <a class="btn btn--primary btn-sm"
                                                                          href="{{route('vendor.orders.details',['id'=>$order->id])}}">{{translate('click_here')}}</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">{{translate('refund_status_changed_log')}}</h4>
                    </div>
                    <div class="table-responsive datatable-custom">
                        <table
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{translate('SL')}}#</th>
                                <th>{{translate('changed_by')}} </th>
                                <th>{{translate('status')}}</th>
                                <th>{{translate('note')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($refund->refundStatus as $key=>$status)
                                <tr>
                                    <td>
                                        {{$key+1}}
                                    </td>
                                    <td>
                                        {{$status->change_by}}
                                    </td>
                                    <td>
                                        {{translate($status->status)}}
                                    </td>
                                    <td class="text-break">
                                        <div class="word-break max-w-360px">
                                            {{$status->message}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if(count($refund->refundStatus)==0)
                            <div class="text-center p-4">
                                <img class="mb-3 w-160" src="{{asset('public/assets/back-end/svg/illustrations/sorry.svg')}}"
                                     alt="{{translate('image_description')}}">
                                <p class="mb-0">{{ translate('no_data_to_show')}}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">{{translate('refund_reason')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            <p>
                                {{$refund->refund_reason}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">{{translate('attachment')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="col-12">

                            @if ($refund->images)
                                <div class="gallery grid-gallery">
                                    @foreach (json_decode($refund->images) as $key => $photo)
                                        <a href="{{getValidImage(path: 'storage/app/public/refund/'.$photo,type:'backend-basic')}}"
                                           data-lightbox="mygallery">
                                            <img src="{{getValidImage(path: 'storage/app/public/refund/'.$photo,type:'backend-basic')}}" alt="">
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p>{{translate('no_attachment_found')}}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="refund-status" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{translate('change_refund_status')}}</h5>
                    <button id="payment_close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('vendor.refund.update-status')}}" id='order_place' method="post"
                          class="row">
                        @csrf
                        <input type="hidden" name="id" value="{{$refund->id}}">
                        <div class="form-group col-12">
                            <label class="input-label" for="">{{translate('refund_status')}}</label>
                            <select name="refund_status" class="form-control" id="refund_status_change">
                                <option
                                    value="pending" {{$refund['status']=='pending'?'selected':''}}>
                                    {{ translate('pending')}}
                                </option>
                                {{-- @if ($refund->change_by !='admin') --}}
                                <option
                                    value="approved" {{$refund['status']=='approved'?'selected':''}}>
                                    {{ translate("approved")}}
                                </option>

                                <option
                                    value="rejected" {{$refund['status']=='rejected'?'selected':''}}>
                                    {{ translate("rejected")}}
                                </option>
                                {{-- @endif --}}
                            </select>
                        </div>
                        <div class="form-group col-12" id="approved">
                            <label class="input-label" for="">{{translate('approved_note')}}</label>
                            <input type="text" class="form-control" id="approved_note" name="approved_note">
                        </div>
                        <div class="form-group col-12" id="rejected">
                            <label class="input-label" for="">{{translate('rejected_note')}}</label>
                            <input type="text" class="form-control" id="rejected_note" name="rejected_note">
                        </div>
                        <div class="form-group col-12 d-flex justify-content-end">
                            <button class="btn btn--primary" type="submit">{{translate('submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script src="{{asset('public/assets/back-end/js/vendor/refund.js')}}"></script>
@endpush
