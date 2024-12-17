@extends('front.layouts.master')
@section('title')
    تسجيل الدخول
@endsection
@section('content')
    <div class="d-flex flex-column h-100 p-3"
        style="background-image: url({{ asset('assets/uploads/background.jpg') }});background-size: cover;background-position: center;background-repeat: no-repeat;">
        <div class="d-flex flex-column flex-grow-1">
            <div class="row h-100">

                <div class="col-xxl-7">
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
                    <div class="row justify-content-center h-100">
                        <div class="col-lg-6 py-lg-5">
                            <div class="d-flex flex-column h-100 justify-content-center login_form">

                                <h2 class="fw-bold fs-24"> تسجيل دخول </h2>

                                <p class=" mt-1 mb-4"> من فضلك ادخل البريد الالكتروني وكلمة المرور للدخول الي حسابك </p>

                                <div class="mb-5">
                                    <form method="post" action="{{ route('user_login') }}" class="authentication-form">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label" for="example-email"> البريد الالكتروني </label>
                                            <input type="email" id="example-email" name="email" class="form-control bg-"
                                                placeholder=" البريد الالكتروني  " value="{{ old('email') }}">
                                        </div>
                                        <div class="mb-3">
                                            <a href="{{ url('user/forget-password') }}"
                                                class="float-end text-muted text-unline-dashed ms-1"> نسيت كلمة المرور ؟؟
                                            </a>
                                            <label class="form-label" for="example-password">كلمة المرور</label>
                                            <input name="password" type="password" id="example-password"
                                                class="form-control" placeholder="كلمة المرور">
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="remeber" class="form-check-input" id="checkbox-signin">
                                                <label class="form-check-label" for="checkbox-signin"> تذكرني </label>
                                            </div>
                                        </div>

                                        <div class="mb-1 text-center d-grid">
                                            <button class="btn btn-soft-primary" type="submit"> تسجيل دخول </button>
                                        </div>
                                    </form>
                                    <p class="text-center"> ليس لديك حساب ؟ <a href="{{ route('user_register') }}"
                                            class="fw-bold ms-1"> حساب جديد </a></p>
                                    <div class="social_login">
                                        <a href="{{route('auth.google.redirect','google')}}" class="google">
                                            <i class="bi bi-google"></i>
                                        </a>
                                        <a href="{{route('auth.google.redirect','facebook')}}" class="facebook">
                                            <i class="bi bi-facebook"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-5 d-none d-xxl-flex">
                    <div class="card h-100 mb-0 overflow-hidden"
                        style="padding:0; border: none;border-radius: 0;box-shadow: none">
                        <div class="d-flex flex-column h-100">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
