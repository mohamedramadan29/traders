<!-- ========== App Menu Start ========== -->
<div class="main-nav">
    <!-- Sidebar Logo -->
    <div class="logo-box">
        <a href="{{ url('admin/dashboard') }}" class="logo-dark">
            <img src="{{ asset('assets/admin/images/logo-letter.svg') }}" class="logo-sm" alt="logo sm">
            <img src="{{ asset('assets/admin/images/logo-letter.svg') }}" class="logo-lg" alt="logo dark">
        </a>

        <a href="{{ url('admin/dashboard') }}" class="logo-light">
            <img src="{{ asset('assets/admin/images/logo-letter.svg') }}" class="logo-sm" alt="logo sm">
            <img src="{{ asset('assets/admin/images/logo-letter.svg') }}" class="logo-lg" alt="logo light">
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
                <a class="nav-link" href="{{ url('admin/dashboard') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:widget-5-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> الرئيسية </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/transactions') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:tuning-2-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> المعاملات </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/withdraws') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:document-text-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">  طلبات السحب   </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/boots') }}">
                    <span class="nav-icon">
                         <iconify-icon icon="solar:ufo-2-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> بوتات التيلجرام    </span>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/levels') }}">
                    <span class="nav-icon">
                         <iconify-icon icon="solar:ufo-2-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> مستويات الاحالات   </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/user-levels') }}">
                    <span class="nav-icon">
                         <iconify-icon icon="solar:ufo-2-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> مستويات العميل نفسة   </span>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarSupport" data-bs-toggle="collapse" role="button"
                   aria-expanded="false" aria-controls="sidebarSupport">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:chat-round-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">  الدعم الفني  </span>
                </a>
                <div class="collapse" id="sidebarSupport">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ url('admin/messages') }}"> جميع الرسائل    </a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ url('admin/message/add') }}">  اضف رسالة جديدة   </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarfaq" data-bs-toggle="collapse" role="button"
                   aria-expanded="false" aria-controls="sidebarfaq">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:clipboard-list-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">   الاسئلة الشائعة  </span>
                </a>
                <div class="collapse" id="sidebarfaq">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ url('admin/faqs') }}"> جميع الاسئلة   </a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ url('admin/faq/add') }}">   اضف سؤال جديد    </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-title mt-2"> اعدادات الموقع </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/public-setting/update') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:settings-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> الاعدادات العامة </span>
                </a>
            </li>

            <li class="menu-title mt-2"> المستخدمين</li>

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
                            <a class="sub-nav-link" href="{{ url('admin/update_admin_details') }}"> تعديل البيانات
                            </a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ url('admin/update_admin_password') }}"> تعديل كلمة
                                المرور </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarCustomers" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarCustomers">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:users-group-two-rounded-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> العملاء </span>
                </a>
                <div class="collapse" id="sidebarCustomers">
                    <ul class="nav sub-navbar-nav">

                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{url('admin/users')}}"> جميع العملاء </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- ========== App Menu End ========== -->
