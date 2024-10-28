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
                    <div class="table-responsive">
                        @foreach ($plans as $invoice)

                            <div class="card info_card">
                                <div class="plan">
                                    <div class="plan_price">
                                        <h2> اسم الخطة </h2>
                                        <h6> {{ $invoice['plan']->name }} </h6>
                                    </div>
                                    <div class="plan_price">
                                        <h2> سعر الشراء </h2>
                                        <h6> {{ $invoice->plan_price }} $</h6>
                                    </div>
                                    <div class="plan_price">
                                        <h2> سعر السوق </h2>
                                        <h6> {{ $invoice['plan']->current_price }} $</h6>
                                    </div>
                                    <div class="plan_price">
                                        <h2> ربح </h2>
                                        <h6> {{ number_format($invoice['plan']->current_price - $invoice->plan_price,2) }}
                                            $</h6>
                                    </div>
                                    <div class="plan_price">
                                        <h2> تاريخ الاشتراك </h2>
                                        <h6>  {{ $invoice->created_at }} </h6>
                                    </div>

                                    <div class="plan_price">
                                        <h2> حالة الخطة  </h2>
                                        <h6>
                                            @if($invoice->status == 1)
                                                فعالة
                                            @elseif($invoice->status == 2)
                                               تم اغلاق الصفقة
                                            @elseif($invoice->status == 3)
                                                انسحاب
                                            @endif  </h6>
                                    </div>

                                    <div class="plan_price">
                                        @if($invoice->status ==1)
                                            <form method="post" action="{{url('user/invoice_withdraw')}}">
                                                <input type="hidden" name="invoice_id" value="{{$invoice['id']}}">
                                                @csrf
                                                <button type="submit" class="btn main_button btn-sm">
                                                    انسحاب
                                                </button>
                                            </form>
                                        @endif

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
