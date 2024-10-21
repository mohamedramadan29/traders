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
                                <p class="text-muted mb-0"> العملاء  </p>
                                <h3 class="text-dark mt-1 mb-0"> @php echo  \App\Models\front\User::all()->count(); @endphp </h3>

                            </div>
                            <a style="margin-top: 10px" href="{{url('admin/users')}}" type="button" class="btn btn-sm btn-primary">
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
                                <p class="text-muted mb-0">  الاحصائيات  </p>
                                <h3 class="text-dark mt-1 mb-0"> @php echo  \App\Models\admin\Transaction::all()->count(); @endphp </h3>

                            </div>
                            <a style="margin-top: 10px" href="{{url('admin/transactions')}}" type="button" class="btn btn-sm btn-danger">
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
                                <div class="avatar-md bg-info rounded">
                                    <iconify-icon icon="solar:ufo-2-bold-duotone" class="avatar-title fs-24 "></iconify-icon>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-8 text-start">
                                <p class="text-muted mb-0">  بوتات التيلجرام </p>
                                <h3 class="text-dark mt-1 mb-0"> @php echo \App\Models\admin\Boot::all()->count(); @endphp </h3>

                            </div>
                            <a style="margin-top: 10px" href="{{url('admin/boots')}}" type="button" class="btn btn-sm btn-info">
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
                                <div class="avatar-md bg-warning rounded">
                                    <i class="bx bxs-message-rounded-dots avatar-title fs-24"></i>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-8 text-start">
                                <p class="text-muted mb-0">   الدعم الفني  </p>
                                <h3 class="text-dark mt-1 mb-0"> @php echo \App\Models\admin\Support::all()->count(); @endphp </h3>

                            </div>
                            <a style="margin-top: 10px" href="{{url('admin/messages')}}" type="button" class="btn btn-sm btn-warning">
                                مشاهدة التفاصيل
                                <i class="ti ti-eye"></i>
                            </a>
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
