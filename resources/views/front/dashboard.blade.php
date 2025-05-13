@extends('front.layouts.master_dashboard')
@section('title')
    الرئيسية
@endsection
@section('css')
    {{--    <!-- DataTables CSS --> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection
@section('content')
    <!-- ==================================================== -->
    <div class="page-content">
        <!-- Start Container Fluid -->
        <div class="container-xxl">
            <div class="row">
                <div class="col-xl-12">
                    {{-- <div class="card info_card">
                        <h4 class="card-title flex-grow-1"> الخطط المتاحة </h4>
                    </div> --}}
                    <div>
                        <div class="table-responsive my_new_container">
                            @foreach ($plansWithReturns as $plan)
                                <div class="plans_total_report plan_report_section">
                                    <div class="total_report increment_section">
                                        <p>{{ $plan['plan_name'] }}
                                        </p>
                                        <!-- Subscription form -->
                                        <form method="post" action="{{ url('user/invoice_create') }}">
                                            @csrf
                                            <div style="display: flex; align-items: center; margin-top: 10px;">
                                                <button class="mines_button" type="button"
                                                    onclick="decrementQuantity({{ $plan['plan_id'] }}, '{{ $plan['platform_name'] }}')"
                                                    style="width: 30px; height: 30px; font-size: 18px;">-
                                                </button>
                                                <input required class="quantity" type="number"
                                                    id="quantity_{{ $plan['plan_id'] }}" name="total_price" min="1"
                                                    placeholder=" مبلغ الاستثمار "
                                                    oninput="calculateTotal({{ $plan['plan_id'] }}, '{{ $plan['platform_name'] }}')">
                                                <button class="increase_button" type="button"
                                                    onclick="incrementQuantity({{ $plan['plan_id'] }}, '{{ $plan['platform_name'] }}')"
                                                    style="width: 30px; height: 30px; font-size: 18px;">+
                                                </button>
                                                <input type="hidden" name="plan_id" value="{{ $plan['plan_id'] }}">
                                            </div>
                                            <button style="display: block; width: 100%; margin-top: 20px;" type="submit"
                                                class="btn withdraw_button">
                                                اشتراك
                                            </button>
                                            <!-- مكان عرض الرسالة -->
                                            <div class="subscription_message"
                                                id="subscription_message_{{ $plan['plan_id'] }}">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="plans ">
                                        <div class="plans_details">
                                            <div class="plan1 investment_return">
                                                <h4> عائد الاستثمار </h4>
                                                <div class="investment_return_data">
                                                    <h4> 24 ساعة
                                                        <br>
                                                        @if ($plan['today_returns_percentage'] != 0)
                                                            <span
                                                                style="color: {{ $plan['today_returns_percentage'] > 0 ? '#10AE59' : '#FF0000' }}">
                                                                {{ $plan['today_returns_percentage'] > 0 ? '+' : '' }}
                                                                {{ $plan['today_returns_percentage'] * 100 }}
                                                                %
                                                                <i
                                                                    class="bi {{ $plan['today_returns_percentage'] > 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                                            </span>
                                                        @else
                                                            <span style="color: #999999"> % 0.00 </span>
                                                        @endif
                                                    </h4>
                                                    <h4> 7 ايــام
                                                        <br>
                                                        @if ($plan['last_7_days_percentage'] != 0)
                                                            <span
                                                                style="color: {{ $plan['last_7_days_percentage'] > 0 ? '#10AE59' : '#FF0000' }}">
                                                                {{ $plan['last_7_days_percentage'] > 0 ? '+' : '' }}
                                                                {{ $plan['last_7_days_percentage'] * 100 }}
                                                                %
                                                                <i
                                                                    class="bi {{ $plan['last_7_days_percentage'] > 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                                            </span>
                                                        @else
                                                            <span style="color: #999999"> % 0.00 </span>
                                                        @endif
                                                    </h4>
                                                    <h4> 30 يــوم
                                                        <br>
                                                        @if ($plan['last_30_days_percentage'] != 0)
                                                            <span
                                                                style="color: {{ $plan['last_30_days_percentage'] > 0 ? '#10AE59' : '#FF0000' }}">
                                                                {{ $plan['last_30_days_percentage'] > 0 ? '+' : '' }}
                                                                {{ $plan['last_30_days_percentage'] * 100 }}
                                                                %
                                                                <i
                                                                    class="bi {{ $plan['last_30_days_percentage'] > 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                                            </span>
                                                        @else
                                                            <span style="color: #999999"> % 0.00 </span>
                                                        @endif
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="plan1 platform_info">
                                                <h4 data-bs-toggle="modal"
                                                    data-bs-target="#add_attribute_{{ $plan['plan_id'] }}">
                                                    <span class="platform-trigger"
                                                        style="cursor:pointer;">{{ $plan['platform_name'] }}</span>
                                                    <i class="bi bi-caret-down-fill" style="cursor:pointer;"></i>
                                                </h4>
                                                <a href="{{ url($plan['platform_link']) }}">
                                                    <img src="{{ asset('assets/uploads/plans/' . $plan['logo']) }}">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="button_footer">
                                            <div class="statics">
                                                <i class="bi bi-people-fill"></i>
                                                <span> {{ $plan['total_subscriptions'] }} </span>
                                            </div>
                                            <div class="statics">
                                                <i class="bi bi-currency-dollar"></i>
                                                <span>
                                                    {{ number_format($plan['totalinvestment'], 2) }}
                                                    دولار </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal structure  -->
                                <div class="modal fade platform_data" id="add_attribute_{{ $plan['plan_id'] }}"
                                    tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="platformModalLabel">
                                                    {{ $plan['platform_name'] }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <h6> {{ $plan['platform_name'] }} </h6>
                                                <!-- Platform logo -->
                                                <img src="{{ asset('assets/uploads/plans/' . $plan['logo']) }}"
                                                    alt="{{ $plan['platform_name'] }}" class="img-fluid"
                                                    style="max-width: 150px;">
                                                <!-- Platform link -->
                                                <p class="mt-3">
                                                    <a href="{{ url($plan['platform_link']) }}" target="_blank"
                                                        class="btn btn-success">
                                                        زيارة الموقع
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
{{--
                            <h4 style="color: #fff;font-weight: bold; "> الاستثمار في العملات
                            </h4> --}}
                            @php
                                if (!function_exists('calculateProfit')) {
                                    function calculateProfit($current, $previous)
                                    {
                                        return $previous ? number_format(abs(($current - $previous) * 100), 2) : '0';
                                    }
                                }
                            @endphp
                            @foreach ($currencyPlans as $currencyplan)
                                <div class="plans_total_report plan_report_section">
                                    <div class="total_report increment_section">
                                        <p>{{ $currencyplan['name'] }}
                                        </p>
                                        <!-- Subscription form -->
                                        <form method="post" action="{{ route('currency_investment') }}">
                                            @csrf
                                            <div style="display: flex; align-items: center; margin-top: 10px;">
                                                <button class="mines_button" type="button"
                                                    onclick="decrementQuantity({{ $currencyplan['id'] }})"
                                                    style="width: 30px; height: 30px; font-size: 18px;">-
                                                </button>
                                                <input required class="quantity" type="number"
                                                    id="quantity_{{ $currencyplan['id'] }}" name="currency_price"
                                                    min="1" placeholder=" مبلغ الاستثمار "
                                                    oninput="calculateTotal({{ $currencyplan['id'] }})">
                                                <button class="increase_button" type="button"
                                                    onclick="incrementQuantity({{ $currencyplan['id'] }})"
                                                    style="width: 30px; height: 30px; font-size: 18px;">+
                                                </button>
                                                <input type="hidden" name="currency_plan_id"
                                                    value="{{ $currencyplan['id'] }}">
                                            </div>
                                            <button style="display: block; width: 100%; margin-top: 20px;" type="submit"
                                                class="btn withdraw_button">
                                                اشتراك
                                            </button>
                                        </form>
                                    </div>
                                    <div class="plans ">
                                        <div class="plans_details">
                                            <div class="plan1 investment_return">
                                                <h4> عائد الاستثمار </h4>
                                                <!---------- Get The Currency Price In Last Day --------->
                                                <!-- New Way To Get  -->
                                                @php
                                                    $totalinvestments =
                                                        $currencyplan['main_investment'] +
                                                        $currencyplan['current_investments'];
                                                    $firstinvestment = $currencyplan['main_investment'];

                                                    // الحساب الصحيح لعائد الاستثمار
                                                    $investment_return =
                                                        (($totalinvestments - $firstinvestment) / $firstinvestment) *
                                                        100;
                                                @endphp
                                                <!-- End New Way -->
                                                @php

                                                    // السعر الحالي
                                                    $currentPrice = $currencyplan->currency_current_price;
                                                    $main_price = $currencyplan->currency_main_price;

                                                    // dd($currentPrice);
                                                    // 🔵 السعر في آخر 24 ساعة
                                                    $lastDayPrice = $currencyplan
                                                        ->CurrencyPlanSteps()
                                                        ->where('created_at', '>=', now()->subDay()->startOfDay())
                                                        ->where('created_at', '<=', now()->subDay()->endOfDay())
                                                        ->orderBy('created_at', 'desc')
                                                        ->value('currency_price');
                                                    //   dd($lastDayPrice);

                                                    // ✅ إذا لم توجد بيانات في آخر يوم، جلب آخر سجل متاح
                                                    if (!$lastDayPrice) {
                                                        $lastDayPrice = $currencyplan
                                                            ->CurrencyPlanSteps()
                                                            ->orderBy('created_at', 'desc')
                                                            ->value('currency_price');

                                                        // dd($lastDayPrice);
                                                    }

                                                    // 🔵 السعر في آخر 7 أيام
                                                    $lastWeekPrice = $currencyplan
                                                        ->CurrencyPlanSteps()
                                                        ->where('created_at', '>=', now()->subDays(7)->startOfDay())
                                                        ->where('created_at', '<=', now()->endOfDay())
                                                        ->orderBy('created_at', 'desc')
                                                        ->value('currency_price');

                                                    // ✅ إذا لم توجد بيانات في آخر 7 أيام، جلب آخر سجل متاح
                                                    if (!$lastWeekPrice) {
                                                        $lastWeekPrice = $currencyplan
                                                            ->CurrencyPlanSteps()
                                                            ->orderBy('created_at', 'desc')
                                                            ->value('currency_price');
                                                    }

                                                    // 🔵 السعر في آخر 30 يومًا
                                                    $lastMonthPrice = $currencyplan
                                                        ->CurrencyPlanSteps()
                                                        ->where('created_at', '>=', now()->subDays(30)->startOfDay())
                                                        ->where('created_at', '<=', now()->endOfDay())
                                                        ->orderBy('created_at', 'desc')
                                                        ->value('currency_price');

                                                    // ✅ إذا لم توجد بيانات في آخر 30 يومًا، جلب آخر سجل متاح
                                                    if (!$lastMonthPrice) {
                                                        $lastMonthPrice = $currencyplan
                                                            ->CurrencyPlanSteps()
                                                            ->orderBy('created_at', 'desc')
                                                            ->value('currency_price');
                                                    }
                                                    // حساب نسبة الربح
                                                    //dd($currentPrice);

                                                    if ($currentPrice == $lastDayPrice) {
                                                        $profitLastDay = calculateProfit($main_price, $lastDayPrice);
                                                    } else {
                                                        $profitLastDay = calculateProfit($currentPrice, $lastDayPrice);
                                                    }

                                                    $profitLastWeek = calculateProfit($currentPrice, $lastWeekPrice);
                                                    $profitLastMonth = calculateProfit($currentPrice, $lastMonthPrice);
                                                @endphp
                                                <div class="investment_return_data">
                                                    <h4 style="color: #10AE59">
                                                        {{ number_format($investment_return, 2) }} %
                                                    </h4>
                                                    {{-- <h4> 24 ساعة
                                                            <br>
                                                            @if ($profitLastDay != 0)
                                                                <span
                                                                    style="color: {{ $profitLastDay > 0 ? '#10AE59' : '#FF0000' }}">
                                                                    {{ $profitLastDay > 0 ? '+' : '' }}
                                                                    {{ $profitLastDay }}
                                                                    %
                                                                    <i
                                                                        class="bi {{ $profitLastDay > 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                                                </span>
                                                            @else
                                                                <span style="color: #999999"> % 0.00 </span>
                                                            @endif
                                                        </h4> --}}
                                                    {{-- <h4> 7 ايــام
                                                            <br>
                                                            @if ($profitLastWeek != 0)
                                                                <span
                                                                    style="color: {{ $profitLastWeek > 0 ? '#10AE59' : '#FF0000' }}">
                                                                    {{ $profitLastWeek > 0 ? '+' : '' }}
                                                                    {{ $profitLastWeek }}
                                                                    %
                                                                    <i
                                                                        class="bi {{ $profitLastWeek > 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                                                </span>
                                                            @else
                                                                <span style="color: #999999"> % 0.00 </span>
                                                            @endif
                                                        </h4> --}}
                                                    {{-- <h4> 30 يــوم
                                                            <br>
                                                            @if ($profitLastMonth != 0)
                                                                <span
                                                                    style="color: {{ $profitLastMonth > 0 ? '#10AE59' : '#FF0000' }}">
                                                                    {{ $profitLastMonth > 0 ? '+' : '' }}
                                                                    {{ $profitLastMonth }}
                                                                    %
                                                                    <i
                                                                        class="bi {{ $profitLastMonth > 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                                                </span>
                                                            @else
                                                                <span style="color: #999999"> % 0.00 </span>
                                                            @endif
                                                        </h4> --}}
                                                </div>
                                            </div>
                                            <div class="plan1 platform_info">
                                                <h4 data-bs-toggle="modal"
                                                    data-bs-target="#add_attribute_{{ $currencyplan['id'] }}">
                                                    <span class="platform-trigger"
                                                        style="cursor:pointer;">{{ $currencyplan['name'] }}</span>
                                                    <i class="bi bi-caret-down-fill" style="cursor:pointer;"></i>
                                                </h4>
                                                <a href="{{ url($currencyplan['url']) }}">
                                                    <img
                                                        src="{{ asset('assets/uploads/currency/' . $currencyplan['logo']) }}">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="button_footer">
                                            <div class="statics">
                                                <i class="bi bi-people-fill"></i>
                                                <span> {{ $currencyplan->investments->count() }} </span>
                                            </div>
                                            <div class="statics">
                                                <i class="bi bi-currency-dollar"></i>
                                                <span>
                                                    @php
                                                        $totalinvestments =
                                                            $currencyplan['main_investment'] +
                                                            $currencyplan['current_investments'];
                                                    @endphp
                                                    {{ number_format($totalinvestments, 2) }} $
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal structure  -->
                                <div class="modal fade platform_data" id="add_attribute_{{ $currencyplan['id'] }}"
                                    tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="platformModalLabel">
                                                    {{ $currencyplan['name'] }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <h6> {{ $currencyplan['name'] }} </h6>
                                                <!-- Platform logo -->
                                                <img src="{{ asset('assets/uploads/currency/' . $currencyplan['logo']) }}"
                                                    alt="{{ $currencyplan['name'] }}" class="img-fluid"
                                                    style="max-width: 150px;">
                                                <!-- Platform link -->
                                                <p class="mt-3">
                                                    <a href="{{ url($currencyplan['url']) }}" target="_blank"
                                                        class="btn btn-success">
                                                        زيارة الموقع
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- end table-responsive -->
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function calculateTotal(planId, platformName) {
            // الحصول على قيمة مبلغ الاشتراك المكتوبة من input
            const quantityInput = document.getElementById(`quantity_${planId}`);
            const totalPrice = parseFloat(quantityInput.value) || 0; // القيمة المدخلة

            // تحديث الرسالة النصية
            const messageDiv = document.getElementById(`subscription_message_${planId}`);
            if (messageDiv) {
                if (totalPrice > 0) {
                    messageDiv.textContent =
                        `سوف تشترك في منصة ${platformName} بمبلغ ${totalPrice.toFixed(2)} دولار`;
                } else {
                    messageDiv.textContent = ""; // إخفاء الرسالة إذا كان المدخل صفرًا
                }
            }
        }

        function incrementQuantity(planId, platformName) {
            const quantityInput = document.getElementById(`quantity_${planId}`);
            quantityInput.value = parseInt(quantityInput.value || 0) + 1;
            calculateTotal(planId, platformName);
        }

        function decrementQuantity(planId, platformName) {
            const quantityInput = document.getElementById(`quantity_${planId}`);
            if (quantityInput.value > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
                calculateTotal(planId, platformName);
            }
        }
    </script>
@endsection
