@extends('front.layouts.master')
@section('title')
    حساب جديد
@endsection
@section('content')
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
    <div class="d-flex flex-column p-3"
        style="background:linear-gradient(275deg, #26126b, #272674);">
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
                                <h2 class="fw-bold fs-24"> حساب جديد </h2>

                                <p class="mt-1 mb-4"> من فضلك ادخل البريد الالكتروني وكلمة المرور لانشاء حساب
                                    جديد </p>

                                <div class="mb-5">
                                    <form method="post" action="{{ route('user_register') }}" class="authentication-form"
                                        id="registrationForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label" for="name"> الاسم </label>
                                            <input required type="text" id="name" name="name"
                                                class="form-control bg-" placeholder=" الاسم   "
                                                value="{{ old('name') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="example-email"> البريد الالكتروني </label>
                                            <input required type="email" id="example-email" name="email"
                                                class="form-control bg-" placeholder=" البريد الالكتروني  "
                                                value="{{ old('email') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="example-password">كلمة المرور</label>
                                            <input required name="password" type="password" id="example-password"
                                                class="form-control" placeholder="كلمة المرور">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="example-password"> تأكيد كلمة المرور </label>
                                            <input required name="confirm-password" type="password" id="example-password"
                                                class="form-control" placeholder="تأكيد كلمة المرور">
                                        </div>
                                        <div class="col-12">
                                            {!! NoCaptcha::display() !!}
                                            @if ($errors->has('g-recaptcha-response'))
                                                <span class="help-block">
                                                    <strong
                                                        class="text-danger">{{ $errors->first('g-recaptcha-response') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                                <label class="form-check-label" for="checkbox-signin"> اوافق علي الشروط
                                                    والاحكام </label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="referral_code" value="{{ request('ref') }}">

                                        <div class="mb-1 text-center d-grid">
                                            <button class="btn btn-soft-primary" type="submit" id="submitButton"> حساب
                                                جديد
                                            </button>
                                        </div>
                                    </form>
                                    <p class="mt-auto text-center"> لديك حساب بالفعل ! <a href="{{ route('user_login') }}"
                                            class="fw-bold ms-1"> تسجيل
                                            دخول </a></p>
                                    <div class="social_login">
                                        <a href="{{ route('auth.google.redirect', 'google') }}" class="google">
                                            <i class="bi bi-google"></i>
                                        </a>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('registrationForm').addEventListener('submit', function() {
                                        var submitbutton = document.getElementById('submitButton');
                                        submitbutton.disabled = true;
                                        submitbutton.innerHTML = ' جاري التسجيل  ...'
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
