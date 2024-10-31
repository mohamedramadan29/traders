@extends('admin.layouts.master')
@section('title')
    تقرير شامل عن العميل
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
                            <h4 class="card-title flex-grow-1">  تقرير شامل عن العميل  </h4>
                        </div>
                        <br>
                        <div>
                            <div class="row">
                                <div class="col-lg-3 mb-2 text-center">
                                    <h4> عدد الاشتراكات  </h4>
                                    <h2> {{$invoice_count}} </h2>
                                </div>
                                <div class="col-lg-3 mb-2 text-center">
                                    <h4> عدد الاشتراكات  الفعالة  </h4>
                                    <h2> {{$invoice_count_active}} </h2>
                                </div>
                                <div class="col-lg-3 mb-2 text-center">
                                    <h4> الربح الكلي من الاسثمار   </h4>
                                    <h2> {{$total_investment}}  $ </h2>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <br>
                                <h4>  تقرير عن الاستثمار في الخطط   </h4>
                                <br>
                                <table id="table-search"
                                       class="table table-bordered gridjs-table align-middle mb-0 table-hover table-centered">
                                    <thead class="bg-light-subtle">
                                    <tr>
                                        <th style="width: 20px;">
                                        </th>
                                        <th>  الخطة  </th>
                                        <th>  عائد الاستثمار  </th>
                                        <th>   اخر نسبة   </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach($user_investment_return_from_plan as $user_invest)
                                        <tr>
                                            <td>
                                                {{$i++}}
                                            </td>
                                            <td> {{$user_invest['plan_invest']['name']}}  </td>
                                            <td> {{$user_invest['investment_return']}} $ </td>
                                            <td> {{$user_invest['profit_percentage']}}  %  </td>
                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive">
                                <br>
                                <h4>  تقرير الربح اليومي   </h4>
                                <br>
                                <table id="table-search"
                                       class="table table-bordered gridjs-table align-middle mb-0 table-hover table-centered">
                                    <thead class="bg-light-subtle">
                                    <tr>
                                        <th style="width: 20px;">
                                        </th>
                                        <th>   التاريخ   </th>
                                        <th>  الخطة  </th>
                                        <th>  عائد الاستثمار اليومي  </th>
                                        <th>    النسبة  </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach($user_daily_invests  as $daily_invest)
                                        <tr>
                                            <td>
                                                {{$i++}}
                                            </td>
                                            <td> {{$daily_invest['created_at']}}  </td>
                                            <td> {{$daily_invest['plan']['name']}}  </td>
                                            <td> {{$daily_invest['daily_return']}}  $  </td>
                                            <td> {{$daily_invest['profit_percentage']}}  %  </td>
                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>
                            </div>


                            <div class="table-responsive">
                                <br>
                                <h4> فواتير العميل  </h4>
                                <br>
                                <table id="table-search"
                                       class="table table-bordered gridjs-table align-middle mb-0 table-hover table-centered">
                                    <thead class="bg-light-subtle">
                                    <tr>
                                        <th style="width: 20px;">
                                        </th>
                                        <th>  الخطة  </th>
                                        <th>  سعر الاشتراك  </th>
                                        <th>   تاريخ الاشتراك  </th>
                                        <th>   حالة الاشتراك   </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach($invoices as $invoice)
                                        <tr>
                                            <td>
                                                {{$i++}}
                                            </td>
                                            <td> {{$invoice['plan']['name']}}  </td>
                                            <td> {{$invoice['plan_price']}} $ </td>
                                            <td> {{$invoice['created_at']}}   </td>
                                            <td>
                                                @if($invoice['status'] == 1)

                                                    <span class="badge badge-soft-success"> فعال </span>
                                                @else
                                                    <span class="badge badge-soft-danger"> انسحاب  </span>
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


<style>

    @media (max-width: 991px){
        .my_balance .info{
            padding: 2px !important;
            margin-bottom: 10px;
        }
        .my_balance .info h5{
            font-size: 18px !important;
        }
    }
</style>
