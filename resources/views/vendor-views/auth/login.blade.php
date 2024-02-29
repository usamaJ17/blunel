@php
    use App\Enums\DemoConstant;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{translate('vendor_login')}}</title>
    <link rel="shortcut icon" href="{{ asset('storage/app/public/company/'.getWebConfig(name: 'company_fav_icon')) }}">
    <link rel="stylesheet" href="{{asset('public/assets/back-end/css/google-fonts.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/back-end/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/back-end/css/vendor.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/back-end/vendor/icon-set/style.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/back-end/css/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/back-end/css/theme.minc619.css?v=1.0')}}">
    <link rel="stylesheet" href="{{asset('public/assets/back-end/css/style.css')}}">
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
    <div class="container py-5 py-sm-7 ">
        @php($companyWebLogo=getWebConfig(name: 'company_web_logo'))
        <a class="d-flex justify-content-center mb-5" href="javascript:">
            <img class="z-index-2" height="40"
                 src="{{getValidImage(path: 'storage/app/public/company/'.$companyWebLogo,type: 'backend-logo')}}"
                 alt="{{translate('logo')}}">
        </a>
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="card card-lg mb-5">
                    <div class="card-body">
                        <form action="{{route('vendor.auth.login')}}" method="post" id="vendor-login-form">
                            @csrf
                            <div class="text-center">
                                <div class="mb-5">
                                    <h1 class="display-4">{{translate('sign_in')}}</h1>
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">{{translate('welcome_back_to_vendor_login')}}</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="js-form-message form-group">
                                <label class="input-label" for="signingVendorEmail">{{translate('your_email')}}</label>
                                <input type="email" class="form-control form-control-lg" name="email"
                                       id="signingVendorEmail"
                                       tabindex="1" placeholder="email@address.com" aria-label="email@address.com"
                                       required data-msg="Please enter a valid email address.">
                            </div>
                            <div class="js-form-message form-group">
                                <label class="input-label" for="signingVendorPassword" tabindex="0">
                                        <span class="d-flex justify-content-between align-items-center">
                                          {{translate('password')}}
                                                <a href="{{route('vendor.auth.forgot-password.index')}}">
                                                    {{translate('forgot_password')}}
                                                </a>
                                        </span>
                                </label>
                                <div class="input-group input-group-merge">
                                    <input type="password" class="js-toggle-password form-control form-control-lg"
                                           name="password" id="signingVendorPassword"
                                           placeholder="8+ characters required"
                                           aria-label="8+ characters required" required
                                           data-msg="Your password is invalid. Please try again."
                                           data-hs-toggle-password-options='{
                                                         "target": "#changePassTarget",
                                                "defaultClass": "tio-hidden-outlined",
                                                "showClass": "tio-visible-outlined",
                                                "classChangeTarget": "#changePassIcon"
                                                }'>
                                    <div id="changePassTarget" class="input-group-append">
                                        <a class="input-group-text" href="javascript:">
                                            <i id="changePassIcon" class="tio-visible-outlined"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="termsCheckbox"
                                           name="remember">
                                    <label class="custom-control-label text-muted" for="termsCheckbox">
                                        {{translate('remember_me')}}
                                    </label>
                                </div>
                            </div>
                            @if(isset($recaptcha) && $recaptcha['status'] == 1)
                                <div id="recaptcha_element" class="w-100" data-type="image"></div>
                                <br/>
                            @else
                                <div class="row py-2">
                                    <div class="col-6 pr-0">
                                        <input type="text" class="form-control __h-40 border-0" name="vendorRecaptchaKey" value=""
                                               placeholder="{{translate('enter_captcha_value')}}" autocomplete="off">
                                    </div>
                                    <div class="col-6 input-icons mb-2 w-100 rounded bg-white">
                                        <a class="d-flex align-items-center align-items-center get-login-recaptcha-verify"
                                           data-link="{{ URL('/vendor/auth/recaptcha') }}">
                                            <img src="{{ URL('/vendor/auth/recaptcha/1?captcha_session_id=vendorRecaptchaSessionKey') }}"
                                                alt="" class="rounded __h-40" id="default_recaptcha_id">
                                            <i class="tio-refresh position-relative cursor-pointer p-2"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <button type="submit" class="btn btn-lg btn-block btn--primary">{{translate('sign_in')}}</button>
                        </form>
                    </div>
                    @if(env('APP_MODE')=='demo')
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-10">
                                    <span id="vendor-email" data-email="{{ DemoConstant::VENDOR['email'] }}">{{translate('email')}} : {{ DemoConstant::VENDOR['email'] }}</span><br>
                                    <span id="vendor-password" data-password="{{ DemoConstant::VENDOR['password'] }}">{{translate('password')}} : {{ DemoConstant::VENDOR['password'] }}</span>
                                </div>
                                <div class="col-2">
                                    <button class="btn btn--primary" id="copyLoginInfo"><i class="tio-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
<span id="message-please-check-recaptcha" data-text="{{ translate('please_check_the_recaptcha') }}"></span>
<span id="message-copied_success" data-text="{{ translate('copied_successfully') }}"></span>
<script src="{{asset('public/assets/back-end/js/vendor.min.js')}}"></script>
<script src="{{asset('public/assets/back-end/js/theme.min.js')}}"></script>
<script src="{{asset('public/assets/back-end/js/toastr.js')}}"></script>
<script src="{{asset('public/assets/back-end/js/vendor/login.js')}}"></script>
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

@if(isset($recaptcha) && $recaptcha['status'] == 1)
    <script type="text/javascript">
        "use strict";
        var onloadCallback = function () {
            grecaptcha.render('recaptcha_element', {
                'sitekey': '{{ getWebConfig(name: 'recaptcha')['site_key'] }}'
            });
        };
    </script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
@endif
</body>
</html>

