@extends('layouts.back-end.app')

@section('title', translate('withdraw_Request'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/public/assets/back-end/img/withdraw-icon.png')}}" alt="">
                {{translate('withdraw_Request')}}
            </h2>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row align-items-center">
                            <div class="col-lg-4">
                                <h5>
                                    {{ translate('withdraw_Request_Table')}}
                                    <span
                                        class="badge badge-soft-dark radius-50 fz-12 ml-1">{{ $withdrawRequests->total() }}</span>
                                </h5>
                                <form action="http://localhost/6valley/seller/product/list" method="GET">
                                </form>
                            </div>
                            <div class="col-lg-8 mt-3 mt-lg-0 d-flex gap-3 justify-content-lg-end">
                                <button type="button" class="btn btn-outline--primary text-nowrap"
                                        data-toggle="dropdown">
                                    <i class="tio-download-to"></i>
                                    {{ translate('export') }}
                                    <i class="tio-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a class="dropdown-item"
                                           href="{{route('admin.delivery-man.withdraw-list-export',['approved'=>request('approved')])}}">
                                            <img width="14" src="{{asset('/public/assets/back-end/img/excel.png')}}"
                                                 alt="">
                                            {{translate('excel')}}
                                        </a>
                                    </li>
                                </ul>

                                <select name="delivery_withdraw_status_filter" id="delivery_withdraw_status_filter"
                                        data-url="{{ url()->current() }}" class="custom-select min-w-120 max-w-200">
                                    <option
                                        value="all" {{ request('approved') == 'all'?'selected':''}}>{{translate('all')}}</option>
                                    <option
                                        value="approved" {{ request('approved') == 'approved' ?'selected':''}}>{{translate('approved')}}</option>
                                    <option
                                        value="denied" {{ request('approved') == 'denied'?'selected':''}}>{{translate('denied')}}</option>
                                    <option
                                        value="pending" {{ request('approved') == 'pending'?'selected':''}}>{{translate('pending')}}</option>
                                </select>

                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="datatable"
                               class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{translate('SL')}}</th>
                                <th>{{translate('amount')}}</th>
                                <th>{{translate('name') }}</th>
                                <th>{{translate('request_time')}}</th>
                                <th class="text-center">{{translate('status')}}</th>
                                <th class="text-center">{{translate('action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($withdrawRequests as $k=>$withdraw)
                                <tr>
                                    <td>{{$withdrawRequests->firstItem()+$k}}</td>
                                    <td>{{setCurrencySymbol(amount: usdToDefaultCurrency(amount: $withdraw['amount']), currencyCode: getCurrencyCode())}}</td>

                                    <td>
                                        @if ($withdraw->deliveryMan)
                                            <span
                                                class="title-color hover-c1">{{ $withdraw->deliveryMan->f_name . ' ' . $withdraw->deliveryMan->l_name }}</span>
                                        @else
                                            <span>{{translate('not_found')}}</span>
                                        @endif
                                    </td>
                                    <td>{{ date_format( $withdraw->created_at, 'd-M-Y, h:i:s A') }}</td>
                                    <td class="text-center">
                                        @if($withdraw->approved==0)
                                            <label class="badge badge-soft-primary">{{translate('pending')}}</label>
                                        @elseif($withdraw->approved==1)
                                            <label class="badge badge-soft-success">{{translate('approved')}}</label>
                                        @else
                                            <label class="badge badge-soft-danger">{{translate('denied')}}</label>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @if (isset($withdraw->deliveryMan))
                                                <a href="{{route('admin.delivery-man.withdraw-view',[$withdraw['id']])}}"
                                                   class="btn btn-outline-info btn-sm square-btn"
                                                   title="{{translate('view')}}">
                                                    <i class="tio-invisible"></i>
                                                </a>
                                            @else
                                                <a class="btn btn-outline-info btn-sm square-btn disabled" href="#">
                                                    <i class="tio-invisible"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if(count($withdrawRequests)==0)
                            <div class="text-center p-4">
                                <img class="mb-3 w-160"
                                     src="{{asset('public/assets/back-end/svg/illustrations/sorry.svg')}}"
                                     alt="{{translate('image_description')}}">
                                <p class="mb-0">{{translate('no_data_to_show')}}</p>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-center justify-content-md-end">
                            {{$withdrawRequests->links()}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('script_2')
    <script src="{{asset('public/assets/back-end/js/admin/deliveryman.js')}}"></script>
@endpush
