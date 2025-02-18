@extends('front.layouts.master_dashboard')
@section('title')
    الاستثمار في عملة Oks
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
                    <div>
                        <div class="table-responsive my_new_container">
                            <div class="plans_total_report plan_report_section">
                                <div class="total_report increment_section">
                                    <p> الاستثمار في عملة Oks
                                    </p>
                                    <!-- Subscription form -->
                                    <form method="post" action="{{ url('user/OksInvestment') }}">
                                        @csrf
                                        <div style="display: flex; align-items: center; margin-top: 10px;">
                                            <button class="mines_button" type="button" onclick="decrementQuantity"
                                                style="width: 30px; height: 30px; font-size: 18px;">-
                                            </button>
                                            <input required class="quantity" type="number" id="quantity"
                                                name="total_price" min="1" placeholder=" مبلغ الاستثمار "
                                                oninput="calculateTotal">
                                            <button class="increase_button" type="button" onclick="incrementQuantity"
                                                style="width: 30px; height: 30px; font-size: 18px;">+
                                            </button>

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
                                            <h4> السعر الحالي للعملة </h4>
                                            <div class="investment_return_data">
                                                <h4> {{ $okssetting['current_price'] }} دولار
                                                </h4>
                                            </div>

                                        </div>
                                        {{-- <div class="plan1 investment_return">
                                            <h4> السعر الحالي للعملة </h4>
                                            <div class="investment_return_data">
                                                <h4> ١٠٠ دولار
                                                </h4>
                                            </div>

                                        </div> --}}

                                    </div>
                                    <div class="button_footer">
                                        <div class="statics">
                                            <i class="bi bi-people-fill"></i>
                                            <span> {{ $investments->count() }}</span>
                                        </div>
                                        <div class="statics">
                                            <i class="bi bi-currency-dollar"></i>
                                            <span>
                                                {{ $okssetting['total_investment'] }}
                                                دولار </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- end table-responsive -->
                    </div>

                </div>
            </div>
            @if ($userInvestments->count() > 0)
                <div class="table-responsive my_new_container">
                    <div class="open_trader">
                        <h6> استثمارتي في الخطة </h6>
                        <h3> استثمارتي في عملة Okx </h3>
                        <div class="open_trader_details">
                            <div class="details">

                                <div class="first_details">
                                    <p> قيمة الاستثمار (دولار) </p>
                                    <span class="sp_span"> {{ number_format($userInvestments->sum('total_investment'), 2) }}
                                    </span>
                                </div>
                                <div class="first_details">
                                    <p> الربح (دولار) </p>
                                    @php
                                        $oksnumbers = $userInvestments->sum('oks_numbers');
                                        $total_investment = $userInvestments->sum('total_investment');
                                        #### CalC Profit
                                        $profit = $oksnumbers * $okssetting['current_price'] - $total_investment;
                                    @endphp
                                    <span> {{ number_format($profit, 2) }} </span>
                                </div>
                            </div>
                        </div>
                        <hr>

                    </div>
                </div>
            @endif

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
