@extends('layouts.back-end.app')
@section('title', translate('about_us'))
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
                    <h5 class="mb-0">{{translate('about_us')}}</h5>
                </div>
                <form action="{{route('admin.business-settings.about-update')}}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <textarea name="about_us" id="editor" cols="30" rows="20" class="form-control">{{ $pageData['value'] }}</textarea>
                        </div>
                        <div class="form-group mb-2">
                            <input class="btn btn--primary btn-block" type="submit" name="btn" value="{{ translate('submit') }}">
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
