@extends('front.layouts.master_dashboard')
@section('title')
    الخطط المتاحة
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
                @if (Session::has('Success_message'))
                    @php
                        toastify()->success(\Illuminate\Support\Facades\Session::get('Success_message'));
                    @endphp
                @endif
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        @php
                            toastify()->error($error);
                        @endphp
                    @endforeach
                @endif
                <div class="col-xl-12">
                    <div class="card info_card">
                        <h4 class="card-title flex-grow-1"> الخطط المتاحة </h4>
                    </div>
                    <div>
                        <div class="table-responsive my_new_container">
                            @foreach ($plans as $plan)
                                <div class="plans_total_report plan_report_section">
                                    <div class="total_report increment_section">
                                        <p>{{ $plan['name'] }}
                                            {{--                                            <br> {{ $plan['current_price'] }} $ --}}
                                        </p>
                                        <!-- Subscription form -->
                                        <form method="post" action="{{ url('user/invoice_create') }}">
                                            @csrf
                                            <!-- Quantity input with increment and decrement buttons -->
                                            <div style="display: flex; align-items: center; margin-top: 10px;">
                                                <button class="mines_button" type="button"
                                                    onclick="decrementQuantity({{ $plan['id'] }})"
                                                    style="width: 30px; height: 30px; font-size: 18px;">-
                                                </button>
                                                <input class="quantity" type="number" id="quantity_{{ $plan['id'] }}"
                                                    name="total_price" value="1" min="1"
                                                    style="text-align: center; width: 60px; margin: 0 10px;"
                                                    data-plan-price="{{ $plan['current_price'] }}"
                                                    data-plan-step="{{ $plan['step_price'] }}"
                                                    oninput="calculateTotal({{ $plan['id'] }})">
                                                <button class="increase_button" type="button"
                                                    onclick="incrementQuantity({{ $plan['id'] }})"
                                                    style="width: 30px; height: 30px; font-size: 18px;">+
                                                </button>
                                            </div>
                                            {{--                                            <p style="margin-top: 10px;" class="total_price"> <span --}}
                                            {{--                                                    id="totalPrice_{{ $plan['id'] }}">{{ $plan['current_price'] }}</span> --}}
                                            {{--                                                $</p> --}}
                                            <input type="hidden" name="plan_id" value="{{ $plan['id'] }}">
                                            {{--                                            <input type="hidden" name="total_price" --}}
                                            {{--                                                   id="total_price_input_{{ $plan['id'] }}" --}}
                                            {{--                                                   value="{{ $plan['current_price'] }}"> --}}
                                            <button style="display: block; width: 100%; margin-top: 20px;" type="submit"
                                                class="btn withdraw_button">
                                                اشتراك
                                            </button>
                                        </form>

                                    </div>
                                    <div class="plans ">
                                        <div class="plans_details">
                                            <div class="plan1 hide_mobile">
                                                <h4>سعر الشراء </h4>
                                                <h4 style="color:#10AE59"> {{ $plan['current_price'] }} $ </h4>
                                            </div>
                                            <div class="plan1 investment_return">
                                                <h4> عائد الاستثمار </h4>
                                                <h4> 24 H
                                                    <br>
                                                    <span style="color:#10AE59"> 10 $</span>
                                                </h4>
                                                <h4> 7 D
                                                    <br>
                                                    <span style="color:#10AE59"> 20 $</span>
                                                </h4>
                                                <h4> 30 D
                                                    <br>
                                                    <span style="color:#10AE59"> 200.20$</span>
                                                </h4>
                                            </div>
                                            <div class="plan1 platform_info">
                                                <h4 data-bs-toggle="modal"
                                                    data-bs-target="#add_attribute_{{ $plan['id'] }}">
                                                    <span class="platform-trigger"
                                                        style="cursor:pointer;">{{ $plan['platform_name'] }}</span>
                                                    <i class="bi bi-caret-down-fill" style="cursor:pointer;"></i>
                                                </h4>
                                                <img src="{{ asset('assets/uploads/plans/' . $plan['logo']) }}">
                                            </div>
                                        </div>
                                        <div class="button_footer">
                                            <div class="statics">
                                                <i class="bi bi-people-fill"></i>
                                                <span style="color:#10AE59"> 20 </span>

                                            </div>
                                            <div class="statics">
                                                <i class="bi bi-wallet-fill"></i>
                                                <span style="color:#10AE59"> 4000.300 $ </span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal structure  -->
                                <div class="modal fade platform_data" id="add_attribute_{{ $plan['id'] }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        function calculateTotal(planId) {
            const quantityInput = document.getElementById(`quantity_${planId}`);
            const planPrice = parseFloat(quantityInput.getAttribute('data-plan-price'));
            const stepPrice = parseFloat(quantityInput.getAttribute('data-plan-step'));
            const quantity = parseInt(quantityInput.value);

            // حساب السعر النهائي على أساس العدد والتزايد لكل اشتراك إضافي
            let totalPrice = 0;
            for (let i = 0; i < quantity; i++) {
                totalPrice += planPrice + (i * stepPrice);
            }
            totalPrice = totalPrice.toFixed(2);

            // تحديث السعر النهائي في الواجهة
            document.getElementById(`totalPrice_${planId}`).textContent = totalPrice;
            document.getElementById(`total_price_input_${planId}`).value = totalPrice;
        }

        function incrementQuantity(planId) {
            const quantityInput = document.getElementById(`quantity_${planId}`);
            quantityInput.value = parseInt(quantityInput.value) + 1;
            calculateTotal(planId);
        }

        function decrementQuantity(planId) {
            const quantityInput = document.getElementById(`quantity_${planId}`);
            if (quantityInput.value > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
                calculateTotal(planId);
            }
        }
    </script>
@endsection
