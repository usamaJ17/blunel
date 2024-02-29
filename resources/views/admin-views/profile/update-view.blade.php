@extends('layouts.back-end.app')

@section('title', translate('profile_Settings'))

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <h2 class="col-sm mb-2 mb-sm-0 h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                    <img width="20" src="{{asset('/public/assets/back-end/img/profile_setting.png')}}" alt="">
                    {{translate('settings')}}
                </h2>
                <div class="col-sm-auto">
                    <a class="btn btn--primary" href="{{route('admin.dashboard')}}">
                        <i class="tio-home mr-1"></i> {{translate('dashboard')}}
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3">
                <div class="navbar-vertical navbar-expand-lg mb-3 mb-lg-5">
                    <button type="button" class="navbar-toggler btn btn-block btn-white mb-3"
                            aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarVerticalNavMenu"
                            data-toggle="collapse" data-target="#navbarVerticalNavMenu">
                <span class="d-flex justify-content-between align-items-center">
                  <span class="h5 mb-0">{{translate('nav_menu')}}</span>
                  <span class="navbar-toggle-default">
                    <i class="tio-menu-hamburger"></i>
                  </span>
                  <span class="navbar-toggle-toggled">
                    <i class="tio-clear"></i>
                  </span>
                </span>
                    </button>
                    <div id="navbarVerticalNavMenu" class="collapse navbar-collapse">
                        <ul id="navbarSettings"
                            class="js-sticky-block js-scrollspy navbar-nav navbar-nav-lg nav-tabs card card-navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" href="javascript:" id="general-section">
                                    <i class="tio-user-outlined nav-icon"></i>{{translate('basic_Information')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:" id="password-section">
                                    <i class="tio-lock-outlined nav-icon"></i> {{translate('password')}}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <form action="{{route('admin.profile.update',[$admin->id])}}" method="post" enctype="multipart/form-data" id="admin-profile-form">
                @csrf
                    <div class="card mb-3 mb-lg-5" id="general-div">
                        <div class="profile-cover">
                            @php($banner = !empty($shopBanner) ? asset('storage/app/public/shop/'.$shopBanner) : asset('public/assets/back-end/img/1920x400/img2.jpg'))
                            <div class="profile-cover-img-wrapper profile-bg" style="background-image: url({{ $banner }})"></div>
                        </div>
                        <label
                            class="avatar avatar-xxl avatar-circle avatar-border-lg avatar-uploader profile-cover-avatar"
                            for="custom-file-upload">
                            <img id="viewer"
                                 src="{{ getValidImage(path:'storage/app/public/admin/'.$admin->image,type: 'backend-profile')}}"
                                 class="avatar-img"
                                 alt="{{translate('image')}}">
                        </label>
                    </div>
                    <div class="card mb-3 mb-lg-5">
                        <div class="card-header">
                            <h2 class="card-title h4 text-capitalize">{{translate('basic_information')}}</h2>
                        </div>
                        <div class="card-body">
                            <div class="row form-group">
                                <label for="firstNameLabel" class="col-sm-3 col-form-label input-label">
                                    {{translate('full_name')}}
                                    <i class="tio-help-outlined text-body ml-1"
                                        title="{{ translate('display_name') }}">
                                    </i>
                                </label>

                                <div class="col-sm-9">
                                    <div class="input-group input-group-sm-down-break">
                                        <input type="text" class="form-control" name="name" id="firstNameLabel"
                                               placeholder="{{translate('your_first_name')}}" aria-label="Your first name"
                                               value="{{$admin->name}}">

                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="phoneLabel" class="col-sm-3 col-form-label input-label">{{translate('phone')}} <span
                                        class="input-label-secondary">({{translate('optional')}})</span></label>

                                <div class="col-sm-9">
                                    <input type="text" class="js-masked-input form-control" name="phone" id="phoneLabel"
                                           placeholder="{{translate('+x(xxx)xxx-xx-xx')}}"
                                           value="{{$admin->phone}}">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="newEmailLabel" class="col-sm-3 col-form-label input-label">{{translate('email')}}</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email" id="newEmailLabel"
                                           value="{{$admin->email}}"
                                           placeholder="{{translate('enter_new_email_address')}}">
                                </div>
                            </div>
                            <div class="row">
                                <label for="newEmailLabel" class="col-sm-3 input-label text-capitalize">{{translate('profile_image')}}</label>
                                <div class="form-group col-md-9" id="select-img">
                                    <span class="d-block mb-2 text-info">( {{translate('ratio').' '.'1:1'}})</span>
                                    <div class="custom-file">
                                        <input type="file" name="image" id="custom-file-upload" data-image-id="viewer" class="custom-file-input  image-input"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label text-capitalize" for="custom-file-upload">{{translate('image_upload')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" data-id="admin-profile-form" data-message="{{translate('want_to_update_admin_info').'?'}}" class="btn btn--primary {{env('APP_MODE')!='demo'?'form-alert':'call-demo'}}">{{translate('save_changes')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="password-div" class="card mb-3 mb-lg-5">
                    <div class="card-header">
                        <h4 class="card-title">{{translate('change_your_password')}}</h4>
                    </div>
                    <div class="card-body">
                        <form id="change-password-form" action="{{route('admin.profile.update',[$admin->id])}}" method="post"
                              enctype="multipart/form-data">
                        @csrf @method('patch')
                            <div class="row form-group">
                                <label for="newPassword" class="col-sm-3 col-form-label input-label"> {{translate('new_password')}}</label>

                                <div class="col-sm-9">
                                    <input type="password" class="js-pwstrength form-control" name="password"
                                           id="newPassword" placeholder="{{translate('enter_new_password')}}">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="confirmNewPasswordLabel" class="col-sm-3 col-form-label input-label"> {{translate('confirm_password')}} </label>

                                <div class="col-sm-9">
                                    <div class="mb-3">
                                        <input type="password" class="form-control" name="confirm_password"
                                               id="confirmNewPasswordLabel" placeholder="{{translate('confirm_your_new_password')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" data-id="change-password-form" data-message="{{translate('want_to_update_admin_password').'?'}}" class="btn btn--primary {{env('APP_MODE')!='demo'?'form-alert':'call-demo'}}">{{translate('save_changes')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
