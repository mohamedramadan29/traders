@extends('front.layouts.master_dashboard')
@section('title')
    برنامج الشراكة - Binvest Partner
@endsection
@section('css')
    {{--    <!-- DataTables CSS --> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection
@section('content')

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
                $allinvestment += $referral->CurrencyInvestments()->sum('total_investment');
            @endphp

            <!-- Get All Profit For User   -->
            @if ($referral->CurrencyInvestments()->count() > 0)
                @foreach ($referral->CurrencyInvestments() as $currencyplan)
                    @php
                        $allprofitforplan =
                            $currencyplan['currency_number'] * $currencyplan->CurrencyPlan['currency_current_price'] -
                            $currencyplan['total_investment'];
                        $allprofit += $allprofitforplan;
                        $allyouprofit += ($allprofitforplan * 0.05) / 2;
                    @endphp
                @endforeach
            @endif
        @endforeach
    @endif
    <!-- ==================================================== -->
    <div class="page-content user_plans user_plans_details">
        <!-- Start Container Fluid -->
        <div class="container-xxl">
            <div class="row">
                <div class="col-xl-12">
                    <div class="profile_page">
                        <div class="profile_tabs">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab" tabindex="0">
                                    <div class="referal-system-content"
                                        style="background-color: #2A3040; padding: 20px; border-radius: 10px;">
                                        <h4> برنامج الشراكة - Binvest Partner</h4>
                                        @if ($referrals->count() > 0)


                                        <div class="total_button d-flex justify-content-between align-items-center"
                                            style="background: #383a4c;padding: 5px 20px;border-radius: 10px;border: 1px solid #272b37;margin-bottom: 12px;">
                                            <div>
                                                <p> الربح الحالي </p>
                                                <h4> {{ number_format($allyouprofit - $oldsum, 2) }} </h4>
                                            </div>
                                            <div class="">
                                                <form action="{{ route('Referal.withdraw') }}" method="POST"
                                                    style="background-color: transparent;">
                                                    @csrf
                                                    <input type="hidden" name="amount"
                                                        value="{{ $allyouprofit - $oldsum }}">
                                                    @if ($allyouprofit - $oldsum > 0)
                                                        <button type="submit" class="btn btn-success btn-sm"> سحب
                                                            الرصيد </button>
                                                    @endif
                                                </form>
                                            </div>
                                        </div>
                                        @endif
                                        @if (Auth::user()->referral_code)
                                            <div class="referral-code-section"
                                                style="text-align:center; background: #383a4c;padding: 5px 20px;border-radius: 10px;border: 1px solid #272b37;margin-bottom: 12px;">
                                                <p> رابط الدعوة </p>
                                                <div
                                                    style="display: flex; align-items: center; justify-content: center; @media (min-width: 991px) { flex-direction: column; }">
                                                    <a href="{{ url('user/register?referral_code=' . Auth::user()->referral_code) }}"
                                                        id="referralLink">
                                                        {{ url('user/register?referral_code=' . Auth::user()->referral_code) }}
                                                    </a>
                                                    <button class="btn btn-primary btn-sm copy-button"
                                                        style="margin-right: 30px"
                                                        onclick="copyToClipboard('#referralLink')">
                                                        <i class="bx bx-copy"></i> نسخ الرابط
                                                    </button>
                                                </div>

                                            </div>
                                        @else
                                            <p>لا يوجد رابط احالة من فضلك تواصل مع الادارة</p>
                                        @endif

                                        @if ($referrals->count() > 0)
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
                                                        {{ number_format($allyouprofit, 2) }}
                                                    </h4>
                                                </div>
                                            </div>
                                            <p> اعضاء الفريق </p>
                                            <div class="table-responsive">
                                                <table class="table table-borded">
                                                    <thead>
                                                        <tr style="background-color:#383a4c; color:#fff">
                                                            <th style="color: #fff"> # </th>
                                                            <th style="color: #fff"> الاسم </th>
                                                            <th style="color: #fff"> الرصيد </th>
                                                            <th style="color: #fff"> الايداعات </th>
                                                            <th style="color: #fff"> الاستثمار </th>
                                                            <th style="color: #fff"> ارباح العضو </th>
                                                            <th style="color: #fff"> ارباحك </th>
                                                            <th style="color: #fff"> العمولة </th>
                                                            <th style="color: #fff"> تاريخ التسجيل </th>
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
                                                            <tr style="background-color:#2a3040">
                                                                <td style="background-color:#2a3040; color:#fff">
                                                                    {{ $loop->iteration }} </td>
                                                                <td style="background-color:#2a3040; color:#fff">
                                                                    {{ $referral->name }} </td>
                                                                <td style="background-color:#2a3040; color:#fff">
                                                                    {{ number_format($referral->dollar_balance, 2) }}
                                                                </td>
                                                                <td style="background-color:#2a3040; color:#fff">
                                                                    {{ number_format($referral->Transactions()->sum('price_amount'), 2) }}
                                                                    دولار
                                                                </td>
                                                                <td style="background-color:#2a3040; color:#fff">
                                                                    {{ number_format($referral->CurrencyInvestments()->sum('total_investment'), 2) }}
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

                                                                <td style="background-color:#2a3040; color:#fff">
                                                                    {{ number_format($allprofit / 2, 2) }} دولار
                                                                </td>
                                                                <td style="background-color:#2a3040; color:#fff">
                                                                    {{ number_format(($allprofit * 0.05) / 2, 2) }}
                                                                    دولار </td>
                                                                <td style="background-color:#2a3040; color:#fff"> 5% </td>
                                                                <td style="background-color:#2a3040; color:#fff">
                                                                    {{ $referral->created_at->format('Y-m-d') }} </td>
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
