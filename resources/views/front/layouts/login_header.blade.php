<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <!-- Title Meta -->
    <meta charset="utf-8"/>
    <title> @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=" Binveste فريق من الخبراء يتداولون نيابة عنك لتحقيق أقصى قدر من العائدات.
اصول , eo,ex,Qx,px. "/>
    <meta name="author" content="Techzaa"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/uploads/favicon.jpeg') }}">

    <!-- Vendor css (Require in all Page) -->
    <link href="{{asset('assets/front/css/vendor.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- Icons css (Require in all Page) -->
    <link href="{{asset('assets/front/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- App css (Require in all Page) -->
    <link href="{{asset('assets/front/css/app-rtl-v3.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/front/css/custome-v3.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Theme Config js (Require in all Page) -->
    <script src="{{asset('assets/front/js/config.js')}}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @toastifyCss
    @yield('css')
</head>

<body>
