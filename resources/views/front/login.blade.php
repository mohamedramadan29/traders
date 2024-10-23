@extends('front.layouts.login_master')
@section('title') تسجيل الدخول  @endsection
@section('content')
    <div class="d-flex flex-column h-100 p-3" style="background-image: url({{asset('assets/front/uploads/trading_background2.jpg')}});background-size: cover;background-position: center;background-repeat: no-repeat;">
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
                            <div class="d-flex flex-column h-100 justify-content-center">
                                <div class="auth-logo mb-4">
{{--                                    <a href="" class="logo-dark">--}}
{{--                                        <img style="width: 70px;height: 70px" src="{{asset('assets/admin/images/logo-letter.svg')}}" height="24" alt="logo dark">--}}
{{--                                        <h4 style="margin-top: 10px"> مركز وكالات كيوتيكس </h4>--}}
{{--                                    </a>--}}
                                    <a href="" class="logo-light">
                                        <img style="70px;height: 70px" src="{{asset('assets/admin/images/logo-letter.svg')}}" height="24" alt="logo light">
                                        <h4 style="margin-top: 10px"> مركز وكالات كيوتيكس </h4>
                                    </a>
                                </div>

                                <h2 class="fw-bold fs-24"> تسجيل دخول  </h2>

                                <p class="text-muted mt-1 mb-4"> من فضلك ادخل البريد الالكتروني وكلمة المرور للدخول الي حسابك  </p>

                                <div class="mb-5">
                                    <form method="post" action="{{route('user_login')}}"
                                          class="authentication-form">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label" for="example-email"> البريد الالكتروني  </label>
                                            <input type="email" id="example-email" name="email"
                                                   class="form-control bg-" placeholder=" البريد الالكتروني  " value="{{old('email')}}">
                                        </div>
                                        <div class="mb-3">
                                            <a href="{{url('user/forget-password')}}"
                                               class="float-end text-muted text-unline-dashed ms-1"> نسيت كلمة المرور    ؟؟ </a>
                                            <label class="form-label" for="example-password">كلمة المرور</label>
                                            <input name="password" type="password" id="example-password" class="form-control"
                                                   placeholder="كلمة المرور">
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                                <label class="form-check-label" for="checkbox-signin"> تذكرني  </label>
                                            </div>
                                        </div>

                                        <div class="mb-1 text-center d-grid">
                                            <button style="background-color:#9F002A; color:#fff" class="btn btn-soft-primary" type="submit"> تسجيل دخول  </button>
                                        </div>
                                    </form>

                                    {{--                                    <p class="mt-3 fw-semibold no-span">OR sign with</p>--}}

                                    {{--                                    <div class="d-grid gap-2">--}}
                                    {{--                                        <a href="javascript:void(0);" class="btn btn-soft-dark"><i class="bx bxl-google fs-20 me-1"></i> Sign in with Google</a>--}}
                                    {{--                                        <a href="javascript:void(0);" class="btn btn-soft-primary"><i class="bx bxl-facebook fs-20 me-1"></i> Sign in with Facebook</a>--}}
                                    {{--                                    </div>--}}
                                    <p class="text-danger text-center"> ليس لديك حساب ؟   <a href="{{route('user_register')}}" class="text-dark fw-bold ms-1"> حساب جديد  </a></p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-5 d-none d-xxl-flex">
                    <div class="card h-100 mb-0 overflow-hidden" style="padding:0; border: none;border-radius: 0;box-shadow: none">
                        <div class="d-flex flex-column h-100">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
