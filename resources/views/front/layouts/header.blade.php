<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <!-- Title Meta -->
    <meta charset="utf-8" />
    <title> @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="author" content="Techzaa" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/admin/images/logo-letter.svg') }}">

    <!-- Vendor css (Require in all Page) -->
    <link href="{{ asset('assets/front/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Icons css (Require in all Page) -->
    <link href="{{ asset('assets/front/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css (Require in all Page) -->
    <link href="{{ asset('assets/front/css/app-rtl-v3.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/front/css/custome_style-v3.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Theme Config js (Require in all Page) -->
    <script src="{{ asset('assets/front/js/config.js') }}"></script>
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
                        <div class="topbar-item">
                            <a href="#" class="deposit_button" data-bs-toggle="modal"
                                data-bs-target="#main_add_balance"> إيداع </a>
                        </div>
                        @include('front.layouts.add_balance')
                        <div>
                        </div>
                        <div class="topbar-item">
                            <div class="noti_section">
                                <div class="notification">
                                    <i class="bi bi-bell-fill"></i>
                                </div>
                                <div>
                                    <button> <span class="total_balance">
                                            @php
                                                echo number_format(Auth::user()->dollar_balance, 2) . ' دولار  ';
                                            @endphp </span> </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </header>
