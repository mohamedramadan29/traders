@extends('front.layouts.master_dashboard')
@section('title')
    الخطط المتاحة
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
                        <h4 class="card-title flex-grow-1"> الخطط المتاحة </h4>
                    </div>
                    <div>
                        <div class="table-responsive">
                            {{--                                @foreach ($plans->groupBy('platform_id') as $platformPlans)--}}
                            <!-- عرض اسم المنصة -->
                            {{--                                    <div class="platform-header">--}}
                            {{--                                        <h2 class="platform_name"> خطط الاستثمار في ::  {{ $platformPlans->first()->platform->name }}</h2>--}}
                            {{--                                    </div>--}}
                            @foreach($plans as $plan)
                                <div class="plans_total_report plan_report_section">
                                    <div class="total_report">
{{--                                        <h4> اسم الخطة </h4>--}}
                                        <p> {{ $plan['name']}}   </p>
                                        <form method="post" action="{{url('user/invoice_create')}}">
                                            <input type="hidden" name="plan_id" value="{{$plan['id']}}">
                                            @csrf
                                            <button style="display: block;width: 100%;margin-top: 20px" type="submit" class="btn withdraw_button">
                                                اشتراك
                                            </button>
                                        </form>
                                    </div>
                                    <div class="plans">
                                        <div class="plans_details">
                                            <div class="plan1">
                                                <h4>سعر الشراء  </h4>
                                                <h4 style="color:#10AE59">  {{ $plan['current_price'] }} $ </h4>

                                            </div>
                                            <div class="plan1">
                                                <h4> عائد الاستثمار  </h4>
                                                <h4 style="color:#10AE59"> {{ $plan['return_investment']  }} $ </h4>
                                            </div>

                                            <div class="plan1">

                                                <img src="{{asset('assets/uploads/payments.svg')}}">
                                            </div>
                                        </div>

{{--                                        <div class="button_sections">--}}
{{--                                            <a href="{{ route('user.plans.details', ['plan_id' => $platform->id]) }}"--}}
{{--                                               class="btn analytics_button"> عرض كل الخطط <i--}}
{{--                                                    class="bi bi-arrow-left"></i> </a>--}}
{{--                                            <form method="post" action="{{url('user/invoice_create')}}">--}}
{{--                                                <input type="hidden" name="plan_id" value="{{$platform['id']}}">--}}
{{--                                                @csrf--}}
{{--                                                <button type="submit" class="btn withdraw_button">--}}
{{--                                                    اشتراك--}}
{{--                                                </button>--}}
{{--                                            </form>--}}
{{--                                        </div>--}}
                                    </div>

                                </div>

{{--                                <div class="card info_card">--}}
{{--                                    <div class="plan">--}}
{{--                                        <div class="plan_price">--}}
{{--                                            <h2> اسم الخطة </h2>--}}
{{--                                            <h6> {{ $plan['name']}} </h6>--}}
{{--                                        </div>--}}
{{--                                        <div class="plan_price">--}}
{{--                                            <h2> سعر الشراء </h2>--}}
{{--                                            <h6> {{ $plan['main_price'] }} $</h6>--}}
{{--                                        </div>--}}

{{--                                        <div class="plan_price">--}}
{{--                                            <h2> عائد الاستثمار </h2>--}}
{{--                                            <h6> {{ $plan['return_investment']  }} $</h6>--}}
{{--                                        </div>--}}
{{--                                        <div class="plan_price">--}}
{{--                                            <form method="post" action="{{url('user/invoice_create')}}">--}}
{{--                                                <input type="hidden" name="plan_id" value="{{$plan['id']}}">--}}
{{--                                                @csrf--}}
{{--                                                <button type="submit" class="btn main_button btn-sm"--}}
{{--                                                >--}}
{{--                                                    اشتراك--}}
{{--                                                </button>--}}
{{--                                            </form>--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                {{--                                    @endforeach--}}
                            @endforeach
                        </div>

                        <!-- end table-responsive -->
                    </div>

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
