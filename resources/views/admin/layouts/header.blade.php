<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <!-- Title Meta -->
    <meta charset="utf-8" />
    <title> @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Binveste" />
    <meta name="author" content="Binveste" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/admin/images/logo-letter.svg') }}">

    <!-- Vendor css (Require in all Page) -->
    <link href="{{asset('assets/admin/css/vendor.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Icons css (Require in all Page) -->
    <link href="{{asset('assets/admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- App css (Require in all Page) -->
    <link href="{{asset('assets/admin/css/app-rtl.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Theme Config js (Require in all Page) -->
    <script src="{{asset('assets/admin/js/config.js')}}"></script>
    @toastifyCss
    <link rel="stylesheet" href="https://unpkg.com/toastify-js@1.12.0/src/toastify.css">
    @yield('css')
</head>
<body>
<!-- START Wrapper -->
<div class="wrapper">
    <header class="topbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <div class="d-flex align-items-center">
                    <!-- Menu Toggle Button -->
                    <div class="topbar-item">
                        <button type="button" class="button-toggle-menu me-2">
                            <iconify-icon icon="solar:hamburger-menu-broken" class="fs-24 align-middle"></iconify-icon>
                        </button>
                    </div>
                    <div class="topbar-item">
                        <div class="section_balance">
                            <div class="image_logo">
                                <img src="{{ asset('assets/admin/images/logo-letter.svg') }}" alt="">
                            </div>
                            <div class="image_info">
                                <h5> Binveste </h5>
                            </div>
                        </div>
                        <style>
                            .topbar{
                                background-color: #fff;
                                margin-bottom: 20px;
                            }
                            .section_balance{
                                display: flex;
                                align-items: center;
                            }
                            .section_balance .image_logo{
                                margin-left: 10px;
                            }

                            .section_balance .image_info{
                            }
                            .section_balance .image_info h5{
                                font-size: 22px;
                                margin: 0;
                                margin-top: 15px;
                            }
                            .section_balance .image_info p{
                                font-size:17px;
                            }
                            @media(max-width: 991px){
                                /*section_balance{*/
                                /*    align-items:flex-start;*/
                                /*}*/
                                .section_balance .image_logo img{
                                    width:30px;
                                }
                                .section_balance .image_info h5{
                                    font-size: 17px;
                                    margin-top: 15px;
                                }
                                .section_balance .image_info p{
                                    font-size: 14px;
                                }
                            }
                        </style>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-1">
                    <!-- User -->
                    <div class="dropdown topbar-item">
                        <a type="button" class="topbar-button" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                                        <span class="d-flex align-items-center">
                                             <i class='bx bxs-down-arrow'></i> <img width="35px"
                                                                                    src="{{asset('assets/front/images/user.png')}}">
                                        </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header"> مرحبا {{\Illuminate\Support\Facades\Auth::guard('admin')->user()->name}}
                                ! </h6>
                            <a class="dropdown-item" href="{{url('admin/update_admin_details')}}">
                                <i class="bx bx-user-circle text-muted fs-18 align-middle me-1"></i><span
                                    class="align-middle"> حسابي  </span>
                            </a>
                            <a class="dropdown-item" href="{{url('admin/update_admin_password')}}">
                                <i class="bx bx-message-dots text-muted fs-18 align-middle me-1"></i><span
                                    class="align-middle"> تغير كلمة المرور  </span>
                            </a>
                            <div class="dropdown-divider my-1"></div>
                            <a class="dropdown-item text-danger" href="{{route('logout')}}">
                                <i class="bx bx-log-out fs-18 align-middle me-1"></i><span class="align-middle"> تسجيل خروج  </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
