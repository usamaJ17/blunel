@extends('layouts.back-end.app')
@section('title', translate('dashboard'))
@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    @if(auth('admin')->user()->admin_role_id==1 || \App\Utils\Helpers::module_permission_check('dashboard'))
        <div class="content container-fluid">

            <div class="page-header pb-0 mb-0 border-0">
                <div class="flex-between align-items-center">
                    <div>
                        <h1 class="page-header-title">{{translate('dashboard')}}</h1>
                        <p>{{ translate('welcome_message')}}.</p>
                    </div>
                </div>
            </div>

            <div class="card mb-2 remove-card-shadow">
                <div class="card-body">
                    <div class="row flex-between align-items-center g-2 mb-3">
                        <div class="col-sm-6">
                            <h4 class="d-flex align-items-center text-capitalize gap-10 mb-0">
                                <img src="{{asset('/public/assets/back-end/img/business_analytics.png')}}"
                                     alt="">{{translate('business_analytics')}}</h4>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-sm-end">
                            <select class="custom-select w-auto" name="statistics_type" id="statistics_type">
                                <option
                                        value="overall" {{session()->has('statistics_type') && session('statistics_type') == 'overall'?'selected':''}}>
                                    {{ translate('overall_statistics')}}
                                </option>
                                <option
                                        value="today" {{session()->has('statistics_type') && session('statistics_type') == 'today'?'selected':''}}>
                                    {{ translate("todays_Statistics")}}
                                </option>
                                <option
                                        value="this_month" {{session()->has('statistics_type') && session('statistics_type') == 'this_month'?'selected':''}}>
                                    {{ translate("this_Months_Statistics")}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-2" id="order_stats">
                        @include('admin-views.partials._dashboard-order-stats',['data'=>$data])
                    </div>
                </div>
            </div>

            <div class="card mb-3 remove-card-shadow">
                <div class="card-body">
                    <h4 class="d-flex align-items-center text-capitalize gap-10 mb-3">
                        <img width="20" class="mb-1" src="{{asset('/public/assets/back-end/img/admin-wallet.png')}}"
                             alt="">
                        {{translate('admin_wallet')}}
                    </h4>

                    <div class="row g-2" id="order_stats">
                        @include('admin-views.partials._dashboard-wallet-stats',['data'=>$data])
                    </div>
                </div>
            </div>

            <div class="row g-1">
                <div class="col-12">

                    <div class="card remove-card-shadow">

                        <div class="card-body">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-6">
                                    <h4 class="d-flex align-items-center text-capitalize gap-10 mb-0">
                                        <img src="{{asset('/public/assets/back-end/img/earning_statictics.png')}}"
                                             alt="">
                                        {{translate('earning_statistics')}}
                                    </h4>
                                </div>
                                <div class="col-md-6 d-flex justify-content-md-end">
                                    <ul class="option-select-btn">
                                        <li>
                                            <label class="basic-box-shadow">
                                                <input type="radio" name="statistics2" hidden="" checked="">
                                                <span data-earn-type="yearEarn" class="earning-statistics">{{translate('this_Year')}}</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="basic-box-shadow">
                                                <input type="radio" name="statistics2" hidden="">
                                                <span data-earn-type="MonthEarn" class="earning-statistics">{{translate('this_Month')}}</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="basic-box-shadow">
                                                <input type="radio" name="statistics2" hidden="">
                                                <span data-earn-type="WeekEarn" class="earning-statistics">{{translate('this_Week')}}</span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="chartjs-custom mt-2" id="set-new-graph">
                                <canvas id="updatingData"
                                        data-hs-chartjs-options='{
                                            "type": "bar",
                                            "data": {
                                              "labels": ["Jan","Feb","Mar","April","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                                              "datasets": [{
                                                "label": "{{translate('in-house')}}",
                                                "data": [{{$inhouseEarningStatisticsData[1]}},{{$inhouseEarningStatisticsData[2]}},{{$inhouseEarningStatisticsData[3]}},{{$inhouseEarningStatisticsData[4]}},{{$inhouseEarningStatisticsData[5]}},{{$inhouseEarningStatisticsData[6]}},{{$inhouseEarningStatisticsData[7]}},{{$inhouseEarningStatisticsData[8]}},{{$inhouseEarningStatisticsData[9]}},{{$inhouseEarningStatisticsData[10]}},{{$inhouseEarningStatisticsData[11]}},{{$inhouseEarningStatisticsData[12]}}],
                                                "backgroundColor": "#ACDBAB",
                                                "hoverBackgroundColor": "#ACDBAB",
                                                "borderColor": "#ACDBAB"
                                              },
                                              {
                                                "label": "{{translate('vendor')}}",
                                                "data": [{{$sellerEarningStatisticsData[1]}},{{$sellerEarningStatisticsData[2]}},{{$sellerEarningStatisticsData[3]}},{{$sellerEarningStatisticsData[4]}},{{$sellerEarningStatisticsData[5]}},{{$sellerEarningStatisticsData[6]}},{{$sellerEarningStatisticsData[7]}},{{$sellerEarningStatisticsData[8]}},{{$sellerEarningStatisticsData[9]}},{{$sellerEarningStatisticsData[10]}},{{$sellerEarningStatisticsData[11]}},{{$sellerEarningStatisticsData[12]}}],
                                                "backgroundColor": "#0177CD",
                                                "borderColor": "#0177CD"
                                              },
                                              {
                                                "label": "{{translate('commission')}}",
                                                "data": [{{$commissionEarningStatisticsData[1]}},{{$commissionEarningStatisticsData[2]}},{{$commissionEarningStatisticsData[3]}},{{$commissionEarningStatisticsData[4]}},{{$commissionEarningStatisticsData[5]}},{{$commissionEarningStatisticsData[6]}},{{$commissionEarningStatisticsData[7]}},{{$commissionEarningStatisticsData[8]}},{{$commissionEarningStatisticsData[9]}},{{$commissionEarningStatisticsData[10]}},{{$commissionEarningStatisticsData[11]}},{{$commissionEarningStatisticsData[12]}}],
                                                "backgroundColor": "#FFB36D",
                                                "borderColor": "#FFB36D"
                                              }]
                                            },
                                            "options": {
                                                "legend": {
                                                    "display": true,
                                                    "position": "top",
                                                    "align": "center",
                                                    "labels": {
                                                        "fontColor": "#758590",
                                                        "fontSize": 14
                                                    }
                                                },
                                                "scales": {
                                                    "yAxes": [{
                                                    "gridLines": {
                                                        "color": "rgba(180, 208, 224, 0.5)",
                                                        "borderDash": [8, 4],
                                                        "drawBorder": false,
                                                        "zeroLineColor": "rgba(180, 208, 224, 0.5)"
                                                    },
                                                    "ticks": {
                                                        "beginAtZero": true,
                                                        "fontSize": 12,
                                                        "fontColor": "#5B6777",
                                                        "padding": 10,
                                                        "postfix": " {{ getCurrencySymbol(currencyCode: getCurrencyCode()) }}"
                                                    }
                                                    }],
                                                    "xAxes": [{
                                                    "gridLines": {
                                                        "color": "rgba(180, 208, 224, 0.5)",
                                                        "display": true,
                                                        "drawBorder": true,
                                                        "zeroLineColor": "rgba(180, 208, 224, 0.5)"
                                                    },
                                                    "ticks": {
                                                        "fontSize": 12,
                                                        "fontColor": "#5B6777",
                                                        "fontFamily": "Open Sans, sans-serif",
                                                        "padding": 5
                                                    },
                                                    "categoryPercentage": 0.5,
                                                    "maxBarThickness": "7"
                                                    }]
                                                },
                                                "cornerRadius": 3,
                                                "tooltips": {
                                                    "prefix": " ",
                                                    "hasIndicator": true,
                                                    "mode": "index",
                                                    "intersect": false
                                                },
                                                "hover": {
                                                    "mode": "nearest",
                                                    "intersect": true
                                                }
                                            }
                                  }'></canvas>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="col-md-6 col-xl-4">

                    <div class="card h-100 remove-card-shadow">
                        @include('admin-views.partials._top-customer',['top_customer'=>$data['top_customer']])
                    </div>

                </div>


                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 remove-card-shadow">
                        @include('admin-views.partials._top-store-by-order',['top_store_by_order_received'=>$data['top_store_by_order_received']])
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 remove-card-shadow">
                        @include('admin-views.partials._top-selling-store',['topVendorByEarning'=>$data['topVendorByEarning']])
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 remove-card-shadow">
                        @include('admin-views.partials._most-rated-products',['mostRatedProducts'=>$data['mostRatedProducts']])
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 remove-card-shadow">
                        @include('admin-views.partials._top-selling-products',['topSellProduct'=>$data['topSellProduct']])
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 remove-card-shadow">
                        @include('admin-views.partials._top-delivery-man',['topRatedDeliveryMan'=>$data['topRatedDeliveryMan']])
                    </div>
                </div>

            </div>
        </div>
    @else
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-12 mb-2 mb-sm-0">
                        <h3 class="text-center">{{translate('hi')}} {{auth('admin')->user()->name}}
                            , {{translate('welcome_to_dashboard')}}.</h3>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <span id="earning-statistics-url" data-url="{{ route('admin.dashboard.earning-statistics') }}"></span>
    <span id="order-status-url" data-url="{{ route('admin.dashboard.order-status') }}"></span>
    <span id="seller-text" data-text="{{ translate('vendor')}}"></span>
    <span id="message-commission-text" data-text="{{ translate('commission')}}"></span>
    <span id="in-house-text" data-text="{{ translate('In-house')}}"></span>
    <span id="customer-text" data-text="{{ translate('customer')}}"></span>
    <span id="store-text" data-text="{{ translate('store')}}"></span>
    <span id="product-text" data-text="{{ translate('product')}}"></span>
    <span id="order-text" data-text="{{ translate('order')}}"></span>
    <span id="brand-text" data-text="{{ translate('brand')}}"></span>
    <span id="business-text" data-text="{{ translate('business')}}"></span>
    <span id="orders-text" data-text="{{ $data['order'] }}"></span>
@endsection

@push('script')
    <script src="{{asset('public/assets/back-end/vendor/chart.js/dist/Chart.min.js')}}"></script>
    <script src="{{asset('public/assets/back-end/vendor/chart.js.extensions/chartjs-extensions.js')}}"></script>
    <script src="{{asset('public/assets/back-end/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js')}}"></script>
@endpush

@push('script_2')
    <script src="{{asset('public/assets/back-end/js/admin/dashboard.js')}}"></script>
@endpush

