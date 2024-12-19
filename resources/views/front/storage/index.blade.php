@extends('front.layouts.master_dashboard')
@section('title')
    تخزين العملة
@endsection
@section('css')
    {{--    <!-- DataTables CSS --> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection
@section('content')
    <!-- ==================================================== -->
    <div class="page-content exchange_page">
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
        <!-- Start Container Fluid -->
        <div class="container-xxl">

            <div class="row">
                <div class="save_exchange_data">
                    <!-- Modal structure  -->
                    <div class="platform_data" id="save_exchange_click">

                        <div class="modal-body text-center">
                            {{-- <div class="exchange_first_section">
                                        empty div
                                    </div> --}}
                            <form method="post" action="{{ url('user/storage/add') }}" onsubmit="prepareFormData(event)">
                                @csrf

                                <div class="exchange_second_section">
                                    <div class="option" data-value="30" data-rate="1" onclick="selectOption(this)">
                                        <span class="days">30 d</span> <span>1%</span>
                                    </div>
                                    <div class="option" data-value="60" data-rate="2.5" onclick="selectOption(this)">
                                        <span class="days">60 d</span> <span>2.5%</span>
                                    </div>
                                    <div class="option" data-value="90" data-rate="4.5" onclick="selectOption(this)">
                                        <span class="days">90 d</span> <span>4.5%</span>
                                    </div>
                                    <div class="option" data-value="180" data-rate="9" onclick="selectOption(this)">
                                        <span class="days">180 d</span> <span>9%</span>
                                    </div>
                                    <div class="option selected" data-value="360" data-rate="12"
                                        onclick="selectOption(this)">
                                        <span class="days">360 d</span> <span>12%</span>
                                    </div>
                                    <!-- Hidden inputs -->
                                    <input type="radio" name="duration" value="30" data-rate="1"
                                        class="hidden-radio">
                                    <input type="radio" name="duration" value="60" data-rate="2.5"
                                        class="hidden-radio">
                                    <input type="radio" name="duration" value="90" data-rate="4.5"
                                        class="hidden-radio">
                                    <input type="radio" name="duration" value="180" data-rate="9"
                                        class="hidden-radio">
                                    <input type="radio" name="duration" value="360" data-rate="12" class="hidden-radio"
                                        checked>
                                </div>
                                <style>

                                </style>

                                <div class="exchange_third_section">
                                    <div class="form-group">
                                        <label> المبلغ </label>
                                        <div class="input_data">
                                            <input type="number" name="amount" id="amount" step="0.01"
                                                placeholder="الحد الادني 5000 bin" oninput="updateSummary()">
                                            <span>BIN</span>
                                            <button type="button" onclick="setMax()"> الحد الاقصي</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="exchange_fifth_section">
                                    <h6> الملخص </h6>
                                    <div class="summary">
                                        <div>
                                            <h4> مبلغ الاستثمار </h4>
                                            <span id="investmentAmount">5000 BIN</span>
                                        </div>
                                        <div>
                                            <h4> المكافئات المالية المقدرة </h4>
                                            <span id="expectedRewards" style="color: #11af59"> +2.5 BIN </span>
                                        </div>
                                        <div>
                                            <h4> العائد السنوي </h4>
                                            <span id="annualReturn" style="color: #11af59">12 %</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- الحقول المخفية -->
                                <input type="hidden" name="start_date" id="start_date">
                                <input type="hidden" name="end_date" id="end_date">
                                <input type="hidden" name="interest_rate" id="interest_rate">
                                <div class="exchange_six_section">
                                    <p> تاريخ البدء : <span id="display_start_date">{{ date('d/m/Y') }}</span></p>
                                    <p> تاريخ الانتهاء : <span id="display_end_date"></span></p>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck1">
                                        <label class="form-check-label" for="defaultCheck1">
                                            لقد قرأت ووافقت على <a href="#">اتفاقية خدمة Binviste Staking</a>
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-success"> تأكيد </button>
                                </div>
                            </form>

                            <script>
                                function updateSummary(selectedOption = null) {
                                    const amount = parseFloat(document.getElementById('amount').value) || 5000; // المبلغ الافتراضي
                                    const startDate = new Date();
                                    const duration = selectedOption ? parseInt(selectedOption.value) : 360; // الافتراضي 360 يوم
                                    const rate = selectedOption ? parseFloat(selectedOption.dataset.rate) : 12; // الافتراضي 12%

                                    // حساب تاريخ النهاية
                                    const endDate = new Date();
                                    endDate.setDate(startDate.getDate() + duration);

                                    // تحديث الحقول الظاهرة
                                    document.getElementById('investmentAmount').textContent = `${amount} BIN`;
                                    document.getElementById('expectedRewards').textContent = `+${(amount * rate / 100).toFixed(2)} BIN`;
                                    document.getElementById('annualReturn').textContent = `${rate} %`;
                                    document.getElementById('display_start_date').textContent = startDate.toLocaleDateString('en-GB');
                                    document.getElementById('display_end_date').textContent = endDate.toLocaleDateString('en-GB');

                                    // تحديث الحقول المخفية
                                    document.getElementById('start_date').value = startDate.toISOString().split('T')[0]; // yyyy-mm-dd
                                    document.getElementById('end_date').value = endDate.toISOString().split('T')[0];
                                    document.getElementById('interest_rate').value = rate;
                                }

                                function setMax() {
                                    const maxAmount = 500000; // الحد الأقصى
                                    document.getElementById('amount').value = maxAmount;
                                    updateSummary();
                                }

                                // التحديث الأولي عند تحميل الصفحة
                                updateSummary();
                            </script>
                            <script>
                                function selectOption(element) {
                                    // إزالة الفئة "selected" من جميع الخيارات
                                    document.querySelectorAll('.exchange_second_section .option').forEach(option => {
                                        option.classList.remove('selected');
                                    });

                                    // إضافة الفئة "selected" إلى العنصر الحالي
                                    element.classList.add('selected');

                                    // تحديد الـ input المرتبط بالقيمة
                                    const value = element.getAttribute('data-value');
                                    document.querySelector(`input[name="duration"][value="${value}"]`).checked = true;

                                    // استدعاء الدالة المخصصة لتحديث البيانات
                                    updateSummary(element);
                                }
                            </script>
                        </div>
                    </div>
                </div>

                <div class="table-responsive my_new_container">
                    <div class="open_trader">
                        <h6>  الاستثمارت الحالية  </h6>
                        <h3> BIN / USD </h3>
                        @foreach ($storages as $storage)
                            <div class="open_trader_details">
                                <div class="details">
                                    <div class="first_details">
                                        <p> مبلغ الاستثمار  (دولار) </p>
                                        <span class="sp_span"> {{ number_format($storage['amount_invested'], 2) }} </span>
                                    </div>
                                    <div class="first_details">
                                        <p> فترة التخزين  (يوم ) </p>
                                        <span> {{ $storage['interest_date'] }} يوم </span>
                                    </div>
                                </div>
                                <div class="details">
                                    <div class="first_details">
                                        <p> النسبة    </p>
                                        <span> {{ $storage['interest_rate'] }} % </span>
                                    </div>
                                    <div class="first_details">
                                        <p> تاريخ البداية  </p>
                                        <span> {{ $storage['start_date'] }} </span>
                                    </div>
                                </div>
                                <div class="details">
                                    <div class="first_details">
                                        <p> تاريخ الانتهاء </p>

                                        <span> {{ $storage['end_date'] }}
                                        </span>
                                    </div>
                                    <div class="first_details">
                                        <p> --- </p>
                                        <span>  </span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        @endforeach
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
