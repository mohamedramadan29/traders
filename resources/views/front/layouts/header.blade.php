<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <!-- Title Meta -->
    <meta charset="utf-8"/>
    <title> @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully responsive premium admin dashboard template"/>
    <meta name="author" content="Techzaa"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <!-- Vendor css (Require in all Page) -->
    <link href="{{asset('assets/front/css/vendor.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- Icons css (Require in all Page) -->
    <link href="{{asset('assets/front/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- App css (Require in all Page) -->
    <link href="{{asset('assets/front/css/app-rtl.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- Theme Config js (Require in all Page) -->
    <script src="{{asset('assets/front/js/config.js')}}"></script>
    @toastifyCss
    @yield('css')
</head>

<body>

