@extends('admin.layouts.login_master')
@section('content')
    <div class="d-flex flex-column h-100 p-3">
        <div class="d-flex flex-column flex-grow-1">
            <div class="row h-100">

                <div class="col-xxl-12">
                    @if (\Illuminate\Support\Facades\Session::has('Error_Message'))
                        <div class="alert alert-danger"> {{ \Illuminate\Support\Facades\Session::get('Error_Message') }}
                        </div>
                    @endif
                    <div class="row justify-content-center h-100 login_form">
                        <div class="col-lg-12 py-lg-5">
                            <div class="d-flex flex-column h-100 justify-content-center">
                                <div class="auth-logo mb-4">
                                    <a href="{{ url('login') }}" class="logo-dark">
                                        <img src="{{ asset('assets/admin/images/logo-letter.svg') }}" height="24"
                                            alt="logo dark">
                                    </a>

                                    <a href="{{ url('login') }}" class="logo-light">
                                        <img src="{{ asset('assets/admin/images/logo-letter.svg') }}" height="24"
                                            alt="logo light"> لوجو الموقع
                                    </a>
                                </div>

                                <h2 class="fw-bold fs-24"> تسجيل دخول الادمن </h2>

                                <p class="text-muted mt-1 mb-4"> من فضلك ادخل البريد الالكتروني وكلمة المرور للدخول الي
                                    حسابك </p>

                                <div class="mb-5">
                                    <form method="post" action="{{ route('admin_login') }}" class="authentication-form">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label" for="example-email"> البريد الالكتروني </label>
                                            <input type="email" id="example-email" name="email" class="form-control bg-"
                                                placeholder=" البريد الالكتروني  ">
                                        </div>
                                        <div class="mb-3">
                                            {{--                                            <a href="{{url('admin/forget-password')}}" --}}
                                            {{--                                               class="float-end text-muted text-unline-dashed ms-1"> نسيت كلمة المرور    ؟؟ </a> --}}
                                            <label class="form-label" for="example-password">كلمة المرور</label>
                                            <input name="password" type="password" id="example-password"
                                                class="form-control" placeholder="كلمة المرور">
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                                <label class="form-check-label" for="checkbox-signin"> تذكرني </label>
                                            </div>
                                        </div>

                                        <div class="mb-1 text-center d-grid">
                                            <button class="btn btn-soft-primary" type="submit"> تسجيل دخول </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
