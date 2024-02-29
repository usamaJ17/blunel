@extends('layouts.back-end.app')

@section('title', translate('edit_Offline_Payment_Method'))

@section('content')
    <div class="content container-fluid">
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/3rd-party.png')}}" alt="">
                {{translate('3rd_party')}}
            </h2>
        </div>
        @include('admin-views.business-settings.third-party-inline-menu')
        <form action="{{ route('admin.business-settings.offline-payment-method.update',[$method['id']]) }}" method="POST" id="payment-method-offline">
            @csrf
            <div class="card mt-3">
                <div class="card-header gap-2 flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <img width="20" src="{{asset('/public/assets/back-end/img/payment-card.png')}}" alt="">
                        <h5 class="mb-0 text-capitalize">{{ translate('payment_information') }}</h5>
                    </div>
                    <a href="javascript:"  id="add-input-fields-group" class="btn btn--primary text-capitalize"><i class="tio-add"></i> {{ translate('add_new_field') }} </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4 col-sm-6">
                            <div class="form-group">
                                <label for="method_name" class="title_color text-capitalize">{{ translate('payment_method_name') }}</label>
                                <input type="text" class="form-control" placeholder="{{ translate('ex').':'.translate('bkash') }}" name="method_name" required value="{{ $method['method_name'] }}">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="{{ $method['id'] }}">
                    <div class="input-fields-section" id="input-fields-section">
                        @foreach ($method['method_fields'] as $key=>$item)
                            @php($inputFieldsRandomNumber = rand())
                            <div class="row align-items-end" id="{{ $inputFieldsRandomNumber }}">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="input_name" class="title_color">{{ translate('input_field_Name') }}</label>
                                        <input type="text" name="input_name[]" class="form-control"  placeholder="{{ translate('ex').':'.translate('bank_Name') }}" required value="{{ str_replace('_',' ',$item['input_name']) }} ">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="input_data" class="title_color text-cap">{{ translate('input_data') }}</label>
                                        <input type="text" name="input_data[]" class="form-control" placeholder="{{ translate('ex').':'.translate('AVC_bank') }}" required value="{{ $item['input_data'] }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-end">
                                            <a href="javascript:" class="btn btn-outline-danger btn-sm delete square-btn remove-input-fields-group" title="{{translate('delete')}}" data-id="{{ $inputFieldsRandomNumber }}">
                                                <i class="tio-delete"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header gap-2 flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <img width="20" src="{{asset('/public/assets/back-end/img/payment-card-fill.png')}}" alt="">
                        <h5 class="mb-0 text-capitalize">{{ translate('required_information_from_customer') }}</h5>
                    </div>
                    <a href="javascript:" id="add-customer-input-fields-group" class="btn btn--primary text-capitalize"><i class="tio-add"></i> {{ translate('add_new_field') }} </a>
                </div>
                <div class="card-body">
                    <div class="customer-input-fields-section" id="customer-input-fields-section">
                        @php($counter = count($method['method_informations']))
                        @foreach ($method['method_informations'] as $key=>$item)
                            @php($customerInputFieldsRandomNumber = rand())
                            <div class="row align-items-end" id="{{ $customerInputFieldsRandomNumber }}">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="title_color">{{ translate('input_field_Name') }}</label>
                                        <input type="text" name="customer_input[]" class="form-control" placeholder="{{ translate('ex').':'.translate('payment_By') }}"  required value="{{ str_replace('_',' ',$item['customer_input']) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="customer_placeholder" class="title_color">{{ translate('place_Holder') }}</label>
                                        <input type="text" name="customer_placeholder[]" class="form-control" placeholder="{{ translate('ex').':'.translate('enter_name') }}" required value="{{ $item['customer_placeholder'] }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between gap-2">
                                            <div class="form-check text-start mb-3">

                                                <label class="form-check-label text-dark" for="{{ $customerInputFieldsRandomNumber+1 }}">
                                                    <input type="checkbox" class="form-check-input" id="{{ $customerInputFieldsRandomNumber+1 }}" name="is_required[{{ $key }}]" {{ (isset($item['is_required']) && $item['is_required']) == 1 ? 'checked':'' }}> {{ translate('is_required').'?' }}
                                                </label>
                                            </div>

                                            <a class="btn btn-outline-danger btn-sm delete square-btn remove-input-fields-group" title="{{translate('delete')}}"  data-id="{{ $customerInputFieldsRandomNumber }}">
                                                <i class="tio-delete"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-3 mt-3">
                <button type="reset" class="btn btn-secondary px-5">{{ translate('reset') }}</button>
                <button type="submit" class="btn btn--primary px-5">{{ translate('submit') }}</button>
            </div>
        </form>
    </div>
    <span id="get-add-input-field-text"
          data-input-field-name = "{{translate('input_field_Name')}}"
          data-input-field-name-placeholder = "{{translate('ex').':'.translate('bank_Name')}}"
          data-input-data = "{{translate('input_data')}}"
          data-input-data-placeholder = "{{translate('ex').':'.translate('AVC_bank')}}"
          data-delete-text = "{{translate('delete')}}"
    ></span>
    <span id="get-add-customer-input-field-text"
          data-input-field-name = "{{translate('input_field_Name')}}"
          data-input-field-name-placeholder = "{{translate('ex').':'.translate('payment_By')}}"
          data-input-placeholder = "{{translate('placeholder')}}"
          data-input-placeholder-placeholder = "{{translate('ex').':'.translate('enter_name')}}"
          data-delete-text = "{{translate('delete')}}"
          data-require-text = "{{translate('is_required').'?'}}"
    ></span>
@endsection

@push('script')
    <script src="{{asset('public/assets/back-end/js/admin/business-setting/offline-payment.js')}}"></script>
@endpush
