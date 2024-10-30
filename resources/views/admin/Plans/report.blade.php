@extends('admin.layouts.master')
@section('title')
   تقرير كامل عن الخطة
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
                    <div class="card">
                          <div class="row">
                              <div class="col-4">
                                  <h4> عدد الاشتركات الكلي ::  </h4>
                                  <h5> {{ $allinvoices}} </h5>
                              </div>
                              <div class="col-4">
                                  <h4> عدد الاشتراكات الفعالة ::  </h4>
                                  <h5> {{$active_invoice}} </h5>
                              </div>
                              <div class="col-4">
                                  <h4> مجموع الاشتركات الفعالة ::   </h4>
                                  <h5> {{$active_invoice_sum }} $ </h5>
                              </div>

                          </div>
                        <div class="table-responsive">
                            <h2>التقرير اليومي للاشتراكات</h2>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>التاريخ</th>
                                    <th>عدد الاشتراكات</th>
                                    <th>مجموع الاشتراكات</th>
                                    <th>أقل سعر اشتراك</th>
                                    <th>أعلى سعر اشتراك</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($dailyReport as $report)
                                    <tr>
                                        <td>{{ $report->date }}</td>
                                        <td>{{ $report->daily_count }}</td>
                                        <td>{{ number_format($report->daily_sum, 2) }} $</td>
                                        <td>{{ number_format($report->min_price, 2) }} $</td>
                                        <td>{{ number_format($report->max_price, 2) }} $</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

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
