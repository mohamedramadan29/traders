@extends('admin.layouts.master')
@section('title')
     منصات التداول المتاحة
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
                            <h4 class="card-title flex-grow-1">  منصات التداول المتاحة   </h4>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#add_attribute">
                               اضف جديد
                                <i class="ti ti-plus"></i>
                            </button>
                            @include('admin.Platforms.add')
                        </div>


                        <div>
                            <div class="table-responsive">
                                <table id="table-search"
                                       class="table table-bordered gridjs-table align-middle mb-0 table-hover table-centered">
                                    <thead class="bg-light-subtle">
                                    <tr>
                                        <th style="width: 20px;">
                                        </th>
                                        <th>  الاسم   </th>
                                        <th> اللوجو  </th>
                                        <th> راس المال الحالي  </th>
                                        <th> عدد الاشتراكات الكلي   </th>
                                        <th> عدد الاشتراكات الفعال   </th>
                                        <th> العمليات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach($platforms as $platform)
                                        @php
                                        $total_invoice_sum = \App\Models\front\Invoice::where('platform_id',$platform['id'])->where('status',1)->sum('plan_price');
                                        @endphp
                                        <tr>
                                            <td>
                                                {{$i++}}
                                            </td>
                                            <td>{{$platform['name']}}</td>

                                            <td><img width="80px" height="80px" src="{{Storage::url('uploads/platforms/'.$platform['logo'])}}" alt="">  </td>
                                            <td>{{$total_invoice_sum}} $ </td>
                                            <td> @php echo  count(\App\Models\front\Invoice::where('platform_id',$platform['id'])->get()) @endphp </td>
                                            <td> @php echo  count(\App\Models\front\Invoice::where('status',1)->where('platform_id',$platform['id'])->get()) @endphp </td>

                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-soft-danger btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#edit_withdraw_{{$platform['id']}}">
                                                        <iconify-icon icon="solar:pen-2-broken"
                                                                      class="align-middle fs-18"></iconify-icon>
                                                    </button>

                                                        <button type="button" class="btn btn-soft-danger btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete_withdraw_{{$platform['id']}}">
                                                            <iconify-icon icon="solar:trash-bin-minimalistic-2-broken"
                                                                          class="align-middle fs-18"></iconify-icon>
                                                        </button>
                                                    <a href="{{url('admin/investments/'.$platform['id'])}}" class="btn btn-soft-success"> عوائد الاستثمار   </a>

                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        @include('admin.Platforms.update')
                                        @include('admin.Platforms.delete')
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
