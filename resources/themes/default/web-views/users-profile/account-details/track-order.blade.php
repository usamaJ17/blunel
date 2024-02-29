@extends('layouts.front-end.app')

@section('title', translate('order_Details'))

@section('content')

    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl __inline-47 text-align-direction">
        <div class="row g-3">
            @include('web-views.partials._profile-aside')

            <section class="col-lg-9">
                @include('web-views.users-profile.account-details.partial',['order'=>$orderDetails])
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex gap-3 flex-wrap mb-4">
                            @if($orderDetails->order_type == 'default_type' && getWebConfig(name: 'order_verification'))
                                <div class="bg-light rounded py-2 px-3 d-flex align-items-center">
                                    <div class="fs-14">
                                        {{translate('order_verification_code') }} :
                                        <strong class="text-base">
                                            {{$orderDetails['verification_code']}}
                                        </strong>
                                    </div>
                                </div>
                            @endif
                            @if($orderDetails->order_type == 'POS')
                                <button type="button"
                                        class="btn bg-light border border-primary-light">{{translate('POS_Order') }}</button>
                            @endif
                        </div>

                        <ul class="nav nav-tabs media-tabs nav-justified order-track-info">
                            @if ($orderDetails['order_status']!='returned' && $orderDetails['order_status']!='failed' && $orderDetails['order_status']!='canceled')
                                <li class="nav-item">
                                    <div class="nav-link active-status">
                                        <div class="d-flex flex-sm-column gap-3 gap-sm-0">
                                            <div class="media-tab-media mx-sm-auto mb-3">
                                                <img
                                                    src="{{asset('/public/assets/front-end/img/track-order/order-placed.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="media-body">
                                                <div class="text-sm-center">
                                                    <h6 class="media-tab-title text-nowrap mb-0 text-capitalize fs-14">{{ translate('order_placed') }}</h6>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center justify-content-sm-center gap-1 mt-2">
                                                    <img
                                                        src="{{asset('/public/assets/front-end/img/track-order/clock.png') }}"
                                                        width="14" alt="">
                                                    <span
                                                        class="text-muted fs-12">{{date('h:i A, d M Y',strtotime($orderDetails->created_at))}}</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </li>

                                <li class="nav-item ">
                                    <div
                                        class="nav-link {{($orderDetails['order_status']=='confirmed') || ($orderDetails['order_status']=='processing') || ($orderDetails['order_status']=='processed') || ($orderDetails['order_status']=='out_for_delivery') || ($orderDetails['order_status']=='delivered')?'active-status' : ''}}">
                                        <div class="d-flex flex-sm-column gap-3 gap-sm-0">
                                            <div class="media-tab-media mb-3 mx-sm-auto">
                                                <img
                                                    src="{{asset('/public/assets/front-end/img/track-order/order-confirmed.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="media-body">
                                                <div class="text-sm-center">
                                                    <h6 class="media-tab-title text-nowrap mb-0 text-capitalize fs-14">{{ translate('order_confirmed') }}</h6>
                                                </div>
                                                @if(($orderDetails['order_status']=='confirmed') || ($orderDetails['order_status']=='processing') || ($orderDetails['order_status']=='processed') || ($orderDetails['order_status']=='out_for_delivery') || ($orderDetails['order_status']=='delivered') && \App\Utils\order_status_history($orderDetails['id'],'confirmed'))
                                                    <div
                                                        class="d-flex align-items-center justify-content-sm-center mt-2 gap-1">
                                                        <img width="14" alt=""
                                                             src="{{asset('/public/assets/front-end/img/track-order/clock.png') }}">
                                                        <span class="text-muted fs-12">
                                                            {{date('h:i A, d M Y',strtotime(\App\Utils\order_status_history($orderDetails['id'],'confirmed')))}}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <div
                                        class="nav-link {{($orderDetails['order_status']=='processing') || ($orderDetails['order_status']=='processed') || ($orderDetails['order_status']=='out_for_delivery') || ($orderDetails['order_status']=='delivered')?'active-status' : ''}}">
                                        <div class="d-flex flex-sm-column gap-3 gap-sm-0">
                                            <div class="media-tab-media mb-3 mx-sm-auto">
                                                <img alt=""
                                                     src="{{asset('/public/assets/front-end/img/track-order/shipment.png') }}">
                                            </div>
                                            <div class="media-body">
                                                <div class="text-sm-center">
                                                    <h6 class="media-tab-title text-nowrap mb-0 text-capitalize fs-14">
                                                        {{ translate('preparing_shipment') }}
                                                    </h6>
                                                </div>
                                                @if( ($orderDetails['order_status']=='processing') || ($orderDetails['order_status']=='processed') || ($orderDetails['order_status']=='out_for_delivery') || ($orderDetails['order_status']=='delivered')  && \App\Utils\order_status_history($orderDetails['id'],'processing'))
                                                    <div
                                                        class="d-flex align-items-center justify-content-sm-center mt-2 gap-2">
                                                        <img width="14" alt=""
                                                             src="{{asset('/public/assets/front-end/img/track-order/clock.png') }}">
                                                        <span class="text-muted fs-12">
                                                            {{date('h:i A, d M Y',strtotime(\App\Utils\order_status_history($orderDetails['id'],'processing')))}}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <div
                                        class="nav-link {{($orderDetails['order_status']=='out_for_delivery') || ($orderDetails['order_status']=='delivered')?'active-status' : ''}}">
                                        <div class="d-flex flex-sm-column gap-3 gap-sm-0">
                                            <div class="media-tab-media mb-3 mx-sm-auto">
                                                <img
                                                    src="{{asset('/public/assets/front-end/img/track-order/on-the-way.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="media-body">
                                                <div class="text-sm-center">
                                                    <h6 class="media-tab-title text-nowrap mb-0 fs-14">{{ translate('order_is_on_the_way') }}</h6>
                                                </div>
                                                @if( ($orderDetails['order_status']=='out_for_delivery') || ($orderDetails['order_status']=='delivered') && \App\Utils\order_status_history($orderDetails['id'],'out_for_delivery'))
                                                    <div
                                                        class="d-flex align-items-center justify-content-sm-center mt-2 gap-2">
                                                        <img class="mx-1"
                                                             src="{{asset('/public/assets/front-end/img/track-order/clock.png') }}"
                                                             width="14" alt="">
                                                        <span class="text-muted fs-12">
                                                            {{date('h:i A, d M Y',strtotime(\App\Utils\order_status_history($orderDetails['id'],'out_for_delivery')))}}
                                                        </span>
                                                    </div>
                                                @else
                                                    <div class="mt-1">
                                                        <span class="d-flex justify-content-sm-center text-nowrap">
                                                            <span
                                                                class="text-muted fs-12 text-capitalize">{{translate('your_deliveryman_is_coming') }}</span>
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <div
                                        class="nav-link {{($orderDetails['order_status']=='delivered')?'active-status' : ''}}">
                                        <div class="d-flex flex-sm-column gap-3 gap-sm-0">
                                            <div class="media-tab-media mb-3 mx-sm-auto">
                                                <img
                                                    src="{{asset('/public/assets/front-end/img/track-order/delivered.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="media-body">
                                                <div class="text-sm-center">
                                                    <h6 class="media-tab-title text-nowrap mb-0 fs-14">{{ translate('order_Shipped') }}</h6>
                                                </div>
                                                @if(($orderDetails['order_status']=='delivered') && \App\Utils\order_status_history($orderDetails['id'],'delivered'))
                                                    <div
                                                        class="d-flex align-items-center justify-content-sm-center mt-2 gap-2">
                                                        <img
                                                            src="{{asset('/public/assets/front-end/img/track-order/clock.png') }}"
                                                            width="14" alt="">
                                                        <span class="text-muted fs-12">
                                                            {{date('h:i A, d M Y',strtotime(\App\Utils\order_status_history($orderDetails['id'],'delivered')))}}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @elseif($orderDetails['order_status']=='returned')
                                <li class="nav-item">
                                    <div class="nav-link text-center">
                                        <h1 class="text-warning text-capitalize">
                                            {{ translate('product_successfully_returned') }}
                                        </h1>
                                    </div>
                                </li>
                            @elseif($orderDetails['order_status']=='canceled')
                                <li class="nav-item">
                                    <div class="nav-link text-center">
                                        <h1 class="text-danger text-capitalize">
                                            {{ translate("your_order_has_been_canceled") }}
                                        </h1>
                                    </div>
                                </li>
                            @else
                                <li class="nav-item">
                                    <div class="nav-link text-center">
                                        <h1 class="text-danger text-capitalize">
                                            {{ translate("sorry_we_can_not_complete_your_order") }}
                                        </h1>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
