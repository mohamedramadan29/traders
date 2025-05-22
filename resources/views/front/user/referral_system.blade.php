@extends('front.layouts.master_dashboard')
@section('title')
    نظام الاحالات
@endsection
@section('css')
    {{--    <!-- DataTables CSS --> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection
@section('content')
    <!-- ==================================================== -->
    <div class="page-content user_plans user_plans_details">
        <!-- Start Container Fluid -->
        <div class="container-xxl">
            <div class="row">
                <div class="col-xl-12">
                    <div class="profile_page">
                        <div class="profile_main_section">
                            <div class="logo_section">
                                <form id="updateProfileImageForm" action="{{ url('user/update_profile_image') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @if (empty(Auth::user()->image))
                                        <img id="userImage" src="{{ asset('assets/front/uploads/user2.png') }}">
                                    @else
                                        <img id="userImage" src="{{ asset('assets/uploads/users/' . Auth::user()->image) }}"
                                            alt="">
                                    @endif
                                    <label for="profileImageInput" style="cursor: pointer;">
                                        <i class="bi bi-pencil-square"></i>
                                    </label>
                                    <input type="file" id="profileImageInput" accept="image/*" name="image"
                                        style="display: none;">
                                </form>

                            </div>


                            <div class="email">
                                <p> {{ Auth::user()->email }} </p>
                            </div>
                        </div>
                        <hr>
                        <div class="profile_tabs">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" href="{{ url('user/profile') }}"> الصفحة الرئيسية </a>

                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" href="{{ url('user/referral_system') }}"> نظام الاحالات </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" href="{{ url('user/profile') }}"> تعديل البيانات </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" href="{{ url('user/profile') }}"> اعدادات الامان </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" href="{{ url('user/profile') }}"> الاشعارات </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab" tabindex="0">
                                    <div class="referal-system-content"
                                        style="background-color: #2A3040; padding: 20px; border-radius: 10px;">
                                        <h4> نظام الاحالات </h4>
                                        <p> رابط الاحالة الخاص بك </p>
                                        @if (Auth::user()->referral_code)
                                            <div class="referral-code-section">
                                                <a href="{{ url('user/register?referral_code=' . Auth::user()->referral_code) }}"
                                                    id="referralLink">
                                                    {{ url('user/register?referral_code=' . Auth::user()->referral_code) }}
                                                </a>
                                                <button class="btn btn-primary btn-sm copy-button"
                                                    onclick="copyToClipboard('#referralLink')">
                                                    <i class="bx bx-copy"></i>
                                                </button>
                                            </div>
                                        @else
                                            <p>لا يوجد رابط احالة من فضلك تواصل مع الادارة</p>
                                        @endif
                                        @if ($referrals->count() > 0)
                                            @php
                                                $alldeposit = 0;
                                                $allinvestment = 0;
                                                $allyouprofit = 0;
                                                $allprofit = 0;
                                            @endphp
                                            @foreach ($referrals as $referral)
                                                @php
                                                    $alldeposit += $referral->Transactions()->sum('price_amount');
                                                    $allinvestment += $referral
                                                        ->CurrencyInvestments()
                                                        ->sum('total_investment');
                                                @endphp

                                                <!-- Get All Profit For User   -->
                                                @if ($referral->CurrencyInvestments()->count() > 0)
                                                    @foreach ($referral->CurrencyInvestments() as $currencyplan)
                                                        @php
                                                            $allprofitforplan =
                                                                $currencyplan['currency_number'] *
                                                                    $currencyplan->CurrencyPlan[
                                                                        'currency_current_price'
                                                                    ] -
                                                                $currencyplan['total_investment'];
                                                            $allprofit += $allprofitforplan;
                                                            $allyouprofit += ($allprofitforplan * 0.05) / 2;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            @endforeach
                                            <br>
                                            <p> إحصائيات الفريق </p>
                                            <div class="referral_stats">
                                                <div class="stat">
                                                    <p> عدد الاعضاء </p>
                                                    <h4> {{ $referrals->count() }} </h4>
                                                </div>
                                                <div class="stat">
                                                    <p> إجمالي الإيداعات </p>
                                                    <h4> {{ number_format($alldeposit, 2) }}
                                                    </h4>
                                                </div>
                                                <div class="stat">
                                                    <p> إجمالي الاستثمار </p>
                                                    <h4> {{ number_format($allinvestment, 2) }}
                                                    </h4>
                                                </div>
                                                <div class="stat">
                                                    <p> إجمالي ارباح الاعضاء </p>
                                                    <h4> {{ number_format($allprofit / 2, 2) }}
                                                    </h4>
                                                </div>
                                                <div class="stat">
                                                    <p> إجمالي الربح </p>
                                                    <h4>
                                                        {{ number_format($allyouprofit , 2) }}
                                                    </h4>
                                                </div>
                                            </div>
                                            <p> اعضاء الفريق </p>
                                            <div class="table-responsive">
                                                <table class="table table-borded">
                                                    <thead>
                                                        <tr>
                                                            <th> # </th>
                                                            <th> الاسم </th>
                                                            <th> الرصيد </th>
                                                            <th> الايداعات </th>
                                                            <th> الاستثمار </th>
                                                            <th> ارباح العضو </th>
                                                            <th> ارباحك </th>
                                                            <th> العمولة </th>
                                                            <th> تاريخ التسجيل </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $alldeposit = 0;
                                                            $allinvestment = 0;
                                                            $allprofit = 0;
                                                            $allyouprofit = 0;
                                                        @endphp
                                                        @foreach ($referrals as $referral)
                                                            @php
                                                                $allprofit = 0;
                                                                $total_profit = 0;
                                                            @endphp
                                                            <tr>
                                                                <td> {{ $loop->iteration }} </td>
                                                                <td> {{ $referral->name }} </td>
                                                                <td> {{ number_format($referral->dollar_balance, 2) }}
                                                                </td>
                                                                <td> {{ number_format($referral->Transactions()->sum('price_amount'), 2) }}
                                                                    دولار
                                                                </td>
                                                                <td> {{ number_format($referral->CurrencyInvestments()->sum('total_investment'), 2) }}
                                                                    دولار
                                                                </td>
                                                                @if ($referral->CurrencyInvestments()->count() > 0)
                                                                    @php
                                                                        $allprofit = 0;
                                                                    @endphp
                                                                    @foreach ($referral->CurrencyInvestments() as $currencyplan)
                                                                        @php
                                                                            $allprofitforplan =
                                                                                $currencyplan['currency_number'] *
                                                                                    $currencyplan->CurrencyPlan[
                                                                                        'currency_current_price'
                                                                                    ] -
                                                                                $currencyplan['total_investment'];
                                                                            $allprofit += $allprofitforplan;

                                                                        @endphp
                                                                    @endforeach
                                                                @endif

                                                                <td> {{ number_format($allprofit / 2, 2) }} دولار
                                                                </td>
                                                                <td> {{ number_format(($allprofit * 0.05) / 2, 2) }}
                                                                    دولار </td>
                                                                <td style="color: #10AE59"> 5% </td>
                                                                <td> {{ $referral->created_at->format('Y-m-d') }} </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <br>
                                            <div class="alert alert-info">
                                                لا يوجد اعضاء الي الان
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!-- End Container Fluid -->

    </div>
    <!-- ==================================================== -->
    <!-- End Page Content -->
    <!-- ==================================================== -->
@endsection


@section('js')
    <script>
        document.getElementById('profileImageInput').addEventListener('change', function() {
            const form = document.getElementById('updateProfileImageForm');
            const formData = new FormData(form);
            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // تحديث صورة المستخدم
                        document.getElementById('userImage').src = data.imageUrl;
                        // alert('تم تحديث الصورة بنجاح!');
                    } else {
                        alert('حدث خطأ أثناء التحديث.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('تعذر تحديث الصورة.');
                });
        });
    </script>
    <script>
        function copyToClipboard(element) {
            var temp = document.createElement("textarea");
            temp.value = document.querySelector(element).textContent;
            document.body.appendChild(temp);
            temp.select();
            document.execCommand("copy");
            document.body.removeChild(temp);
            alert("تم نسخ رابط الإحالة!");
        }
    </script>
@endsection
