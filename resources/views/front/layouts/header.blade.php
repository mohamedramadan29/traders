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
                                @php
                                    $unreadNotifications = Auth::user()->unreadNotifications; // جميع الإشعارات غير المقروءة
                                    $recentNotifications = Auth::user()->notifications()->latest()->take(5)->get(); // آخر 5 إشعارات
                                @endphp
                                <div class="notification">
                                    <button type="button"
                                        class="topbar-button alert_notification position-relative show"
                                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="true">
                                        <i class="bi bi-bell-fill"></i>
                                        @if ($unreadNotifications->count() > 0)
                                            <span
                                                class="position-absolute topbar-badge fs-10 translate-middle badge bg-danger rounded-pill">{{ $unreadNotifications->count() }}</span>
                                        @endif
                                    </button>
                                    <div class="dropdown-menu py-0 dropdown-lg dropdown-menu-end"
                                        aria-labelledby="page-header-notifications-dropdown"
                                        style="max-height: 300px; overflow-y: auto;">
                                        <div class="p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="m-0">الإشعارات</h6>
                                                <a href="{{ route('notifications.markAllAsRead') }}"
                                                    class="text-dark text-decoration-underline">
                                                    <small>تعيين الكل كمقروءة</small>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- الإشعارات غير المقروءة -->
                                        {{-- <div class="notification-content">
                                            <h6 class="dropdown-header">الإشعارات غير المقروءة</h6>
                                            @forelse ($unreadNotifications as $notification)
                                                <a href=""
                                                    class="dropdown-item py-2 border-bottom d-flex align-items-center">
                                                    <div>
                                                        <p class="mb-0 fw-medium">
                                                            {{ $notification->data['title'] ?? 'إشعار' }}
                                                        </p>
                                                        <small
                                                            class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </a>
                                            @empty
                                                <p class="dropdown-item py-2 text-center">لا يوجد إشعارات جديدة</p>
                                            @endforelse
                                        </div> --}}

                                        <!-- آخر 5 إشعارات -->
                                        <div class="notification-content">
                                            <h6 class="dropdown-header">آخر 5 إشعارات</h6>
                                            @foreach ($recentNotifications as $notification)
                                                <a href=""
                                                    class="dropdown-item py-2 border-bottom d-flex align-items-center">
                                                    <div>
                                                        <p class="mb-0 fw-medium">
                                                            {{ $notification->data['title'] ?? 'إشعار' }}
                                                        </p>
                                                        <small
                                                            class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
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
