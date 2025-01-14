@extends('front.layouts.master_dashboard')
@section('title')
    المحفظة
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

                <div class="col-12">
                    <div class="user_plans_page_info my_new_container balance_page_section" style="">
                        <div class="section1">
                            <div class="info">
                                <h5> اجمالي الرصيد </h5>
                                @php
                                    $all_balance = Auth::user()->dollar_balance + $totalinvestments;
                                @endphp
                                <h4 class="total_investment"> {{ number_format($all_balance, 2) }} دولار
                                </h4>
                                <p class="percentage"> <span> ربح وخسارة اليوم </span> +{{ $daily_earning }}({{ $daily_earning_percentage * 100 }}%)  </p>

                            </div>
                            <div class="info">
                                <h5> السجل <i class="bi bi-file-earmark"></i> </h5>
                                <div class="buttons">
                                    <button style="border: none; background-color:#10AE59" class="stat public_button"
                                        data-bs-toggle="modal" data-bs-target="#main_withdraw_balance"> سحب </button>
                                    @include('front.Plans.withdraw')
                                    <a href="#" class="stat" data-bs-toggle="modal"
                                        data-bs-target="#main_add_balance"> إيداع </a>
                                    @include('front.layouts.add_balance')
                                </div>
                            </div>
                        </div>
                        <div class="section2">
                            <div class="info">
                                <h5> اجمالي الرصيد المتاح </h5>
                                @php
                                    $total_balance = Auth::user()->dollar_balance;
                                @endphp
                                <h4 class="total_investment"> {{ number_format($total_balance, 2) }} دولار </h4>
                            </div>
                            <div class="info">
                                <h5> الرصيد في الاستثمارات </h5>
                                <h4 class="total_investment"> {{ number_format($totalinvestments, 2) }} دولار </h4>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="balance_public_info">
                        <h4> تداول النسخ </h4>
                        <h4> اجمالي الرصيد </h4>
                        <h3> {{ number_format($totalinvestments, 2) }} دولار </h3>
                        <p class="percentage"> <span> ربح وخسارة اليوم </span> +{{ $daily_earning }}({{ $daily_earning_percentage * 100 }}%) </p>
                    </div>
                    <hr>
                    <div class="balance_public_info">
                        <h4> رصيد التداول </h4>
                        <h4> اجمالي الرصيد </h4>
                        <h3> {{ number_format($trading_balance, 2) }} دولار </h3>
                        <p class="percentage"> <span> ربح وخسارة اليوم </span> +{{ number_format($profit_lose , 3) }}({{ $return_all_percentage }}%) </p>
                    </div>
                    <hr>
                    <div class="balance_public_info">
                        <h4> رصيد الاستثمار </h4>
                        <h4> اجمالي الرصيد </h4>
                        <h3> {{ number_format($storage_investment, 2) }} دولار </h3>
                        <p class="percentage"> <span> ربح وخسارة اليوم </span> +{{ $storageTotalEarning }}({{ $storageTotalPercentage * 100 }} %) </p>
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
