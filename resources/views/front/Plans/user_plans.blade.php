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
    <div class="page-content">
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
                    <div class="card info_card">
                        <h4 class="card-title flex-grow-1"> خططي </h4>
                    </div>
                    <div class="table-responsive">
                        <div class="total_plans">
                            <div class="card info_card">
                                <div class="plan">
                                    <div class="plan_price">
                                        <h2> عدد الخطط </h2>
                                        <h3> {{$totalPlansCount}}  </h3>
                                    </div>
                                    <div class="plan_price">
                                        <h2> راس المال </h2>
                                        <h6>  {{ number_format($totalbalance,2)}} $</h6>
                                    </div>
                                    <div class="plan_price">
                                        <h2>عائد الاستثمار</h2>
                                        <h6>  {{ number_format($investment_earning,2)}} $</h6>
                                    </div>
                                    <div class="plan_price">
                                        <h2> ربح اليوم </h2>
                                        <h6>  {{ number_format($daily_earning,2)}} $</h6>
                                    </div>
                                    <div class="plan_price">
                                        <h2> نسبة الربح </h2>
                                        <h6>  {{ number_format($totalDailyPercentage,2)}} %</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach($Plans as $platform)
                            @php
                                    $user = \Illuminate\Support\Facades\Auth::user();
                                    $totalPlansCount = \App\Models\front\Invoice::where('user_id', $user->id)->where('plan_id',$platform['id'])->count();
                                    $totalbalance = \App\Models\front\Invoice::where('user_id', $user->id)->where('plan_id',$platform['id'])->sum('plan_price');
                                    $investment_earning = \App\Models\admin\UserPlatformEarning::where('user_id', $user->id)->where('plan_id',$platform['id'])->sum('investment_return');
                                    $daily_earning = \App\Models\admin\UserPlatformEarning::where('user_id', $user->id)->where('plan_id',$platform['id'])->sum('daily_earning');
                                    $daily_percentage = \App\Models\admin\UserPlatformEarning::where('user_id',$user->id)->where('plan_id',$platform['id'])->sum('profit_percentage');
                            @endphp
                            <div class="platform-header">
                                <h2 class="platform_name"> عدد الاستثمارات في :: {{  $platform->name }}</h2>
                            </div>
                            <div class="card info_card">
                                <div class="plan">
                                    <div class="plan_price">
                                        <h2> مجموع الخطط </h2>
                                        <h3>{{ $platform->invoices_count  }}</h3>
                                    </div>
                                    <div class="plan_price">
                                        <h2> راس المال </h2>
                                        <h6> {{ $totalbalance  }} $</h6>
                                    </div>
                                    <div class="plan_price">
                                        <h2>عائد الاستثمار</h2>
                                        <h6> {{ $investment_earning  }} $</h6>
                                    </div>
                                    <div class="plan_price">
                                        <h2> ربح اليوم </h2>
                                        <h6> {{ $daily_earning }} $</h6>
                                    </div>
                                    <div class="plan_price">
                                        <h2> نسبة الربح </h2>
                                        <h6> {{ $daily_percentage   }} %</h6>
                                    </div>
                                    <div class="plan_price">
                                        <a class="btn main_button btn-sm"
                                           href="{{ route('user.plans.details', ['plan_id' => $platform->id]) }}">
                                            عرض الخطط
                                        </a>
                                    </div>
                                </div>
                            </div>
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
