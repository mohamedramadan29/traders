@extends('front.layouts.master')
@section('title')
    نسيت كلمة المرور
@endsection
@section('content')
    <div class="d-flex flex-column h-100 p-3" style="background: linear-gradient(275deg, #26126b, #272674)">
        <div class="d-flex flex-column flex-grow-1">
            <div class="row h-100">
                <div class="col-xxl-12">
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
                        <div class="col-lg-12 py-lg-5">
                            <div class="d-flex flex-column h-100 justify-content-center login_form">
                                <h2 class="fw-bold fs-24"> اعادة تعين كلمة المرور </h2>
                                <p class="text-muted mt-1 mb-4"> من فضلك ادخل البريد الالكتروني الخاص بك لارسال كود التأكيد
                                </p>
                                <div class="mb-5">
                                    <form method="post" action="{{ url('user/forget-password') }}"
                                        class="authentication-form" id="registrationForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label" for="example-email"> البريد الالكتروني </label>
                                            <input type="email" id="example-email" name="email" class="form-control bg-"
                                                placeholder=" البريد الالكتروني  ">
                                        </div>

                                        <div class="mb-1 text-center d-grid">
                                            <button class="btn btn-soft-primary" type="submit" id="submitButton"> ارسال
                                            </button>
                                        </div>
                                        <p class="mt-5 text-center"> الرجوع الي <a href="{{ route('user_login') }}"
                                                class="fw-bold ms-1"> تسجيل
                                                الدخول </a></p>
                                    </form>

                                    <script>
                                        document.getElementById('registrationForm').addEventListener('submit', function() {
                                            var submitbutton = document.getElementById('submitButton');
                                            submitbutton.disabled = true;
                                            submitbutton.innerHTML = ' جاري الارسال ...'
                                        });
                                    </script>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
