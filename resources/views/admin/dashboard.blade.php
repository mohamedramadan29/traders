@extends('admin.layouts.master')
@section('title') الرئيسية  @endsection
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
                            <div class="col-4">
                                <div class="avatar-md bg-primary rounded">
                                    <i class="bx bx-user avatar-title fs-24 text-white"></i>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-8 text-start">
                                <p class="text-muted mb-0">  خطط التداول   </p>
                                <h3 class="text-dark mt-1 mb-0"> @php echo count(\App\Models\admin\Plan::all()); @endphp </h3>

                            </div>
                            <a style="margin-top: 10px" href="{{url('admin/plans')}}" type="button" class="btn btn-sm btn-primary">
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
                            <div class="col-4">
                                <div class="avatar-md bg-danger rounded">
                                    <i class='bx bxs-bar-chart-alt-2  avatar-title fs-24'></i>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-8 text-start">
                                <p class="text-muted mb-0">  منصات التداول  </p>
                                <h3 class="text-dark mt-1 mb-0"> @php echo count(\App\Models\admin\Platform::all()); @endphp </h3>

                            </div>
                            <a style="margin-top: 10px" href="{{url('admin/platforms')}}" type="button" class="btn btn-sm btn-danger">
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
                            <div class="col-4">
                                <div class="avatar-md bg-danger rounded">
                                    <i class='bx bxs-bar-chart-alt-2  avatar-title fs-24'></i>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-8 text-start">
                                <p class="text-muted mb-0">  راس المال الكلي   </p>
                                <h3 class="text-dark mt-1 mb-0"> @php echo  \App\Models\front\Invoice::where('status',1)->sum('plan_price'); @endphp $ </h3>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="avatar-md bg-danger rounded">
                                    <i class='bx bxs-bar-chart-alt-2  avatar-title fs-24'></i>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-8 text-start">
                                <p class="text-muted mb-0"> عدد الاشتراكات الكلي  </p>
                                <h3 class="text-dark mt-1 mb-0"> @php echo  count(\App\Models\front\Invoice::all()) @endphp  </h3>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="avatar-md bg-danger rounded">
                                    <i class='bx bxs-bar-chart-alt-2  avatar-title fs-24'></i>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-8 text-start">
                                <p class="text-muted mb-0">  عدد الاشتراكات الفعالة الان  </p>
                                <h3 class="text-dark mt-1 mb-0"> @php echo  count(\App\Models\front\Invoice::where('status',1)->get()) @endphp  </h3>
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
