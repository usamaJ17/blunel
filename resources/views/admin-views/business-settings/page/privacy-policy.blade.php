@extends('layouts.back-end.app')

@section('title', translate('privacy_policy'))

@section('content')
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/Pages.png')}}" width="20" alt="">
                {{translate('pages')}}
            </h2>
        </div>
        @include('admin-views.business-settings.pages-inline-menu')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{translate('privacy_policy')}}</h5>
                    </div>
                    <form action="{{route('admin.business-settings.privacy-policy')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <textarea class="form-control" id="editor" name="value">{{$privacy_policy->value}}</textarea>
                            </div>
                            <div class="form-group">
                                <input class="form-control btn--primary" type="submit" value="{{translate('submit')}}" name="btn">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('/vendor/ckeditor/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('/vendor/ckeditor/ckeditor/adapters/jquery.js')}}"></script>
    <script>
        'use strict';
        $('#editor').ckeditor({
            contentsLangDirection : '{{Session::get('direction')}}',
        });
    </script>
@endpush

