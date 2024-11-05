<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <!-- Title Meta -->
    <meta charset="utf-8"/>
    <title> @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=""/>
    <meta name="author" content="Techzaa"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/admin/images/logo-letter.svg') }}">

    <!-- Vendor css (Require in all Page) -->
    <link href="{{asset('assets/front/css/vendor.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- Icons css (Require in all Page) -->
    <link href="{{asset('assets/front/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- App css (Require in all Page) -->
    <link href="{{asset('assets/front/css/app-rtl-v1.min.css')}}" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Theme Config js (Require in all Page) -->
    <script src="{{asset('assets/front/js/config.js')}}"></script>
    @toastifyCss
    @yield('css')
</head>

<body>

<!-- START Wrapper -->
<div class="wrapper">

    <!-- ========== Topbar Start ========== -->
    <header class="topbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <div class="top_bar_data">
                    <!-- Menu Toggle Button -->
{{--                    <div class="topbar-item">--}}
{{--                        <button type="button" class="button-toggle-menu me-2">--}}
{{--                            <iconify-icon icon="solar:hamburger-menu-broken" class="fs-24 align-middle"></iconify-icon>--}}
{{--                        </button>--}}
{{--                    </div>--}}
                    <div class="topbar-item">
                         <a href="#" class="deposit_button"> إيداع </a>
                    </div>
                    <div class="topbar-item">
                        <div class="noti_section">
                            <div class="notification">
                                <i class="bi bi-bell-fill"></i>
                            </div>
                            <div>
                                <button> <span class="total_balance"> @php
                                            echo \Illuminate\Support\Facades\Auth::user()->total_balance . ' $ ';
                                        @endphp  </span> مباشر  <i class="bi bi-send-fill"></i> </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>
