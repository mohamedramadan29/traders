@extends('admin.layouts.master')
@section('title')
    معاملات تخزين العملة
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
                        <div class="card-header d-flex justify-content-between align-items-center gap-1">
                            <h4 class="card-title flex-grow-1"> معاملات تخزين العملة </h4>
                        </div>
                        <div>
                            <div class="table-responsive">
                                <table id="table-search"
                                       class="table table-bordered gridjs-table align-middle mb-0 table-hover table-centered">
                                    <thead class="bg-light-subtle">
                                    <tr>
                                        <th style="width: 20px;">
                                        </th>
                                        <th> اسم المستخدم </th>
                                        <th>  مبلغ التخزين  </th>
                                        <th> عدد الايام    </th>
                                        <th> المعدل </th>
                                        <th> عدد عملة ال bin  </th>
                                        <th> تاريخ البداية  </th>
                                        <th> تاريخ النهاية  </th>
                                        <th> الحالة  </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($storages  as $storage)
                                        <tr>
                                            <td>
                                            {{ $loop->iteration }}
                                            </td>
                                            <td> <a style="color: #F2743F" href={{ url('admin/user_report/'.$storage['user_id']) }}> {{$storage['User']['name']}} </a> </td>
                                            <td>{{$storage['amount_invested']}} $ </td>
                                            <td>{{$storage['interest_date']}} يوم  </td>
                                            <td>{{$storage['interest_rate']}} ٪ </td>
                                            <td>{{$storage['bin_amount']}} Bin </td>
                                            <td>{{$storage['start_date']}}</td>
                                            <td>{{$storage['end_date']}}</td>
                                            <td>
                                                @if($storage['status'] == 1)
                                                    <span class="badge badge-outline-success"> فعالة  </span>
                                                @else
                                                    <span class="badge badge-outline-danger"> مغلقة  </span>
                                                @endif
                                            </td>

                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->
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
