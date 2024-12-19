@extends('front.layouts.master_dashboard')
@section('title')
    خططي
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
                @if (Session::has('Error_Message'))
                    @php
                        toastify()->error(\Illuminate\Support\Facades\Session::get('Error_Message'));
                    @endphp
                @endif
                <div class="col-xl-12">
                    <div class="user_plans_page_info my_new_container">
                        <div class="info">
                            <h5> اجمالي الاسثمارات </h5>
                            <h4 class="total_investment"> {{ number_format($totalbalance, 2) }} دولار </h4>

                            <div class="investment_percentages">
                                <p class="percentage"> +{{ $daily_earning }}({{ $daily_earning_percentage }}%) <span> اليوم
                                        <i class="bi bi-arrow-up-short"></i> </span>
                                </p>

                            </div>
                            <div class="buttons">

                                <a href="#" class="public_button" data-bs-toggle="modal"
                                    data-bs-target="#main_add_balance"> إيداع </a>
                                <a href="#" class="stat"> الاحصائيات </a>
                            </div>
                            @include('front.layouts.add_balance')
                        </div>
                        <div class="info">
                            <h5> الربح </h5>
                            <h4 class="profit_balance"> {{ number_format($investment_earning, 2) }} دولار </h4>
                            <button style="border: none;" class="stat" data-bs-toggle="modal"
                                data-bs-target="#main_withdraw_balance"> سحب </button>
                            @include('front.Plans.withdraw')
                        </div>
                        <div class="info">
                            <h5> {{ Auth::user()->id }} </h5>
                            <img src="{{ asset('assets/uploads/users/' . Auth::user()->image) }}">
                        </div>
                    </div>
                    <hr>
                    @foreach ($Plans as $plan_details)
                        <div class="user_plans_page_info my_new_container">
                            <div class="info">
                                <h5> {{ $plan_details['plan']['name'] }} </h5>
                                <h4 class="total_investment"> {{ number_format($plan_details['total_investment'], 2) }}
                                    دولار
                                </h4>
                                <div class="profit_percentages">
                                    <h4> 24 ســاعـة
                                        <br>
                                        @if ($plan_details->plan_last_dayearning != 0)
                                            <span
                                                style="color: {{ $plan_details->plan_last_dayearning > 0 ? '#10AE59' : '#FF0000' }}">
                                                {{ $plan_details->plan_last_dayearning > 0 ? '+' : '' }}
                                                {{ number_format($plan_details->plan_last_dayearning, 2) }}
                                                ({{ $plan_details->plan_last_daypercentage }} %)
                                                <i
                                                    class="bi {{ $plan_details->plan_last_dayearning > 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                            </span>
                                        @else
                                            <span style="color: #999999"> % 0.00 </span>
                                        @endif
                                    </h4>
                                    <h4> 7 ايــام
                                        <br>
                                        @if ($plan_details->last_7_days_earning != 0)
                                            <span
                                                style="color: {{ $plan_details->last_7_days_earning > 0 ? '#10AE59' : '#FF0000' }}">
                                                {{ $plan_details->last_7_days_earning > 0 ? '+' : '' }}
                                                {{ number_format($plan_details->last_7_days_earning, 2) }}
                                                ({{ $plan_details->last_7_days_percentage }} %)
                                                <i
                                                    class="bi {{ $plan_details->last_7_days_earning > 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                            </span>
                                        @else
                                            <span style="color: #999999"> % 0.00 </span>
                                        @endif
                                    </h4>
                                    <h4> 30 يــوم
                                        <br>
                                        @if ($plan_details->last_30_days_earning != 0)
                                            <span
                                                style="color: {{ $plan_details->last_30_days_earning > 0 ? '#10AE59' : '#FF0000' }}">
                                                {{ $plan_details->last_30_days_earning > 0 ? '+' : '' }}
                                                {{ number_format($plan_details->last_30_days_earning, 2) }}
                                                ({{ $plan_details->last_30_days_percentage }} %)
                                                <i
                                                    class="bi {{ $plan_details->last_30_days_earning > 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                            </span>
                                        @else
                                            <span style="color: #999999"> % 0.00 </span>
                                        @endif
                                    </h4>
                                </div>
                                <div class="buttons">
                                    <a href="#" class="public_button" data-bs-toggle="modal"
                                        data-bs-target="#edit_balance_{{ $plan_details['plan']['id'] }}"> تعديل الرصيد </a>
                                    <a href="#" class="stat toggle-transactions"
                                        data-plan-id="{{ $plan_details['plan']['id'] }}"> المعاملات </a>
                                </div>
                            </div>
                            @include('front.Plans.edit_balance')
                            <div class="info">
                                <h5> الربح </h5>
                                <h4 class="profit_balance"> {{ number_format($plan_details->plan_profit, 2) }} دولار </h4>
                            </div>
                            <div class="info">
                                <h5> {{ $plan_details['plan']['name'] }} </h5>
                                <a href="{{ $plan_details['plan']['platform_link'] }}">
                                    <img src="{{ asset('assets/uploads/plans/' . $plan_details['plan']['logo']) }}">
                                </a>
                            </div>
                        </div>

                        <!-- #################################### Start Plan Transaction Details ############################# -->
                        @include('front.Plans.user_plan_statments')
                        <!-- #################################### End Plan Transaction Details ############################# -->
                    @endforeach

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            // إضافة حدث لجميع الأزرار
                            document.querySelectorAll('.toggle-transactions').forEach(button => {
                                button.addEventListener('click', (e) => {
                                    e.preventDefault(); // منع التحديث
                                    const planId = button.getAttribute('data-plan-id'); // الحصول على ID الخطة
                                    const container = document.getElementById(
                                        `transactions-${planId}`); // البحث عن القسم الخاص بالخطة
                                    if (container.style.display === 'none' || !container.style.display) {
                                        container.style.display = 'block'; // إظهار المعاملات
                                    } else {
                                        container.style.display = 'none'; // إخفاء المعاملات
                                    }
                                });
                            });
                        });
                    </script>
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
@endsection
