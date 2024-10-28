@extends('front.layouts.master_dashboard')
@section('title')
    الرئيسية
@endsection
@section('content')
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
    <!-- ==================================================== -->
    <!-- Start right Content here -->
    <!-- ==================================================== -->
    <div class="page-content">
        <!-- Start Container Fluid -->
        <div class="container-xxl">
            <!-- Start here.... -->
            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="card info_card">
                        <div class="col-12 text-start">
                            <p class=" mb-0"> كل الخطط </p>
                            <h3 class="mt-1 mb-0"> 100 </h3>
                        </div>
                        <button style="margin-top: 10px" type="button" class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#balance_details">
                            مشاهدة الكل
                            <i class="ti ti-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card info_card">

                        <div class="col-8 text-start">
                            <p class="mb-0"> خططي </p>
                            <h3 class="mt-1 mb-0"> 0 </h3>
                        </div>
                        <a style="margin-top: 10px" href="{{url('user/user_plans')}}" type="button"
                           class="btn btn-sm btn-success">
                            مشاهدة التفاصيل
                            <i class="ti ti-eye"></i>
                        </a>
                    </div>
                </div>
            </div>


        </div>

    </div>
    <!-- ==================================================== -->
    <!-- End Page Content -->
    <!-- ==================================================== -->

@endsection

