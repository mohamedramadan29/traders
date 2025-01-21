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
