@extends('layouts.back-end.app')
@section('title', translate('contact_List'))
@section('content')
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/public/assets/back-end/img/message.png')}}" alt="">
                {{translate('customer_message')}}
            </h2>
        </div>
        <div class="row mt-20">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center flex-grow-1">
                            <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                                <h5 class="d-flex gap-2 align-items-center">
                                    {{translate('customer_message_table')}}
                                    <span
                                        class="badge badge-soft-dark radius-50 fz-12">{{ $contacts->total() }}
                                    </span>
                                </h5>
                            </div>
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-merge input-group-custom">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="searchValue" class="form-control"
                                               placeholder="{{translate('search_by_Name_or_Mobile_No_or_Email')}}"
                                               aria-label="Search orders" value="{{ request('searchValue') }}">
                                        <button type="submit"
                                                class="btn btn--primary">{{translate('search')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="datatable"
                               style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                               class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{translate('SL')}}</th>
                                <th>{{translate('customer_Name')}}</th>
                                <th>{{translate('contact_Info')}}</th>
                                <th>{{translate('subject')}}</th>
                                <th class="text-center">{{translate('action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contacts as $key => $contact)
                                <tr style="background: {{$contact->seen==0?'rgba(215,214,214,0.56)':'white'}}">
                                    <td>{{$contacts->firstItem()+$key}}</td>
                                    <td>{{$contact['name']}}</td>
                                    <td>
                                        <div>
                                            <div>{{$contact['mobile_number']}}</div>
                                            <div>{{$contact['email']}}</div>
                                        </div>
                                    </td>
                                    <td class="text-wrap">{{$contact['subject']}}</td>
                                    <td>
                                        <div class="d-flex gap-10 justify-content-center">
                                            <a title="{{translate('view')}}"
                                               class="btn btn-outline-info btn-sm square-btn"
                                               href="{{route('admin.contact.view',$contact->id)}}">
                                                <i class="tio-invisible"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm delete delete-data-without-form"
                                               data-id="{{$contact['id']}}"
                                               data-action="{{route('admin.contact.delete')}}"
                                               title="{{ translate('delete')}}">
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
                            {{$contacts->links()}}
                        </div>
                    </div>
                    @if(count($contacts)==0)
                        <div class="text-center p-4">
                            <img class="mb-3 w-160"
                                 src="{{asset('public/assets/back-end/svg/illustrations/sorry.svg')}}"
                                 alt="{{translate('image_description')}}">
                            <p class="mb-0">{{translate('no_data_to_show')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
