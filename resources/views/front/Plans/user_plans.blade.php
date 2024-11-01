@extends('front.layouts.master_dashboard')
@section('title')
    خططي
@endsection
@section('css')
    {{--    <!-- DataTables CSS -->--}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection
@section('content')
    <!-- ==================================================== -->
    <div class="page-content user_plans">
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
                    {{--                    <div class="card info_card">--}}
                    {{--                        <h4 class="card-title flex-grow-1"> خططي </h4>--}}
                    {{--                    </div>--}}

                    <div class="plans_total_report">
                        <div class="total_report">
                            <h4> حجم الاستثمارت / الربح </h4>
                            <p> $ {{ number_format($totalbalance,2)}}   </p>
                            <h2> $ {{ number_format($investment_earning,2)}} </h2> <span> {{ number_format($totalDailyPercentage,2)}} % </span>
                            <a href="#" class="btn withdraw_button"> السحب <i class="bi bi-wallet"></i> </a>
                        </div>
                        <div class="plans">
                            @foreach($Plans as $platform)
                                @php
                                    $user = \Illuminate\Support\Facades\Auth::user();
                                      $daily_earning = \App\Models\admin\UserPlatformEarning::where('user_id', $user->id)->where('plan_id',$platform['id'])->sum('daily_earning');
                                    $daily_percentage = \App\Models\admin\UserPlatformEarning::where('user_id',$user->id)->where('plan_id',$platform['id'])->sum('profit_percentage');
                                @endphp
                                <div class="plan1">
                                    <h4> {{  $platform->name }} </h4>
                                    <select class="form-select">
                                        <option value="day"> 24 ساعة</option>
                                        <option value="7day"> 7 ايام</option>
                                        <option value="30day"> 30 يوم</option>
                                    </select>
                                    <h4 style="color:#10AE59"> {{$daily_earning}} $ </h4>
                                    <h4 style="color:#10AE59"> {{$daily_percentage}} % </h4>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="table-responsive">
{{--                        <div class="total_plans">--}}
{{--                            <div class="card info_card">--}}
{{--                                <div class="plan">--}}
{{--                                    <div class="plan_price">--}}
{{--                                        <h2> عدد الخطط </h2>--}}
{{--                                        <h3> {{$totalPlansCount}}  </h3>--}}
{{--                                    </div>--}}
{{--                                    <div class="plan_price">--}}
{{--                                        <h2> راس المال </h2>--}}
{{--                                        <h6>  {{ number_format($totalbalance,2)}} $</h6>--}}
{{--                                    </div>--}}
{{--                                    <div class="plan_price">--}}
{{--                                        <h2>عائد الاستثمار</h2>--}}
{{--                                        <h6>  {{ number_format($investment_earning,2)}} $</h6>--}}
{{--                                    </div>--}}
{{--                                    <div class="plan_price">--}}
{{--                                        <h2> ربح اليوم </h2>--}}
{{--                                        <h6>  {{ number_format($daily_earning,2)}} $</h6>--}}
{{--                                    </div>--}}
{{--                                    <div class="plan_price">--}}
{{--                                        <h2> نسبة الربح </h2>--}}
{{--                                        <h6>  {{ number_format($totalDailyPercentage,2)}} %</h6>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        @foreach($Plans as $platform)
                            @php
                                $user = \Illuminate\Support\Facades\Auth::user();
                                $totalPlansCount = \App\Models\front\Invoice::where('user_id', $user->id)->where('plan_id',$platform['id'])->count();
                                $totalbalance = \App\Models\front\Invoice::where('user_id', $user->id)->where('plan_id',$platform['id'])->sum('plan_price');
                                $investment_earning = \App\Models\admin\UserPlatformEarning::where('user_id', $user->id)->where('plan_id',$platform['id'])->sum('investment_return');
                                $daily_earning = \App\Models\admin\UserPlatformEarning::where('user_id', $user->id)->where('plan_id',$platform['id'])->sum('daily_earning');
                                $daily_percentage = \App\Models\admin\UserPlatformEarning::where('user_id',$user->id)->where('plan_id',$platform['id'])->sum('profit_percentage');
                            @endphp
                            <div class="plans_total_report plan_report_section">
                                <div class="total_report">
                                    <h4> حجم الاستثمارت / الربح </h4>
                                    <p> $ {{ number_format($totalbalance,2)}}   </p>
                                    <h2> $ {{ number_format($investment_earning,2)}} </h2> <span> {{ number_format($totalDailyPercentage,2)}} % </span>
                                    <a href="{{ route('user.plans.details', ['plan_id' => $platform->id]) }}" class="btn analytics_button"> الاحصائيات    </a>
                                </div>
                                <div class="plans">
                                    <div class="plans_details">
                                        <div class="plan1">
                                            <h4>  24 ساعة  </h4>
                                            <h4 style="color:#10AE59"> {{$daily_earning}} $ </h4>
                                            <h4 style="color:#10AE59"> {{$daily_percentage}} % </h4>
                                        </div>
                                        <div class="plan1">
                                            <h4>  7 ايام   </h4>
                                            <h4 style="color:#10AE59"> {{$daily_earning}} $ </h4>
                                            <h4 style="color:#10AE59"> {{$daily_percentage}} % </h4>
                                        </div>
                                        <div class="plan1">
                                            <h4>  30 يوم   </h4>
                                            <h4 style="color:#10AE59"> {{$daily_earning}} $ </h4>
                                            <h4 style="color:#10AE59"> {{$daily_percentage}} % </h4>
                                        </div>
                                        <div class="plan1">
                                            <h4> {{  $platform->name }} </h4>
                                            <h4> {{ $platform->invoices_count  }} </h4>
                                            <img src="{{asset('assets/uploads/payments.svg')}}">
                                        </div>
                                    </div>

                                    <div class="button_sections">
                                        <a href="{{ route('user.plans.details', ['plan_id' => $platform->id]) }}" class="btn analytics_button"> عرض كل الخطط <i class="bi bi-arrow-left"></i> </a>
                                        <form method="post" action="{{url('user/invoice_create')}}">
                                            <input type="hidden" name="plan_id" value="{{$platform['id']}}">
                                            @csrf
                                            <button type="submit" class="btn withdraw_button">
                                                اشتراك
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </div>

{{--                            <div class="platform-header">--}}
{{--                                <h2 class="platform_name"> عدد الاستثمارات في :: {{  $platform->name }}</h2>--}}
{{--                            </div>--}}
{{--                            <div class="card info_card">--}}
{{--                                <div class="plan">--}}
{{--                                    <div class="plan_price">--}}
{{--                                        <h2> مجموع الخطط </h2>--}}
{{--                                        <h3>{{ $platform->invoices_count  }}</h3>--}}
{{--                                    </div>--}}
{{--                                    <div class="plan_price">--}}
{{--                                        <h2> راس المال </h2>--}}
{{--                                        <h6> {{ $totalbalance  }} $</h6>--}}
{{--                                    </div>--}}
{{--                                    <div class="plan_price">--}}
{{--                                        <h2>عائد الاستثمار</h2>--}}
{{--                                        <h6> {{ $investment_earning  }} $</h6>--}}
{{--                                    </div>--}}
{{--                                    <div class="plan_price">--}}
{{--                                        <h2> ربح اليوم </h2>--}}
{{--                                        <h6> {{ $daily_earning }} $</h6>--}}
{{--                                    </div>--}}
{{--                                    <div class="plan_price">--}}
{{--                                        <h2> نسبة الربح </h2>--}}
{{--                                        <h6> {{ $daily_percentage   }} %</h6>--}}
{{--                                    </div>--}}
{{--                                    <div class="plan_price">--}}
{{--                                        <a class="btn main_button btn-sm"--}}
{{--                                           href="{{ route('user.plans.details', ['plan_id' => $platform->id]) }}">--}}
{{--                                            عرض الخطط--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        @endforeach
                    </div>
                    <!-- end table-responsive -->


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
    {{--    <!-- DataTables JS -->--}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            // تحقق ما إذا كان الجدول قد تم تهيئته من قبل
            if ($.fn.DataTable.isDataTable('#table-search')) {
                $('#table-search').DataTable().destroy(); // تدمير التهيئة السابقة
            }

            // تهيئة DataTables من جديد
            $('#table-search').DataTable({
                "language": {
                    "search": "بحث:",
                    "lengthMenu": "عرض _MENU_ عناصر لكل صفحة",
                    "zeroRecords": "لم يتم العثور على سجلات",
                    "info": "عرض _PAGE_ من _PAGES_",
                    "infoEmpty": "لا توجد سجلات متاحة",
                    "infoFiltered": "(تمت التصفية من إجمالي _MAX_ سجلات)",
                    "paginate": {
                        "previous": "السابق",
                        "next": "التالي"
                    }
                }
            });
        });
    </script>
@endsection
