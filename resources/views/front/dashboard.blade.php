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
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body overflow-hidden position-relative">
                            <iconify-icon icon="iconamoon:3d-duotone" class="fs-36 text-info"></iconify-icon>
                            <h3 class="mb-0 fw-bold mt-3 mb-1">$59.6k</h3>
                            <p class="text-muted">Total Income</p>
                            <span class="badge fs-12 badge-soft-success"><i class="ti ti-arrow-badge-up"></i> 8.72%</span>
                            <i class='bx bx-doughnut-chart widget-icon'></i>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col">
                    <div class="card">
                        <div class="card-body overflow-hidden position-relative">
                            <iconify-icon icon="iconamoon:category-duotone" class="fs-36 text-success"></iconify-icon>
                            <h3 class="mb-0 fw-bold mt-3 mb-1">$24.03k</h3>
                            <p class="text-muted">Total Expenses</p>
                            <span class="badge fs-12 badge-soft-danger"><i class="ti ti-arrow-badge-down"></i> 3.28%</span>
                            <i class='bx bx-bar-chart-alt-2 widget-icon'></i>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col">
                    <div class="card">
                        <div class="card-body overflow-hidden position-relative">
                            <iconify-icon icon="iconamoon:store-duotone" class="fs-36 text-purple"></iconify-icon>
                            <h3 class="mb-0 fw-bold mt-3 mb-1">$48.7k</h3>
                            <p class="text-muted">Investments</p>
                            <span class="badge fs-12 badge-soft-danger"><i class="ti ti-arrow-badge-down"></i> 5.69%</span>
                            <i class='bx bx-building-house widget-icon'></i>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col">
                    <div class="card">
                        <div class="card-body overflow-hidden position-relative">
                            <iconify-icon icon="iconamoon:gift-duotone" class="fs-36 text-orange"></iconify-icon>
                            <h3 class="mb-0 fw-bold mt-3 mb-1">$11.3k</h3>
                            <p class="text-muted">Savings</p>
                            <span class="badge fs-12 badge-soft-success"><i class="ti ti-arrow-badge-up"></i> 10.58%</span>
                            <i class='bx bx-bowl-hot widget-icon'></i>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col">
                    <div class="card">
                        <div class="card-body overflow-hidden position-relative">
                            <iconify-icon icon="iconamoon:certificate-badge-duotone" class="fs-36 text-warning"></iconify-icon>
                            <h3 class="mb-0 fw-bold mt-3 mb-1">$5.5k</h3>
                            <p class="text-muted">Profits</p>
                            <span class="badge fs-12 badge-soft-success"><i class="ti ti-arrow-badge-up"></i> 2.25%</span>
                            <i class='bx bx-cricket-ball widget-icon'></i>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- end row-->

            <!-- Start here.... -->
            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="avatar-md bg-primary rounded">
                                        <i class="bx bx-money-withdraw avatar-title fs-24 text-white"></i>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-8 text-start">
                                    <p class="text-muted mb-0"> كل الخطط  </p>
                                    <h3 class="text-dark mt-1 mb-0">  </h3>
                                </div>
                                <button style="margin-top: 10px" type="button" class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#balance_details">
                                    مشاهدة الكل
                                    <i class="ti ti-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="avatar-md bg-success rounded">
                                        <i class='bx bx-objects-vertical-bottom  avatar-title  fs-24 text-white'></i>
                                    </div>
                                </div>
                                <div class="col-8 text-start">
                                    <p class="text-muted mb-0">  خططي  </p>
                                    <h3 class="text-dark mt-1 mb-0">    </h3>
                                </div>
                                <a style="margin-top: 10px" href="{{url('user/user_plans')}}" type="button" class="btn btn-sm btn-success">
                                    مشاهدة التفاصيل
                                    <i class="ti ti-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
    <!-- ==================================================== -->
    <!-- End Page Content -->
    <!-- ==================================================== -->


@endsection

