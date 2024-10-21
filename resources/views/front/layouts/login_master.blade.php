<!DOCTYPE html>
<html lang="ar" class="h-100" dir="rtl">
<head>
    <meta charset="utf-8"/>
    <title> @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="مركز وكالات كيوتيكس"/>
    <meta name="author" content="Techzaa"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/front/images/logo-letter.svg')}}">
    <!-- Vendor css (Require in all Page) -->
    <link href="{{asset('assets/front/css/vendor.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Icons css (Require in all Page) -->
    <link href="{{asset('assets/front/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- App css (Require in all Page) -->
    <link href="{{asset('assets/front/css/app.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/front/css/app-rtl.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- Theme Config js (Require in all Page) -->
    <script src="{{asset('assets/front/js/config.js')}}"></script>
    @toastifyCss
</head>
<body class="h-100">
@yield('content')
<script src="{{asset('assets/front/js/vendor.js')}}"></script>
<script src="{{asset('assets/front/js/app.js')}}"></script>
@toastifyJs
</body>
</html>

