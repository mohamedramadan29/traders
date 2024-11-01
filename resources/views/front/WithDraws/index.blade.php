@extends('front.layouts.master_dashboard')
@section('title')
    طلبات السحب
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

                <div class="col-12">
                    <div class="card info_card">
                        <div class="card-header">
                            <h4 class="card-title flex-grow-1"> الرصيد والمعاملات المالية </h4>
                        </div>
                    </div>
                    <div>
                        <div class="table-responsive">
                            <div class="plans_total_report plan_report_section">
                                <div class="total_report">
                                    <h4 style="font-size: 17px">  الرصيد الكلي   </h4>

                                    <h4 style="color:#10AE59;font-size:17px">  {{number_format($total_balance,2)}} $ </h4>
{{--                                        <a style="display: block;width: 100%;margin-top: 20px" type="submit" class="btn withdraw_button">--}}
{{--                                            سحب الرصيد--}}
{{--                                        </a>--}}
                                    <button style="display: block;width: 100%;margin-top: 20px" type="button" class="btn withdraw_button" data-bs-toggle="modal"
                                            data-bs-target="#add_attribute">
                                        سحب الرصيد

                                    </button>
                                </div>
                                <div class="plans" id="withdraws">
                                    <div class="plans_details">
                                        <div class="plan1">
                                            <h4>طلبت السحب الحالية  </h4>
                                            <h4 style="color:#10AE59">  {{ number_format($withdrawSum,2) }} $ </h4>
                                        </div>
                                        <div class="plan1">
                                            <h4> مجموع السحوبات  </h4>
                                            <h4 style="color:#10AE59"> {{ number_format($withdrawSumCompeleted,2) }} $ </h4>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-12">
                    <div class="card">
                        @php

                                @endphp
                        <div class="card-header d-flex justify-content-between align-items-center gap-1">
                            <h4 class="card-title flex-grow-1"> طلبات السحب </h4>

                            @include('front.WithDraws.add')
                        </div>


                        <div>
                            <div class="table-responsive">
                                <table id="table-search"
                                       class="table table-bordered gridjs-table align-middle mb-0 table-hover table-centered">
                                    <thead class="bg-light-subtle">
                                    <tr>
                                        <th style="width: 20px;">
                                        </th>
                                        <th> المبلغ</th>
                                        <th> المحفظة</th>
                                        <th> عنوان المحفظة  </th>
                                        <th> الحالة</th>
                                        <th> العمليات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php

                                        $i = 1;
                                    @endphp
                                    @foreach($withdraws as $withdraw)
                                        <tr>
                                            <td>
                                                {{$i++}}
                                            </td>

                                            <td> {{$withdraw['amount']}} دولار</td>
                                            <td> {{$withdraw['withdraw_method']}} </td>
                                            <td>
                                                <span id="usdtLink_{{$withdraw['id']}}">{{$withdraw['usdt_link']}}</span>
                                                <button onclick="copyToClipboard('#usdtLink_{{$withdraw['id']}}')" class="btn btn-sm btn-secondary">
                                                    <i class='bx bx-copy' ></i>
                                                </button>
                                            </td>
                                            <td>
                                                @if($withdraw['status'] == 0)
                                                    <span class="badge bg-warning"> تحت المراجعه  </span>
                                                @elseif($withdraw['status'] == 1)
                                                    <span class="badge bg-success"> تم التحويل  </span>
                                                @elseif($withdraw['status'] == 2)
                                                    <span class="badge bg-danger"> تم رفض العملية </span>
                                                @endif </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    @if($withdraw['status'] != 1)
                                                        <button type="button" class="btn btn-soft-danger btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete_withdraw_{{$withdraw['id']}}">
                                                            <iconify-icon icon="solar:trash-bin-minimalistic-2-broken"
                                                                          class="align-middle fs-18"></iconify-icon>
                                                        </button>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        @include('front.WithDraws.delete')
                                        @include('front.WithDraws.update')
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->
                            <script>
                                function copyToClipboard(element) {
                                    var temp = document.createElement("textarea");
                                    temp.value = document.querySelector(element).textContent;
                                    document.body.appendChild(temp);
                                    temp.select();
                                    document.execCommand("copy");
                                    document.body.removeChild(temp);
                                    alert("تم نسخ الرابط بنجاح!");
                                }
                            </script>
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
                "searching": false, // إلغاء البحث
                "ordering": false,  // إلغاء الترتيب
                "lengthChange": false,
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
