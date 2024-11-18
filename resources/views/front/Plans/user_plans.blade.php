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
                <div class="col-xl-12">
                    <div class="card info_card ">
                        <h4 class="card-title flex-grow-1"> خططي </h4>
                    </div>
                    <div class="user_plans_page_info my_new_container">
                        <div class="info">
                            <h5> اجمالي الاسثمارات  </h5>
                            <h4 class="total_investment"> 1500.50 $ </h4>
                            <p class="percentage"> +3.5(3%) <span> اليوم <i class="bi bi-arrow-down-short"></i> </span> </p>
                            <div class="buttons">
                                <a href="#" class="public_button"> ايداع  </a>
                                <a href="#" class="stat"> الاحصائيات   </a>
                            </div>
                        </div>
                        <div class="info">
                            <h5> الربح  </h5>
                            <h4 class="profit_balance"> 50.90 $ </h4>
                            <a class="stat"> سحب  </a>
                        </div>
                        <div class="info">
                            <h5> id 5544554458 </h5>
                            <img src="{{asset('assets/uploads/plans/1730789542_6729c0a640f27.png')}}">
                        </div>
                    </div>
                    <hr>
                    <div class="user_plans_page_info my_new_container" style="background-color:#52546e">
                        <div class="info">
                            <h5> خطة التداول في Qoutex </h5>
                            <h4 class="total_investment"> 1500.50 $ </h4>
                            <p class="percentage"> +3.5(3%) <span> اليوم <i class="bi bi-arrow-down-short"></i> </span> </p>
                            <div class="buttons">
                                <a href="#" class="public_button"  data-bs-toggle="modal"  data-bs-target="#edit_balance"> تعديل الرصيد   </a>
                                <a href="#" class="stat"> المعاملات    </a>
                            </div>
                        </div>
                        @include('front.Plans.edit_balance')

                        <div class="info">
                            <h5> الربح  </h5>
                            <h4 class="profit_balance"> 50.90 $ </h4>
                            <a class="stat"> سحب  </a>
                        </div>
                        <div class="info">
                            <h5> Qoutex </h5>
                            <img src="{{asset('assets/uploads/plans/1730789542_6729c0a640f27.png')}}">
                        </div>
                    </div>
                    <div class="my_new_container transactions">
                        <div class="top_buttons">
                            <button class="trans_button"> كل المعاملات  </button>
                            <button class="trans_button">  اضافة رصيد   </button>
                            <button class="trans_button">  سحب رصيد  </button>
                            <button class="trans_button">  الارباح اليومية  </button>
                        </div>
                        <div class="trans_info">
                            <ul class="list-unstyled">
                                <li>  <span class="increase"> + 50  </span>دولار الي راس المال  بتاريخ <span> 5 / 11 / 2024 </span> </li>
                                <li>  <span class="increase"> + 50  </span>دولار الي راس المال  بتاريخ <span> 5 / 11 / 2024 </span> </li>
                                <li>  <span class="decrease"> - 50  </span>دولار الي راس المال  بتاريخ <span> 5 / 11 / 2024 </span> </li>
                                <li>  <span class="increase"> + 50  </span>دولار الي راس المال  بتاريخ <span> 5 / 11 / 2024 </span> </li>
                                <li>  <span class="increase"> + 50  </span>دولار الي راس المال  بتاريخ <span> 5 / 11 / 2024 </span> </li>
                                <li>  <span class="decrease"> - 30  </span>دولار الي راس المال  بتاريخ <span> 5 / 11 / 2024 </span> </li>
                                <li>  <span class="increase"> + 50  </span>دولار الي راس المال  بتاريخ <span> 5 / 11 / 2024 </span> </li>
                                <li>  <span class="increase"> + 50  </span>دولار الي راس المال  بتاريخ <span> 5 / 11 / 2024 </span> </li>
                                <li>  <span class="increase"> + 50  </span>دولار الي راس المال  بتاريخ <span> 5 / 11 / 2024 </span> </li>
                                <li>  <span class="decrease"> - 50  </span>دولار الي راس المال  بتاريخ <span> 5 / 11 / 2024 </span> </li>
                                <li>  <span class="increase"> + 50  </span>دولار الي راس المال  بتاريخ <span> 5 / 11 / 2024 </span> </li>
                                <li>  <span class="increase"> + 50  </span>دولار الي راس المال  بتاريخ <span> 5 / 11 / 2024 </span> </li>
                                <li>  <span class="increase"> + 50  </span>دولار الي راس المال  بتاريخ <span> 5 / 11 / 2024 </span> </li>
                                <li>  <span class="increase"> + 50  </span>دولار الي راس المال  بتاريخ <span> 5 / 11 / 2024 </span> </li>
                            </ul>
                        </div>
                    </div>

{{--                    <div class="plans_total_report my_new_container plans_total_report_user_plans">--}}
{{--                        <div class="total_report">--}}
{{--                            <div>--}}
{{--                                <h4> حجم الاستثمارت / الربح </h4>--}}
{{--                                <p> $ {{ number_format($totalbalance,2)}}   </p>--}}
{{--                            </div>--}}
{{--                            <div style="width: 35%">--}}
{{--                                <h4>   الربح </h4>--}}
{{--                                <p> <span style="font-size: 10px;position: relative; top: 4px;"> {{ number_format($totalDailyPercentage,2)}} % </span> $ {{ number_format($investment_earning,2)}}  </p>--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <a href="{{url('user/withdraws')}}" class="btn withdraw_button"> السحب <i class="bi bi-wallet"></i> </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="plans">--}}
{{--                            @foreach($Plans as $platform)--}}
{{--                                @php--}}
{{--                                    $user = \Illuminate\Support\Facades\Auth::user();--}}
{{--                                    // الأرباح والنسبة لآخر يوم--}}
{{--                                    $lastDayReturns = \App\Models\admin\UserDailyInvestmentReturn::where('user_id', $user->id)--}}
{{--                                                        ->where('plan_id', $platform['id'])--}}
{{--                                                        ->whereDate('created_at', now()->subDay())--}}
{{--                                                        ->sum('daily_return');--}}
{{--                                    $lastDayPercentage = \App\Models\admin\UserDailyInvestmentReturn::where('user_id', $user->id)--}}
{{--                                                        ->where('plan_id', $platform['id'])--}}
{{--                                                        ->whereDate('created_at', now()->subDay())--}}
{{--                                                        ->sum('profit_percentage');--}}
{{--                                @endphp--}}
{{--                                <div class="plan1">--}}
{{--                                    <h4> {{ $platform->name }} </h4>--}}
{{--                                    <select class="form-select period-select" data-platform-id="{{ $platform->id }}">--}}
{{--                                        <option value="day">24 H</option>--}}
{{--                                        <option value="7day">7 D</option>--}}
{{--                                        <option value="30day">30 D</option>--}}
{{--                                    </select>--}}
{{--                                    <h4 style="color:#10AE59" class="daily-earning"--}}
{{--                                        data-platform-id="{{ $platform->id }}">{{$lastDayReturns}} $</h4>--}}
{{--                                    <h4 style="color:#10AE59" class="daily-percentage"--}}
{{--                                        data-platform-id="{{ $platform->id }}"> {{$lastDayPercentage}} %</h4>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}


{{--                            <script>--}}
{{--                                document.querySelectorAll('.period-select').forEach(select => {--}}
{{--                                    select.addEventListener('change', function () {--}}
{{--                                        const platformId = this.getAttribute('data-platform-id');--}}
{{--                                        const period = this.value;--}}

{{--                                        fetch(`plans/report/${platformId}/${period}`)--}}
{{--                                            .then(response => response.json())--}}
{{--                                            .then(data => {--}}
{{--                                                // تحديث الأرباح والنسبة على الشاشة باستخدام data-platform-id--}}
{{--                                                document.querySelector(`.daily-earning[data-platform-id="${platformId}"]`).textContent = `${data.daily_earning} $`;--}}
{{--                                                document.querySelector(`.daily-percentage[data-platform-id="${platformId}"]`).textContent = `${data.daily_percentage} %`;--}}
{{--                                            })--}}
{{--                                            .catch(error => console.error('Error:', error));--}}
{{--                                    });--}}
{{--                                });--}}
{{--                            </script>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="table-responsive my_new_container">--}}
{{--                        @foreach($Plans as $platform)--}}
{{--                            @php--}}
{{--                                $user = \Illuminate\Support\Facades\Auth::user();--}}
{{--                                $totalPlansCount = \App\Models\front\Invoice::where('user_id', $user->id)->where('plan_id',$platform['id'])->count();--}}
{{--                                $totalbalance = \App\Models\front\Invoice::where('user_id', $user->id)->where('plan_id',$platform['id'])->sum('plan_price');--}}
{{--                                $investment_earning = \App\Models\admin\UserPlatformEarning::where('user_id', $user->id)->where('plan_id',$platform['id'])->sum('investment_return');--}}
{{--                                $daily_earning = \App\Models\admin\UserPlatformEarning::where('user_id', $user->id)->where('plan_id',$platform['id'])->sum('daily_earning');--}}
{{--                                $daily_percentage = \App\Models\admin\UserPlatformEarning::where('user_id',$user->id)->where('plan_id',$platform['id'])->sum('profit_percentage');--}}


{{--        // الأرباح والنسبة لآخر يوم--}}
{{--        $lastDayReturns = \App\Models\admin\UserDailyInvestmentReturn::where('user_id', $user->id)--}}
{{--                            ->where('plan_id', $platform['id'])--}}
{{--                            ->whereDate('created_at', now()->subDay())--}}
{{--                            ->sum('daily_return');--}}
{{--        $lastDayPercentage = \App\Models\admin\UserDailyInvestmentReturn::where('user_id', $user->id)--}}
{{--                            ->where('plan_id', $platform['id'])--}}
{{--                            ->whereDate('created_at', now()->subDay())--}}
{{--                            ->sum('profit_percentage');--}}

{{--                // حساب العائد والنسبة لآخر 7 أيام إذا كانت البيانات متاحة، وإلا جمع البيانات المتاحة فقط--}}
{{--        $sevenDaysData = \App\Models\admin\UserDailyInvestmentReturn::where('user_id', $user->id)--}}
{{--                            ->where('plan_id', $platform['id'])--}}
{{--                            ->whereDate('created_at', '>=', now()->subDays(7));--}}
{{--        $sevenDaysReturns = $sevenDaysData->sum('daily_return');--}}
{{--        $sevenDaysPercentage = $sevenDaysData->sum('profit_percentage');--}}
{{--        $availableDays7 = $sevenDaysData->count();--}}

{{--         // حساب العائد والنسبة لآخر 30 يومًا إذا كانت البيانات متاحة، وإلا جمع البيانات المتاحة فقط--}}
{{--        $thirtyDaysData = \App\Models\admin\UserDailyInvestmentReturn::where('user_id', $user->id)--}}
{{--                            ->where('plan_id', $platform['id'])--}}
{{--                            ->whereDate('created_at', '>=', now()->subDays(30));--}}
{{--        $thirtyDaysReturns = $thirtyDaysData->sum('daily_return');--}}
{{--        $thirtyDaysPercentage = $thirtyDaysData->sum('profit_percentage');--}}
{{--        $availableDays30 = $thirtyDaysData->count();--}}

{{--                            @endphp--}}
{{--                            <div class="plans_total_report plan_report_section user_plans_page">--}}
{{--                                <div class="total_report">--}}
{{--                                    <div>--}}
{{--                                        <h4> حجم الاستثمارت / الربح </h4>--}}
{{--                                        <p> $ {{ number_format($totalbalance,2)}}   </p>--}}
{{--                                    </div>--}}
{{--                                    <div style="width: 35%">--}}
{{--                                        <h4>   الربح </h4>--}}
{{--                                        <p> <span style="font-size: 10px;position: relative; top: 4px;"> {{ number_format($totalDailyPercentage,2)}} % </span>  $ {{ number_format($investment_earning,2)}}  </p>--}}
{{--                                    </div>--}}
{{--                                    <div>--}}
{{--                                        <a href="{{ route('user.plans.details', ['plan_id' => $platform->id]) }}"--}}
{{--                                           class="btn analytics_button"> الاحصائيات </a>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                                <div class="plans">--}}
{{--                                    <div class="plans_details">--}}
{{--                                        <div class="plan1">--}}
{{--                                            <h4> 24 H </h4>--}}
{{--                                            <h4 style="color:#10AE59"> {{$lastDayReturns}} $ </h4>--}}
{{--                                            <h4 style="color:#10AE59"> {{$lastDayPercentage}} % </h4>--}}
{{--                                        </div>--}}
{{--                                        <div class="plan1">--}}
{{--                                            <h4> 7 D </h4>--}}
{{--                                            <h4 style="color:#10AE59"> {{$sevenDaysReturns}} $ </h4>--}}
{{--                                            <h4 style="color:#10AE59"> {{$sevenDaysPercentage}} % </h4>--}}
{{--                                        </div>--}}

{{--                                        <div class="plan1">--}}
{{--                                            <h4> 30 D </h4>--}}
{{--                                            <h4 style="color:#10AE59"> {{$thirtyDaysReturns}} $ </h4>--}}
{{--                                            <h4 style="color:#10AE59"> {{$thirtyDaysPercentage}} % </h4>--}}
{{--                                        </div>--}}
{{--                                        <div class="plan1">--}}
{{--                                            <h4> {{  $platform->name }} </h4>--}}
{{--                                            <h4> {{ $platform->invoices_count  }} </h4>--}}
{{--                                            <img src="{{asset('assets/uploads/plans/'.$platform['logo'])}}">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="button_sections button_sections_user_plans_page ">--}}
{{--                                        <a href="{{ route('user.plans.details', ['plan_id' => $platform->id]) }}"--}}
{{--                                           class="btn analytics_button"> عرض كل الخطط <i class="bi bi-arrow-left"></i>--}}
{{--                                        </a>--}}
{{--                                        <form method="post" action="{{url('user/invoice_create')}}">--}}
{{--                                            <input type="hidden" name="plan_id" value="{{$platform['id']}}">--}}
{{--                                            @csrf--}}
{{--                                            <button type="submit" class="btn withdraw_button">--}}
{{--                                                اشتراك--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
{{--                                    </div>--}}


{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
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
