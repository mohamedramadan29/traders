@extends('admin.layouts.master')
@section('title')
    الرئيسية
@endsection
@section('content')
    <!-- ==================================================== -->
    <!-- Start right Content here -->
    <!-- ==================================================== -->
    <div class="page-content">

        <!-- Start Container Fluid -->
        <div class="container-xxl">
            <!-- Start here.... -->
                    <div class="row">
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 text-start">
                                            <p class="text-muted mb-0"> خطط التداول </p>
                                            <h3 class="text-dark mt-1 mb-0"> @php echo count(\App\Models\admin\Plan::all()); @endphp </h3>
                                        </div>
                                        <a style="margin-top: 10px" href="{{ url('admin/plans') }}" type="button"
                                            class="btn btn-sm btn-primary">
                                            مشاهدة التفاصيل
                                            <i class="ti ti-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 text-start">
                                            <p class="text-muted mb-0"> عدد الاشتراكات الكلي </p>
                                            <h3 class="text-dark mt-1 mb-0"> {{ $countuserinvestments }} </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 text-start">
                                            <p class="text-muted mb-0"> قيمة الاشتراكات الكلية  </p>
                                            <h3 class="text-dark mt-1 mb-0"> {{ $totalplaninvestments }} دولار </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->


            <hr>

            <!--  Start Storage InvestMent  -->
            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-start">
                                    <p class="text-muted mb-0"> عدد اشتراكات التخزين  </p>
                                    <h3 class="text-dark mt-1 mb-0"> {{ $totalcountinvestmentstorage }} </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-start">
                                    <p class="text-muted mb-0"> عدد الاشتركات الفعالة  </p>
                                    <h3 class="text-dark mt-1 mb-0"> {{ $totalcountinvestmentstorageactive }} </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-start">
                                    <p class="text-muted mb-0"> عدد الاشتراكات المنتهية  </p>
                                    <h3 class="text-dark mt-1 mb-0"> {{ $totalcountinvestmentstoragedisactive }} </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-start">
                                    <p class="text-muted mb-0"> قيمة التخزين الكلي  </p>
                                    <h3 class="text-dark mt-1 mb-0"> {{ $suminvestmentstorage }} دولار  </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-start">
                                    <p class="text-muted mb-0"> قيمة التخزين الفعالة  </p>
                                    <h3 class="text-dark mt-1 mb-0"> {{ $suminvestmentstorageactive }} دولار  </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-start">
                                    <p class="text-muted mb-0"> قيمة التخزين المنتهية   </p>
                                    <h3 class="text-dark mt-1 mb-0"> {{ $suminvestmentstoragedisactive }} دولار  </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end row -->

        </div>

    </div>
    <!-- ==================================================== -->
    <!-- End Page Content -->
    <!-- ==================================================== -->
@endsection
