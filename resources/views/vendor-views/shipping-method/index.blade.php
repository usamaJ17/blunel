@php
use Illuminate\Support\Facades\Session;
@endphp
@extends('layouts.back-end.app-seller')

@section('title', translate('add_Shipping'))

@section('content')
    @php($direction = Session::get('direction'))
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/public/assets/back-end/img/shipping_method.png')}}" alt="">
                {{translate('shipping_method')}}
            </h2>
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-capitalize mb-0 d-flex align-items-center gap-2">
                            <img width="20" src="{{asset('/public/assets/back-end/img/delivery.png')}}" alt="">
                            {{translate('shipping')}}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-capitalize" style="text-align: {{$direction === "rtl" ? 'right' : 'left'}};">
                                <select class="form-control text-capitalize w-100 shipping-type" name="shippingCategory">
                                    <option value="0" selected disabled>{{'---'.translate('select').'---'}}</option>
                                    <option
                                        value="order_wise" {{$shippingType=='order_wise'?'selected':'' }} >{{translate('order_wise')}} </option>
                                    <option
                                        value="category_wise" {{$shippingType=='category_wise'?'selected':'' }} >{{translate('category_wise')}}</option>
                                    <option
                                        value="product_wise" {{$shippingType=='product_wise'?'selected':'' }}>{{translate('product_wise')}}</option>
                                </select>
                            </div>
                            <div class="mt-2 mx-3" id="product_wise_note">
                                <p>
                                    <img width="16" class="mt-n1"
                                         src="{{asset('/public/assets/back-end/img/danger-info.png')}}" alt="">
                                    <strong>{{translate('note').' '.':'}}</strong>
                                    {{translate('please_make_sure_all_the product`s_delivery_charges_are_up_to_date').'.'}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="order_wise_shipping">
            <div class="card mt-2">
                <div class="card-header">
                    <h5 class="text-capitalize mb-0 d-flex align-items-center gap-2">
                        <img width="20" src="{{asset('/public/assets/back-end/img/delivery.png')}}" alt="">
                        {{translate('add_order_wise_shipping')}}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{route('vendor.business-settings.shipping-method.index')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-xl-4 col-md-6">
                                <div class="form-group">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <label class="title-color d-flex" for="title">{{translate('title')}}</label>
                                            <input type="text" name="title" class="form-control" placeholder="{{translate('title')}}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="form-group">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <label class="title-color d-flex" for="duration">{{translate('duration')}}</label>
                                            <input type="text" name="duration" class="form-control" placeholder="{{translate('ex').':'.translate('4_to_6_days')}}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="form-group">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <label class="title-color d-flex" for="cost">{{translate('cost')}}</label>
                                            <input type="number" min="0" step="0.01" max="1000000" name="cost" class="form-control" placeholder="{{translate('ex').':'.usdToDefaultCurrency('10')}}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-10">
                            <button type="submit" class="btn btn--primary px-5">{{translate('submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-2">
                <div class="px-3 py-4">
                    <h5 class="text-capitalize mb-0 d-flex align-items-center gap-2">
                        <img width="20" src="{{asset('/public/assets/back-end/img/delivery.png')}}" alt="">
                        {{translate('order_wise_shipping_method')}}
                        <span class="badge badge-soft-dark radius-50 fz-12">{{ $shippingMethods->count() }}</span>
                    </h5>
                </div>
                <div class="table-responsive">
                    <table id="datatable"
                           class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table text-start">
                        <thead class="thead-light thead-50 text-capitalize">
                        <tr>
                            <th>{{translate('SL')}}</th>
                            <th>{{translate('title')}}</th>
                            <th>{{translate('duration')}}</th>
                            <th>{{translate('cost')}}</th>
                            <th class="text-center">{{translate('status')}}</th>
                            <th class="text-center">{{translate('action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($shippingMethods as $k=>$method)
                            <tr>
                                <th>{{$shippingMethods->firstItem()+$k}}</th>
                                <td>{{$method['title']}}</td>
                                <td>
                                    {{$method['duration']}}
                                </td>
                                <td>
                                    {{setCurrencySymbol(amount: usdToDefaultCurrency(amount: $method['cost']), currencyCode: getCurrencyCode(type: 'default'))}}
                                </td>

                                <td>
                                    <form action="{{route('vendor.business-settings.shipping-method.update-status')}}" method="post" id="shipping-methods{{$method['id']}}-form" class="shipping_methods_form">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$method['id']}}">
                                        <label class="switcher mx-auto">
                                            <input type="checkbox" class="switcher_input toggle-switch-message"
                                                   id="shipping-methods{{$method['id']}}" name="status" value="1"
                                                   {{$method->status == 1 ? 'checked' : ''}}
                                                   data-modal-id = "toggle-status-modal"
                                                   data-toggle-id = "shipping-methods{{$method['id']}}"
                                                   data-on-image = "category-status-on.png"
                                                   data-off-image = "category-status-off.png"
                                                   data-on-title = "{{translate('want_to_Turn_ON_This_Shipping_Method').'?'}}"
                                                   data-off-title = "{{translate('want_to_Turn_OFF_This_Shipping_Method').'?'}}"
                                                   data-on-message = "<p>{{translate('if_you_enable_this_shipping_method_will_be_shown_in_the_user_app_and_website_for_customer_checkout')}}</p>"
                                                   data-off-message = "<p>{{translate('if_you_disable_this_shipping_method_will_not_be_shown_in_the_user_app_and_website_for_customer_checkout')}}</p>">
                                            <span class="switcher_control"></span>
                                        </label>
                                    </form>
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a  class="btn btn-outline--primary btn-sm square-btn"
                                            title="{{translate('edit')}}"
                                            href="{{route('vendor.business-settings.shipping-method.update',[$method['id']])}}">
                                            <i class="tio-edit"></i>
                                        </a>
                                        <a  class="btn btn-outline-danger btn-sm  delete-data-without-form"
                                            data-action="{{route('vendor.business-settings.shipping-method.delete')}}"
                                            data-id="{{ $method['id'] }}">
                                            <i class="tio-delete"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive mt-4">
                    <div class="px-4 d-flex justify-content-lg-end">
                        {!! $shippingMethods->links() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2" id="update_category_shipping_cost">
            <div class="px-3 pt-4">
                <h5 class="text-capitalize mb-0 d-flex align-items-center gap-2">
                    <img width="20" src="{{asset('/public/assets/back-end/img/delivery.png')}}" alt="">
                    {{translate('category_wise_shipping_cost')}}
                </h5>
            </div>
            <div class="card-body px-0">
                <div class="table-responsive">
                    <form action="{{route('vendor.business-settings.category-wise-shipping-cost.index')}}" method="POST">
                        @csrf
                        <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               style="text-align: {{$direction === "rtl" ? 'right' : 'left'}};">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{translate('SL')}}</th>
                                <th>{{translate('category_name')}}</th>
                                <th>{{translate('cost_per_product')}}</th>
                                <th class="text-center">{{translate('multiply_with_QTY')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php($serial = 0)
                                @foreach ($allCategoryShippingCost as $key=>$item)
                                    @if($item->category)
                                        <tr>
                                            <td>
                                                {{++$serial}}
                                            </td>
                                            <td>
                                                {{$item->category->name}}
                                            </td>
                                            <td>
                                                <input type="hidden" class="form-control w-auto" name="ids[]" value="{{$item->id}}">
                                                <input type="number" class="form-control w-auto" min="0" step="0.01" name="cost[]" value="{{usdToDefaultCurrency($item->cost)}}">
                                            </td>
                                            <td>
                                                <label class="switcher mx-auto">
                                                    <input type="checkbox" name="multiplyQTY[]" class="switcher_input"
                                                           id="" value="{{$item->id}}" {{$item->multiply_qty == 1?'checked':''}}>
                                                    <span class="switcher_control"></span>
                                                </label>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <td colspan="4">
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn--primary ">{{translate('save')}}</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <span id="get-shipping-type-data" data-action="{{route('vendor.business-settings.shipping-type.index')}}" data-success="{{translate('shipping_method_updated_successfully').'!!'}}"></span>
    <span id="get-shipping-type-value" data-value="{{$shippingType}}"></span>
@endsection
@push('script')
    <script src="{{asset('public/assets/back-end/js/vendor/shipping-method.js')}}"></script>
@endpush

