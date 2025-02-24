@extends('admin.layouts.master')
@section('title')
    خطط العملات - تعديل الخطة
@endsection
@section('css')
@endsection
@section('content')
    <!-- ==================================================== -->
    <div class="page-content">

        <!-- Start Container Fluid -->
        <div class="container-xxl">
            <form method="post" action="{{ url('admin/currency_plan/update/'.$plan['id']) }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-xl-12 col-lg-12 ">
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
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> خطط العملات - تعديل الخطة </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label"> الاسم </label>
                                            <input required type="text" id="name" class="form-control"
                                                name="name" value="{{ $plan['name'] ?? old('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label"> اللوجو </label>
                                            <input type="file" id="logo" class="form-control"
                                                name="logo">
                                                <img width="60px" height="60px" src="{{ asset('assets/uploads/currency/'.$plan['logo']) }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="url" class="form-label"> رابط المنصة </label>
                                            <input required type="url" id="url" class="form-control"
                                                name="url" value="{{  $plan->url ?? old('url') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="curreny_number" class="form-label"> عدد العملات </label>
                                            <input required type="number" step="0.01" id="curreny_number"
                                                class="form-control" name="curreny_number"
                                                value="{{ $plan->curreny_number ?? old('curreny_number') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="main_investment" class="form-label"> مبلغ الاستثمار </label>
                                            <input required type="number" id="main_investment" class="form-control"
                                                name="main_investment" value="{{ $plan->main_investment ?? old('main_investment') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">

                                        <div class="mb-3">
                                            <label for="currency_main_price" class="form-label"> سعر العملة </label>
                                            <input required type="number" id="currency_main_price" class="form-control"
                                                name="currency_main_price" value="{{ $plan->currency_main_price ?? old('currency_main_price') }}">
                                        </div>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="mb-3">
                                            <label for="currency_main_price" class="form-label"> حالة الخطة </label>
                                            <select name="status" id="" class="form-select">
                                                <option value="1" {{ $plan->status == 1 ? 'selected' : '' }}>مفعلة</option>
                                                <option value="0" {{ $plan->status == 0 ? 'selected' : '' }}>غير مفعلة</option>
                                            </select>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="p-3 bg-light mb-3 rounded">
                            <div class="row justify-content-end g-2">
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-outline-secondary w-100"> حفظ <i
                                            class='bx bxs-save'></i> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- End Container Fluid -->


        <!-- ==================================================== -->
        <!-- End Page Content -->
        <!-- ==================================================== -->
    @endsection
