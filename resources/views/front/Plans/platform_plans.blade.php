@extends('front.layouts.master_dashboard')
@section('title')
    تفاصيل الخطة
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

                            <h4 class="card-title flex-grow-1"> تفاصيل الاشتراكات </h4>

                    </div>
                    <div class="table-responsive my_new_container ">
                        @foreach ($plans as $invoice)
                            @if($invoice['status'] == 1)
                                <div class="plans_total_report plan_report_section plans_total_report_user_plans plans_total_report_platform_plans">
                                    <div class="total_report">
                                        <div>
                                            <h4 style="color:#10AE59"> {{ $invoice['plan']->name }} </h4>
                                            <p> $ {{ number_format($invoice->plan_price,2)}}   </p>
                                        </div>
                                        <div>
                                            <div class="plan_price">

                                                <h2> حالة الخطة  </h2>
                                                <h6 class="btn analytics_button">
                                                    @if($invoice->status == 1)
                                                        فعالة
                                                    @elseif($invoice->status == 2)
                                                        تم اغلاق الصفقة
                                                    @elseif($invoice->status == 3)
                                                        تم الانسحاب
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="plans">
                                        <div class="plans_details">
                                            <div class="plan1">
                                                <h4> 24 H </h4>
                                                <h4 style="color:#10AE59"> 10 $ </h4>
                                            </div>
                                            <div class="plan1">
                                                <h4> 7 D </h4>
                                                <h4 style="color:#10AE59"> 20 $ </h4>
                                            </div>

                                            <div class="plan1">
                                                <h4> 30 D </h4>
                                                <h4 style="color:#10AE59"> 30 $ </h4>
                                            </div>
                                            <div class="plan1">
                                                <h4>   تاريخ الاشتراك </h4>
                                                <h4 style="color:#10AE59">  {{ $invoice->created_at->diffForHumans() }} </h4>
                                            </div>
                                        </div>

                                        <div class="button_sections">

                                            @if($invoice->status ==1)
                                                <form method="post" action="{{url('user/invoice_withdraw')}}">
                                                    <input type="hidden" name="invoice_id" value="{{$invoice['id']}}">
                                                    @csrf
                                                    <button type="submit" class="btn withdraw_button">
                                                        انسحاب
                                                    </button>
                                                </form>
                                            @else
                                                <form method="post" action="{{url('user/invoice_withdraw')}}">
                                                    <input type="hidden" name="invoice_id" value="{{$invoice['id']}}">
                                                    @csrf
                                                    <button type="submit" class="btn withdraw_button">
                                                        اشتراك
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="table-responsive my_new_container">
                        <h4> سجل الاشتراكات  </h4>
                        @foreach ($plans as $invoice)
                            @if($invoice['status'] != 1)
                                <div class="plans_total_report plan_report_section plans_total_report_user_plans plans_total_report_platform_plans">
                                    <div class="total_report">
                                        <div>
                                            <h4 style="color:#10AE59"> {{ $invoice['plan']->name }} </h4>
                                            <p> $ {{ number_format($invoice->plan_price,2)}}   </p>
                                        </div>
                                        <div>
                                            <div class="plan_price">

                                                <h2> حالة الخطة  </h2>
                                                <h6 class="btn analytics_button">
                                                    @if($invoice->status == 1)
                                                        فعالة
                                                    @elseif($invoice->status == 2)
                                                        تم اغلاق الصفقة
                                                    @elseif($invoice->status == 3)
                                                        تم الانسحاب
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="plans">
                                        <div class="plans_details">
                                            <div class="plan1">
                                                <h4> 24 H </h4>
                                                <h4 style="color:#10AE59"> 10 $ </h4>
                                            </div>
                                            <div class="plan1">
                                                <h4> 7 D </h4>
                                                <h4 style="color:#10AE59"> 20 $ </h4>
                                            </div>

                                            <div class="plan1">
                                                <h4> 30 D </h4>
                                                <h4 style="color:#10AE59"> 30 $ </h4>
                                            </div>
                                            <div class="plan1">
                                                <h4>   تاريخ الاشتراك </h4>
                                                <h4 style="color:#10AE59">  {{ $invoice->created_at->diffForHumans() }} </h4>
                                            </div>
                                        </div>

                                        <div class="button_sections">

                                            @if($invoice->status ==1)
                                                <form method="post" action="{{url('user/invoice_withdraw')}}">
                                                    <input type="hidden" name="invoice_id" value="{{$invoice['id']}}">
                                                    @csrf
                                                    <button type="submit" class="btn withdraw_button">
                                                        انسحاب
                                                    </button>
                                                </form>
                                            @else
                                                <form method="post" action="{{url('user/invoice_withdraw')}}">
                                                    <input type="hidden" name="invoice_id" value="{{$invoice['id']}}">
                                                    @csrf
                                                    <button type="submit" class="btn withdraw_button" style="background-color:#fff;color:#000;">
                                                        اشتراك
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            @endif
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
