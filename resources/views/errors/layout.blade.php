<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{ asset('public/assets/front-end/css/roboto-font.css')  }}">
        <link rel="stylesheet" media="screen" href="{{ asset('public/assets/front-end/css/theme.css') }}">
        <link rel="stylesheet" href="{{asset('public/assets/front-end/css/errors.css')}}"/>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title">
                    @yield('message')
                </div>
            </div>
        </div>
    </body>
</html>
