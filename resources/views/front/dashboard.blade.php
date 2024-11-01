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

                <div class="plans_total_report plan_report_section">
                    <div class="total_report">
                        <h4>  الرصيد الكلي </h4>
                        <p>  @php
                                echo  \Illuminate\Support\Facades\Auth::user()->total_balance  . ' $ ';
                            @endphp
                        </p>
                        <br>
                        <a href="{{url('user/withdraws')}}"
                           class="btn analytics_button"> الاحصائيات </a>
                    </div>
                    <div class="plans">
                        <div class="plans_details">
                            <div class="plan1">
                                <h4>  كل الخطط </h4>
                                <h4 style="color:#10AE59"> @php
                                        echo count(\App\Models\admin\Plan::where('status',1)->get())
                                    @endphp
                                </h4>
                                <a style="margin-top: 10px;display: block" href="{{url('user/plans')}}" type="button"
                                   class="btn btn-sm btn-success">
                                      التفاصيل
                                    <i class="ti ti-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="plans">
                        <div class="plans_details">
                            <div class="plan1">
                                <h4> عدد الخطط المفعلة  </h4>
                                <h4 style="color:#10AE59">
                                    @php
                                        echo count(\App\Models\front\Invoice::where('user_id',\Illuminate\Support\Facades\Auth::id())->where('status',1)->get())
                                    @endphp
                                </h4>
                                <a style="margin-top: 10px;display: block" href="{{url('user/user_plans')}}" type="button"
                                   class="btn btn-sm btn-success">
                                      التفاصيل
                                    <i class="ti ti-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

{{--                <div class="col-md-6 col-xl-3">--}}
{{--                    <div class="card info_card">--}}
{{--                        <div class="col-12 text-start">--}}
{{--                            <p class=" mb-0"> الرصيد الكلي  </p>--}}
{{--                            <h3 class="mt-1 mb-0">--}}
{{--                                @php--}}
{{--                                   echo \Illuminate\Support\Facades\Auth::user()->total_balance . ' $ ';--}}
{{--                                @endphp--}}
{{--                            </h3>--}}
{{--                        </div>--}}
{{--                        <a style="margin-top: 10px" href="{{url('user/plans')}}" type="button"--}}
{{--                           class="btn btn-sm btn-success">--}}
{{--                            سحب الرصيد--}}
{{--                            <i class="ti ti-eye"></i>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-6 col-xl-3">--}}
{{--                    <div class="card info_card">--}}
{{--                        <div class="col-12 text-start">--}}
{{--                            <p class=" mb-0"> كل الخطط </p>--}}
{{--                            <h3 class="mt-1 mb-0">--}}
{{--                                @php--}}
{{--                                    echo count(\App\Models\admin\Plan::where('status',1)->get())--}}
{{--                                @endphp--}}
{{--                            </h3>--}}
{{--                        </div>--}}
{{--                        <a style="margin-top: 10px" href="{{url('user/plans')}}" type="button"--}}
{{--                           class="btn btn-sm btn-success">--}}
{{--                            مشاهدة التفاصيل--}}
{{--                            <i class="ti ti-eye"></i>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-6 col-xl-3">--}}
{{--                    <div class="card info_card">--}}
{{--                        <div class="col-8 text-start">--}}
{{--                            <p class="mb-0"> عدد الخطط المفعلة   </p>--}}
{{--                            <h3 class="mt-1 mb-0">--}}
{{--                                @php--}}
{{--                                    echo count(\App\Models\front\Invoice::where('user_id',\Illuminate\Support\Facades\Auth::id())->where('status',1)->get())--}}
{{--                                @endphp--}}
{{--                            </h3>--}}
{{--                        </div>--}}
{{--                        <a style="margin-top: 10px" href="{{url('user/user_plans')}}" type="button"--}}
{{--                           class="btn btn-sm btn-success">--}}
{{--                            مشاهدة التفاصيل--}}
{{--                            <i class="ti ti-eye"></i>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-6 col-xl-3">--}}
{{--                    <div class="card info_card">--}}
{{--                        <div class="col-8 text-start">--}}
{{--                            <p class="mb-0">  الخطط المغلقة    </p>--}}
{{--                            <h3 class="mt-1 mb-0">--}}
{{--                                @php--}}
{{--                                    echo count(\App\Models\front\Invoice::where('user_id',\Illuminate\Support\Facades\Auth::id())->where('status','!=',1)->get())--}}
{{--                                @endphp--}}
{{--                            </h3>--}}
{{--                        </div>--}}
{{--                        <a style="margin-top: 10px" href="{{url('user/user_plans')}}" type="button"--}}
{{--                           class="btn btn-sm btn-success">--}}
{{--                            مشاهدة التفاصيل--}}
{{--                            <i class="ti ti-eye"></i>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
    <!-- ==================================================== -->
    <!-- End Page Content -->
    <!-- ==================================================== -->

@endsection

