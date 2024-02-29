@php use Illuminate\Support\Facades\Session; @endphp
@extends('layouts.back-end.app')
@section('title', translate('payment_Method'))
@section('content')
    @php($direction = Session::get('direction') === "rtl" ? 'right' : 'left')
    <div class="content container-fluid">
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/3rd-party.png')}}" alt="">
                {{translate('3rd_party')}}
            </h2>
        </div>
        @include('admin-views.business-settings.third-party-inline-menu')
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{route('admin.business-settings.payment-method.update')}}"
                        style="text-align: {{$direction}};"
                        method="post">
                    @csrf
                    <h5 class="mb-4 text-uppercase d-flex text-capitalize">{{translate('payment_methods')}}</h5>
                    <div class="row">
                        @isset($cashOnDelivery)
                        <div class="col-xl-4 col-sm-6">
                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center gap-10 form-control">
                                    <span class="title-color">
                                        {{translate('cash_on_delivery')}}
                                        <span class="input-label-secondary cursor-pointer" data-toggle="tooltip" data-placement="top" title="{{translate('if_enabled,_the_cash_on_delivery_option_will_be_available_on_the_system._Customers_can_use_COD_as_a_payment_option').'.'}}">
                                            <img width="16" src="{{asset('/public/assets/back-end/img/info-circle.svg')}}" alt="">
                                        </span>
                                    </span>
                                    <label class="switcher" for="cash-on-delivery">
                                        <input type="checkbox" class="switcher_input toggle-switch-message" name="cash_on_delivery"
                                               id="cash-on-delivery" value="1" {{ $cashOnDelivery['status'] == 1 ? 'checked' : ''}}
                                               data-modal-id = "toggle-modal"
                                               data-toggle-id = "cash-on-delivery"
                                               data-on-image = "cod-on.png"
                                               data-off-image = "cod-off.png"
                                               data-on-title = "{{translate('want_to_Turn_ON_the_Cash_On_Delivery_option')}}"
                                               data-off-title = "{{translate('want_to_Turn_OFF_the_Cash_On_Delivery_option')}}"
                                               data-on-message = "<p>{{translate('if_enabled_customers_can_select_Cash_on_Delivery_as_a_payment_method_during_checkout')}}</p>"
                                               data-off-message = "<p>{{translate('if_disabled_the_Cash_on_Delivery_payment_method_will_be_hidden_from_the_checkout_page')}}</p>">
                                        <span class="switcher_control"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endisset
                        @isset($digitalPayment)
                        <div class="col-xl-4 col-sm-6">
                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center gap-10 form-control">
                                    <span class="title-color">
                                        {{translate('digital_payment')}}
                                        <span class="input-label-secondary cursor-pointer" data-toggle="tooltip" data-placement="top" title="{{translate('if_enabled,_customers_can_choose_digital_payment_options_during_the_checkout_process')}}">
                                            <img width="16" src="{{asset('/public/assets/back-end/img/info-circle.svg')}}" alt="">
                                        </span>
                                    </span>

                                    <label class="switcher" for="digital-payment">
                                        <input type="checkbox" class="switcher_input toggle-switch-message" name="digital_payment"
                                               id="digital-payment" value="1" {{$digitalPayment['status']==1?'checked':''}}
                                               data-modal-id = "toggle-modal"
                                               data-toggle-id = "digital-payment"
                                               data-on-image = "digital-payment-on.png"
                                               data-off-image = "digital-payment-off.png"
                                               data-on-title = "{{translate('want_to_Turn_ON_the_Digital_Payment_option')}}"
                                               data-off-title = "{{translate('want_to_Turn_OFF_the_Digital_Payment_option')}}"
                                               data-on-message = "<p>{{translate('if_enabled_customers_can_select_Digital_Payment_during_checkout')}}</p>"
                                               data-off-message = "<p>{{translate('if_disabled_Digital_Payment_options_will_be_hidden_from_the_checkout_page')}}</p>">
                                        <span class="switcher_control"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endisset
                        @isset($offlinePayment)
                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group">
                                    <div class="d-flex justify-content-between align-items-center gap-10 form-control">
                                        <span class="title-color">
                                            {{translate('offline_payment')}}
                                            <span class="input-label-secondary cursor-pointer" data-toggle="tooltip" data-placement="top" title="{{translate('offline_Payment_allows_customers_to_use_external_payment_methods._They_must_share_payment_details_with_the_vendor_afterward._Admin_can_set_whether_customers_can_make_offline_payments_by_enabling/disabling_this_button.
                                            ')}}">
                                                <img width="16" src="{{asset('/public/assets/back-end/img/info-circle.svg')}}" alt="">
                                            </span>
                                        </span>

                                        <label class="switcher" for="offline-payment">
                                            <input type="checkbox" class="switcher_input toggle-switch-message" name="offline_payment"
                                                   id="offline-payment" value="1" {{$offlinePayment['status']== 1 ? 'checked' : ''}}
                                                   data-modal-id = "toggle-modal"
                                                   data-toggle-id = "offline-payment"
                                                   data-on-image = "digital-payment-on.png"
                                                   data-off-image = "digital-payment-off.png"
                                                   data-on-title = "{{translate('want_to_Turn_ON_the_Offline_Payment_option')}}"
                                                   data-off-title = "{{translate('want_to_Turn_OFF_the_Offline_Payment_option')}}"
                                                   data-on-message = "<p>{{translate('if_enabled_customers_can_pay_through_external_payment_methods')}}</p>"
                                                   data-off-message = "<p>{{translate('if_disabled_customers_have_to_use_the_system_added_payment_gateways')}}</p>">
                                            <span class="switcher_control"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endisset
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn--primary px-5 text-uppercase">{{translate('save')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if($paymentGatewayPublishedStatus)
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body d-flex justify-content-around  align-items-center">
                        <h4 class="text-danger bg-transparent m-0">
                            <i class="tio-info-outined"></i>
                            {{ translate('your_current_payment_settings_are_disabled,because_you_have_enabled_payment_gateway_addon').' '.translate('To_visit_your_currently_active_payment_gateway_settings_please_follow_the_link').'.' }}
                        </h4>
                        <span>
                            <a href="{{!empty($paymentUrl) ? $paymentUrl : ''}}" class="btn btn-outline-primary"><i class="tio-settings mr-1"></i>{{translate('settings')}}</a>
                        </span>
                    </div>
                </div>
            </div>
        @endif
        <div class="row gy-3" id="payment-gateway-cards">
            @foreach($paymentGatewaysList as $key=> $gateway)
                <div class="col-md-6">
                    <div class="card">
                        <form action="{{route('admin.business-settings.payment-method.addon-payment-set')}}" method="POST"
                              id="{{$gateway->key_name}}-form" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="card-header d-flex flex-wrap align-content-around">
                                <h5>
                                    <span class="text-uppercase">{{str_replace('_',' ',$gateway->key_name)}}</span>
                                </h5>
                                @php($additional_data = $gateway['additional_data'] != null ? json_decode($gateway['additional_data']) : [])
                                <?php
                                    if ($additional_data != null){
                                        $img_path = $additional_data->gateway_image ? asset('storage/app/public/payment_modules/gateway_image/'.$additional_data->gateway_image) : '';
                                    }else{
                                        $img_path = asset('/public/assets/back-end/img/modal/payment-methods/'.$gateway->key_name.'.png');
                                    }
                                ?>
                                <label class="switcher show-status-text">
                                    <input class="switcher_input toggle-switch-dynamic-image" type="checkbox" name="status" value="1"
                                           id="{{$gateway->key_name}}" {{$gateway['is_active'] == 1?'checked':''}}
                                           data-modal-id = "toggle-modal"
                                           data-toggle-id = "{{$gateway->key_name}}"
                                           data-on-image = "{{ $img_path }}"
                                           data-off-image = "{{ $img_path }}"
                                           data-on-title = "{{translate('want_to_Turn_ON_')}}{{str_replace('_',' ',strtoupper($gateway->key_name))}}{{translate('_as_the_Digital_Payment_method').'?'}}"
                                           data-off-title = "{{translate('want_to_Turn_OFF_')}}{{str_replace('_',' ',strtoupper($gateway->key_name))}}{{translate('_as_the_Digital_Payment_method').'?'}}"
                                           data-on-message = "<p>{{translate('if_enabled_customers_can_use_this_payment_method')}}</p>"
                                           data-off-message = "<p>{{translate('if_disabled_this_payment_method_will_be_hidden_from_the_checkout_page')}}</p>">
                                    <span class="switcher_control" data-ontitle="{{ translate('on') }}" data-offtitle="{{ translate('off') }}"></span>
                                </label>
                            </div>
                            <div class="card-body">
                                <div class="payment--gateway-img">
                                    <img class="height-80px" id="gateway-image-{{$gateway->key_name}}"
                                         src="{{ getValidImage(path:'storage/app/public/payment_modules/gateway_image/'.($additional_data->gateway_image ?? ''), type: 'backend-payment' ) }}"
                                         alt="{{translate('public')}}">
                                </div>
                                <input name="gateway" value="{{$gateway->key_name}}" class="d-none">
                                @php($mode = $gateway->live_values['mode'])
                                <div class="form-group mb-10px" >
                                    <select class="js-example-responsive form-control" name="mode">
                                        <option value="live" {{$mode=='live'?'selected':''}}>{{translate('live')}}</option>
                                        <option value="test" {{$mode=='test'?'selected':''}}>{{translate('test')}}</option>
                                    </select>
                                </div>
                                @if($gateway->key_name === 'paystack')
                                    @php($skip=['gateway','mode','status','callback_url'])
                                @else
                                    @php($skip=['gateway','mode','status'])
                                @endif
                                @foreach($gateway->live_values as $gatewayKey => $value)
                                    @if(!in_array($gatewayKey , $skip))
                                        <div class="form-group mb-10px">
                                            <label for="exampleFormControlInput1"
                                                   class="form-label">{{ucwords(str_replace('_',' ',$gatewayKey))}}
                                                   <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                   name="{{$gatewayKey}}"
                                                   placeholder="{{ucwords(str_replace('_',' ',$gatewayKey))}} *"
                                                   value="{{env('APP_ENV')=='demo'?'':$value}}">
                                        </div>
                                    @endif
                                @endforeach
                                <div class="form-group mb-10px" >
                                    <label for="exampleFormControlInput1"
                                           class="form-label">{{translate('payment_gateway_title')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"
                                           name="gateway_title"
                                           placeholder="{{translate('payment_gateway_title')}}"
                                           value="{{$additional_data != null ? $additional_data->gateway_title : ''}}" required>
                                </div>

                                <div class="form-group mb-10px" >
                                    <label for="exampleFormControlInput1"
                                           class="form-label text-capitalize">{{translate('choose_logo')}} </label>
                                    <input type="file" class="form-control image-input" name="gateway_image" accept=".jpg, .png, .jpeg|image/*" data-image-id="gateway-image-{{$gateway->key_name}}" >
                                </div>
                                <div class="text-right mb-20px">
                                    <button type="submit" class="btn btn-primary px-5">{{translate('save')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict';
        @if($paymentGatewayPublishedStatus)
            let paymentGatewayCards = $('#payment-gateway-cards');
            paymentGatewayCards.find('input').each(function () {
                $(this).attr('disabled', true);
            });
            paymentGatewayCards.find('select').each(function () {
                $(this).attr('disabled', true);
            });
            paymentGatewayCards.find('.switcher_input').each(function () {
                $(this).removeAttr('checked', true);
            });
            paymentGatewayCards.find('button').each(function () {
                $(this).attr('disabled', true);
            });
        @endif
    </script>
@endpush
