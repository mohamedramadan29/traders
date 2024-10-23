<!-- ========== App Menu Start ========== -->
<div class="main-nav">
    <!-- Sidebar Logo -->
    <div class="logo-box">
        <a href="{{ url('user/dashboard') }}" class="logo-dark">
            <img src="{{ asset('assets/admin/images/logo-letter.svg') }}" class="logo-sm" alt="logo sm">
            <img src="{{ asset('assets/admin/images/logo-letter.svg') }}" class="logo-lg" alt="logo dark">
        </a>

        <a href="{{ url('user/dashboard') }}" class="logo-light">
            <img style="width: 70px;height: 70px;" src="{{ asset('assets/admin/images/logo-letter.svg') }}" class="logo-sm" alt="logo sm">
            <img style="width: 70px;height: 70px;" src="{{ asset('assets/admin/images/logo-letter.svg') }}" class="logo-lg" alt="logo light">
        </a>
    </div>

    <!-- Menu Toggle Button (sm-hover) -->
    <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
        <iconify-icon icon="solar:double-alt-arrow-right-bold-duotone" class="button-sm-hover-icon"></iconify-icon>
    </button>

    <div class="scrollbar" data-simplebar>
        <ul class="navbar-nav" id="navbar-nav">

            <li class="menu-title"> العام</li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url('user/dashboard') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:widget-5-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> الرئيسية </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('user/plans') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:tuning-2-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> جميع الخطط   </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('user/user_plans') }}">
                    <span class="nav-icon">
                         <iconify-icon icon="solar:document-text-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">  خططي  </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('user/withdraws') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:document-text-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">  طلبات السحب   </span>
                </a>
            </li>
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="{{ url('user/boots') }}">--}}
{{--                    <span class="nav-icon">--}}
{{--                         <iconify-icon icon="solar:ufo-2-bold-duotone"></iconify-icon>--}}
{{--                    </span>--}}
{{--                    <span class="nav-text"> بوتات التيلجرام    </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="{{ url('user/link') }}">--}}
{{--                    <span class="nav-icon">--}}
{{--                        <i class="bx bx-link"></i>--}}
{{--                    </span>--}}
{{--                    <span class="nav-text"> رابط الاحاله Quotex  </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="{{ url('user/referrals') }}">--}}
{{--                    <span class="nav-icon">--}}
{{--                        <i class="bx bx-link"></i>--}}
{{--                    </span>--}}
{{--                    <span class="nav-text">--}}
{{--مركز وكالات كيوتيكس  </span>--}}
{{--                </a>--}}
{{--            </li>--}}

{{--            <li class="nav-item">--}}
{{--                <a class="nav-link menu-arrow" href="#sidebarSupport" data-bs-toggle="collapse" role="button"--}}
{{--                   aria-expanded="false" aria-controls="sidebarSupport">--}}
{{--                    <span class="nav-icon">--}}
{{--                        <iconify-icon icon="solar:chat-round-bold-duotone"></iconify-icon>--}}
{{--                    </span>--}}
{{--                    <span class="nav-text">  الدعم الفني  </span>--}}
{{--                </a>--}}
{{--                <div class="collapse" id="sidebarSupport">--}}
{{--                    <ul class="nav sub-navbar-nav">--}}
{{--                        <li class="sub-nav-item">--}}
{{--                            <a class="sub-nav-link" href="{{ url('user/messages') }}"> جميع الرسائل    </a>--}}
{{--                        </li>--}}
{{--                        <li class="sub-nav-item">--}}
{{--                            <a class="sub-nav-link" href="{{ url('user/message/add') }}">  اضف رسالة جديدة   </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link menu-arrow" href="#sidebarfaq" data-bs-toggle="collapse" role="button"--}}
{{--                   aria-expanded="false" aria-controls="sidebarfaq">--}}
{{--                    <span class="nav-icon">--}}
{{--                        <iconify-icon icon="solar:clipboard-list-bold-duotone"></iconify-icon>--}}
{{--                    </span>--}}
{{--                    <span class="nav-text">   الاسئلة الشائعة  </span>--}}
{{--                </a>--}}
{{--                <div class="collapse" id="sidebarfaq">--}}
{{--                    <ul class="nav sub-navbar-nav">--}}
{{--                        <li class="sub-nav-item">--}}
{{--                            <a class="sub-nav-link" href="{{ url('user/faqs') }}"> جميع الاسئلة   </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </li>--}}

            <li class="menu-title mt-2"> حسابي  </li>

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebaradminprofile" data-bs-toggle="collapse" role="button"
                   aria-expanded="false" aria-controls="sidebarCustomers">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:chat-square-like-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> حسابي </span>
                </a>
                <div class="collapse" id="sidebaradminprofile">
                    <ul class="nav sub-navbar-nav">

                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ url('user/update_user_details') }}"> تعديل البيانات
                            </a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ url('user/update_user_password') }}"> تعديل كلمة
                                المرور </a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
    </div>
</div>
<!-- ========== App Menu End ========== -->
