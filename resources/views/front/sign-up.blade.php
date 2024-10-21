@extends('front.layouts.login_master')
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
    <div class="d-flex flex-column h-100 p-3">
        <div class="d-flex flex-column flex-grow-1">
            <div class="row h-100">
                <div class="col-xxl-7">
                    @if(\Illuminate\Support\Facades\Session::has('Error_Message'))
                        <div
                            class="alert alert-danger"> {{\Illuminate\Support\Facades\Session::get('Error_Message')}} </div>
                    @endif
                    <div class="row justify-content-center h-100">
                        <div class="col-lg-6 py-lg-5">
                            <div class="d-flex flex-column h-100 justify-content-center">
                                <div class="auth-logo mb-4">
                                    <a href="" class="logo-dark">
                                        <img style="width: 70px;height: 70px" src="{{asset('assets/admin/images/logo-letter.svg')}}" height="24" alt="logo dark">
                                        <h4 style="margin-top: 10px"> مركز وكالات كيوتيكس </h4>
                                    </a>

                                    <a href="" class="logo-light">
                                        <img style="70px;height: 70px" src="{{asset('assets/admin/images/logo-letter.svg')}}" height="24" alt="logo light">
                                        <h4 style="margin-top: 10px"> مركز وكالات كيوتيكس </h4>
                                    </a>
                                </div>

                                <h2 class="fw-bold fs-24"> حساب جديد </h2>

                                <p class="text-muted mt-1 mb-4"> من فضلك ادخل البريد الالكتروني وكلمة المرور لانشاء حساب
                                    جديد </p>

                                <div class="mb-5">
                                    <form method="post" action="{{route('user_register')}}"
                                          class="authentication-form" id="registrationForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label" for="name"> الاسم </label>
                                            <input required type="text" id="name" name="name"
                                                   class="form-control bg-" placeholder=" الاسم   "
                                                   value="{{old('name')}}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="example-email"> البريد الالكتروني </label>
                                            <input required type="email" id="example-email" name="email"
                                                   class="form-control bg-" placeholder=" البريد الالكتروني  "
                                                   value="{{old('email')}}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="example-password">كلمة المرور</label>
                                            <input required name="password" type="password" id="example-password"
                                                   class="form-control"
                                                   placeholder="كلمة المرور">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="example-password"> تأكيد كلمة المرور </label>
                                            <input required name="confirm-password" type="password"
                                                   id="example-password"
                                                   class="form-control"
                                                   placeholder="تأكيد كلمة المرور">
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
                                    <p class="mt-auto text-danger text-center"> لديك حساب بالفعل ! <a
                                            href="{{route('user_login')}}" class="text-dark fw-bold ms-1"> تسجيل
                                            دخول </a></p>
                                </div>
                                <script>
                                    document.getElementById('registrationForm').addEventListener('submit', function () {
                                        var submitbutton = document.getElementById('submitButton');
                                        submitbutton.disabled = true;
                                        submitbutton.innerHTML = ' جاري الارسال ...'
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-5 d-none d-xxl-flex">
                    <div class="card h-100 mb-0 overflow-hidden"
                         style="padding:0; border: none;border-radius: 0;box-shadow: none">
                        <div class="d-flex flex-column h-100">
                            <img src="{{asset('assets/admin/images/forex.jpg')}}" alt="" class="w-100 h-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
