@extends('admin.layouts.master')
@section('title')
    خطط العملات الرقمية
@endsection
@section('css')
    {{--    <!-- DataTables CSS --> --}}
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
                            <h4 class="card-title flex-grow-1"> خطط العملات الرقمية </h4>
                            <a class="btn btn-primary btn-sm" href="{{ url('admin/currency_plan/store') }}"> اضافة خطة
                                <i class="ti ti-plus"></i> </a>
                        </div>
                        <div>
                            <div class="table-responsive">
                                <table id="table-search"
                                    class="table table-bordered gridjs-table align-middle mb-0 table-hover table-centered">
                                    <thead class="bg-light-subtle">
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th> اسم الخطة </th>
                                            <th> الرابط </th>
                                            <th> اللوجو </th>
                                            <th> عدد العملات </th>
                                            <th> قيمة الاستثمارات الاولي </th>
                                            <th> قيمة الاستثمارات الحالية </th>
                                            <th> سعر العملة الاولي </th>
                                            <th> السعر الحالي </th>
                                            <th> عدد المستثمرين </th>
                                            <th> الحالة </th>
                                            <th> العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($plans as $plan)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>{{ $plan['name'] }}</td>
                                                <td>{{ $plan['url'] }}</td>
                                                <td>
                                                    <img width="40px" height="40px"
                                                        src="{{ asset('assets/uploads/currency/' . $plan['logo']) }}"
                                                        alt="">
                                                </td>
                                                <td>
                                                    {{ number_format($plan->curreny_number, 4) }} عملة
                                                </td>
                                                <td> {{ number_format($plan->main_investment, 4) }} $ </td>
                                                <td>
                                                    @php
                                                        $totalinvestments =
                                                            $plan['main_investment'] + $plan['current_investments'];
                                                    @endphp
                                                    {{ number_format($totalinvestments, 2) }} $
                                                </td>
                                                <td>{{ $plan['currency_main_price'] }} $</td>
                                                <td>{{ $plan['currency_current_price'] }} $</td>
                                                <td> {{ $plan->investments->count() }} </td>
                                                <td>
                                                    @if ($plan['status'] == 1)
                                                        <span class="badge badge-outline-success"> فعالة </span>
                                                    @else
                                                        <span class="badge badge-outline-danger"> مغلقة </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a class="btn btn-info btn-sm"
                                                            href="{{ url('admin/currency_plan/update/' . $plan['id']) }}">
                                                            <i class="ti ti-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-soft-success btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#add_balance_{{ $plan['id'] }}">
                                                            <i class="ti ti-plus"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-soft-danger btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#remove_balance_{{ $plan['id'] }}">
                                                            <i class="ti ti-minus"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-soft-danger btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#delete_plan_{{ $plan['id'] }}">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Modal -->
                                            @include('admin.CurrencyPlans._delete')
                                            @include('admin.CurrencyPlans._addbalance')
                                            @include('admin.CurrencyPlans._removebalance')
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
    {{--    <!-- DataTables JS --> --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
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
