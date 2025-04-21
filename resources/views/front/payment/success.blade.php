@extends('front.layouts.master_dashboard')
@section('title')
    الرئيسية
@endsection
@section('css')
    {{--    <!-- DataTables CSS --> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <style>
        .cancel-page {
            padding: 100px 0;
            text-align: center;
            color: #fff;
        }

        .cancel-page h1 {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #fff
        }

        .cancel-page p {
            font-size: 18px;
            margin-bottom: 30px;
            color: #fff
        }

        .cancel-page a {
            color: #fff;
            background-color: #0faf59 !important;
            border: 1px solid #0faf59 !important;
            border-radius: 5px;
            text-decoration: none;
            margin: 10px
        }
    </style>
@endsection
@section('content')
    <div class="page-content">
        <!-- Start Container Fluid -->
        <div class="container-xxl">
            <div class="row">
                <div class="col-xl-12">
                    <div class="cancel-page text-center">
                        <h1>تمت العملية بنجاح!</h1>
                        <p>شكراً لك! لقد تم شحن رصيدك بنجاح.</p>

                        <div class="d-flex justify-content-center">

                            <a href="{{ url('user/dashboard') }}" class="btn btn-secondary deposit_button">العودة إلى الصفحة
                                الرئيسية <i class="bi bi-box-arrow-left"></i> </a>
                            <a href="https://t.me/binveste" target="_blank"
                                class="btn btn-secondary deposit_button">تواصل معنا <i class="bi bi-telegram"></i> </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Container Fluid -->
    </div>
@endsection
