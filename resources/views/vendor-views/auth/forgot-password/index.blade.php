<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{translate('forgot_password')}}</title>

    <link rel="shortcut icon" href="{{ asset('storage/app/public/company/'.getWebConfig(name: 'company_fav_icon')) }}">

    <link rel="stylesheet" href="{{ asset('public/assets/back-end/css/google-fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/back-end/css/vendor.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/back-end/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/back-end/vendor/icon-set/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/back-end/css/theme.minc619.css?v=1.0') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/back-end/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/back-end/css/toastr.css') }}">
</head>
<body>
<main id="content" role="main" class="main">
    <div class="position-fixed top-0 right-0 left-0 bg-img-hero __h-32rem">
        <figure class="position-absolute right-0 bottom-0 left-0">
            <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1921 273">
                <polygon fill="#fff" points="0,273 1921,273 1921,0 "/>
            </svg>
        </figure>
    </div>
    <div class="container py-5 py-sm-7">
        @php($ecommerceLogo=getWebConfig('company_web_logo'))
        <a class="d-flex justify-content-center mb-5" href="javascript:">
            <img class="z-index-2 __w-8rem" src="{{ getValidImage(path:'storage/app/public/company/'.$ecommerceLogo,type: 'backend-logo') }}" alt="{{translate('logo')}}">
        </a>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <h2 class="h3 mb-4">{{translate('forgot_password').'?'}}</h2>
                <p class="font-size-md">{{translate('follow_steps')}}</p>
                <ol class="list-unstyled font-size-md">
                    <li><span class="text-primary mr-2">1.</span>{{translate('fill_in_your_email_address_below').'.'}}</li>
                    <li>
                        <span class="text-primary mr-2">2.</span>{{translate('we_will_send_email you a temporary code').'.'}}
                    </li>
                    <li>
                        <span class="text-primary mr-2">3.</span>{{translate('use_the_code_to_change_your_password_on_our_secure_website').'.'}}
                    </li>
                </ol>
                @php($verificationBy = getWebConfig('forgot_password_verification'))
                @if ($verificationBy=='email')
                    <div class="card py-2 mt-4">
                        <form class="card-body needs-validation" action="{{route('vendor.auth.forgot-password.index')}}"
                              method="post">
                            @csrf
                            <div class="form-group">
                                <label for="recover-email">{{translate('enter_your_email_address')}}</label>
                                <input class="form-control" type="email" name="identity" id="recover-email" required>
                                <div class="invalid-feedback">{{translate('please_provide_valid_email_address.')}}</div>
                            </div>
                            <button class="btn btn-primary" type="submit">{{translate('get_new_password')}}</button>
                        </form>
                    </div>
                @else
                    <div class="card py-2 mt-4">
                        <form class="card-body needs-validation" action="{{route('vendor.auth.forgot-password.index')}}"
                              method="post">
                            @csrf
                            <div class="form-group">
                                <label for="recover-email">{{translate('enter_your_phone_number')}}</label>
                                <input class="form-control" type="text" name="identity" id="recover-email" required>
                                <div class="invalid-feedback">{{translate('please_provide_valid_phone_number.')}}</div>
                            </div>
                            <button class="btn btn--primary" type="submit">{{translate('get_new password')}}</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>

<script src="{{asset('public/assets/back-end/js/vendor.min.js')}}"></script>
<script src="{{asset('public/assets/back-end/js/theme.min.js')}}"></script>
<script src="{{asset('public/assets/back-end/js/toastr.js')}}"></script>
<script src="{{asset('public/assets/back-end/js/vendor/forgot-password.js')}}"></script>
{!! Toastr::message() !!}

@if ($errors->any())
    <script>
        "use strict";
        @foreach($errors->all() as $error)
        toastr.error('{{$error}}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
@endif
</body>
</html>

