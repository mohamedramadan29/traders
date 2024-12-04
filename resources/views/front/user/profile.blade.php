@extends('front.layouts.master_dashboard')
@section('title')
    حسابي
@endsection
@section('css')
    {{--    <!-- DataTables CSS --> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection
@section('content')
    <!-- ==================================================== -->
    <div class="page-content user_plans user_plans_details">
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
                @if (Session::has('Error_Message'))
                    @php
                        toastify()->error(\Illuminate\Support\Facades\Session::get('Error_Message'));
                    @endphp
                @endif
                <div class="col-xl-12">
                    {{-- <div class="card info_card ">
                        <h4 class="card-title flex-grow-1"> خططي </h4>
                    </div> --}}
                    <div class="profile_page">
                        <div class="profile_main_section">
                            <div class="logo_section">
                                <form id="updateProfileImageForm" action="{{ url('user/update_profile_image') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @if (empty(Auth::user()->image))
                                        <img id="userImage" src="{{ asset('assets/front/uploads/user2.png') }}">
                                    @else
                                        <img id="userImage" src="{{ asset('assets/uploads/users/' . Auth::user()->image) }}"
                                            alt="">
                                    @endif
                                    <label for="profileImageInput" style="cursor: pointer;">
                                        <i class="bi bi-pencil-square"></i>
                                    </label>
                                    <input type="file" id="profileImageInput" accept="image/*" name="image"
                                        style="display: none;">
                                </form>

                            </div>


                            <div class="email">
                                <p> {{ Auth::user()->email }} </p>
                            </div>
                        </div>
                        <hr>
                        <div class="profile_tabs">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab"
                                        aria-controls="pills-home" aria-selected="true"> الصفحة الرئيسية </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile" type="button" role="tab"
                                        aria-controls="pills-profile" aria-selected="false"> تعديل البيانات </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact" type="button" role="tab"
                                        aria-controls="pills-contact" aria-selected="false"> اعدادات الامان </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab" tabindex="0">
                                    <form>
                                        <div class="mb-3">
                                            <label class="form-label" for="example-email"> حالة الحساب
                                            </label>
                                            <input readonly disabled type="email" id="example-email"
                                                class="form-control bg-" placeholder="  حالة الحساب   "
                                                value="{{ Auth::user()->name }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="example-email"> الاسم
                                            </label>
                                            <input readonly disabled type="email" id="example-email"
                                                class="form-control bg-" placeholder="  الاسم  "
                                                value="{{ Auth::user()->name }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="example-email"> البريد الالكتروني
                                            </label>
                                            <input readonly disabled type="email" id="example-email" class="form-control"
                                                placeholder=" البريد الالكتروني  " value="{{ Auth::user()->email }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="example-email"> الدولة
                                            </label>
                                            <input readonly disabled type="email" id="example-email" class="form-control"
                                                placeholder=" ---  " value="{{ Auth::user()->country }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="example-email"> المدينة
                                            </label>
                                            <input readonly disabled type="email" id="example-email"
                                                class="form-control" placeholder=" --- "
                                                value="{{ Auth::user()->city }}">
                                        </div>

                                    </form>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                    aria-labelledby="pills-profile-tab" tabindex="0">
                                    <form method="POST" action="{{ url('user/update_user_details') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label" for="account_status"> حالة الحساب
                                            </label>
                                            <input type="text" name="account_status" id="account_status"
                                                class="form-control" placeholder="  حالة الحساب   "
                                                value="{{ Auth::user()->name }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="example-name"> الاسم
                                            </label>
                                            <input type="text" name="name" id="example-name" class="form-control"
                                                placeholder="  الاسم  " value="{{ Auth::user()->name }}">
                                        </div>
                                        {{-- <div class="mb-3">
                                            <label class="form-label" for="example-email"> البريد الالكتروني
                                            </label>
                                            <input readonly disabled type="email" required name="email" id="example-email"
                                                class="form-control" placeholder=" البريد الالكتروني  "
                                                value="{{ Auth::user()->email }}">
                                        </div> --}}
                                        <div class="mb-3">
                                            <label class="form-label" for="country"> الدولة
                                            </label>
                                            <input type="text" required name="country" id="country"
                                                class="form-control" placeholder=" الدولة   "
                                                value="{{ Auth::user()->country }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="city"> المدينة
                                            </label>
                                            <input type="text" name="city" required id="city"
                                                class="form-control" placeholder=" المدينة  "
                                                value="{{ Auth::user()->city }}">
                                        </div>

                                        <div class="mb-3">
                                            <button type="submit" class="btn"> تعديل البيانات <i
                                                    class="bi bi-pencil-square"></i> </button>
                                        </div>

                                    </form>
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                    aria-labelledby="pills-contact-tab" tabindex="0">

                                    <form method="POST" action="{{ url('user/update_user_password') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label" for="example-email"> البريد الالكتروني
                                            </label>
                                            <input readonly disabled type="email" required name="email"
                                                id="example-email" class="form-control"
                                                placeholder=" البريد الالكتروني  " value="{{ Auth::user()->email }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="old_password"> كلمة المرور الحالية
                                            </label>
                                            <input type="password" required name="old_password" id="old_password"
                                                class="form-control" placeholder=" كلمة المرور الحالية  ">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="new_password"> كلمة المرور الجديدة
                                            </label>
                                            <input type="password" name="new_password" required id="new_password"
                                                class="form-control" placeholder=" كلمة المرور الجدبدة">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="confirm_password"> تاكيد كلمة المرور
                                            </label>
                                            <input type="password" name="confirm_password" required id="confirm_password"
                                                class="form-control" placeholder=" تاكيد كلمة المرور  ">
                                        </div>

                                        <div class="mb-3">
                                            <button type="submit" class="btn"> تعديل البيانات <i
                                                    class="bi bi-pencil-square"></i> </button>
                                        </div>

                                    </form>

                                </div>
                            </div>
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
<script>
    document.getElementById('profileImageInput').addEventListener('change', function() {
        const form = document.getElementById('updateProfileImageForm');
        const formData = new FormData(form);
        fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // تحديث صورة المستخدم
                    document.getElementById('userImage').src = data.imageUrl;
                   // alert('تم تحديث الصورة بنجاح!');
                } else {
                    alert('حدث خطأ أثناء التحديث.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('تعذر تحديث الصورة.');
            });
    });
</script>
@endsection
