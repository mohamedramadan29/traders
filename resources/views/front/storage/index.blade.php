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
        <!-- Start Container Fluid -->
        <div class="container-xxl">
            <div class="row">
                <div class="save_exchange_data">
                    <!-- Modal structure  -->
                    <div class="platform_data" id="save_exchange_click">

                        <div class="modal-body text-center" style="padding: 1px">
                            {{-- <div class="exchange_first_section">
                                        empty div
                                    </div> --}}
                            <form method="post" action="{{ url('user/storage/add') }}" onsubmit="prepareFormData(event)">
                                @csrf
                                <div class="exchange_second_section">
                                    <div class="option" data-value="30" data-min-rate="1" data-max-rate="5"
                                        onclick="selectOption(this)">
                                        <span class="days">30 d</span> <span>(1 - 5)%</span>
                                    </div>
                                    <div class="option" data-value="60" data-min-rate="2.5" data-max-rate="12"
                                        onclick="selectOption(this)">
                                        <span class="days">60 d</span> <span>(2.5 - 12)%</span>
                                    </div>
                                    <div class="option" data-value="90" data-min-rate="4.5" data-max-rate="22"
                                        onclick="selectOption(this)">
                                        <span class="days">90 d</span> <span>(4.5 - 22)%</span>
                                    </div>
                                    <div class="option" data-value="180" data-min-rate="10" data-max-rate="50"
                                        onclick="selectOption(this)">
                                        <span class="days">180 d</span> <span>(10 - 50)%</span>
                                    </div>
                                    <div class="option selected" data-value="360" data-min-rate="25" data-max-rate="125"
                                        onclick="selectOption(this)">
                                        <span class="days">360 d</span> <span>(25 - 125)%</span>
                                    </div>
                                    <!-- Hidden inputs -->
                                    <input type="radio" name="duration" value="30" data-min-rate="1" data-max-rate="5"
                                        class="hidden-radio">
                                    <input type="radio" name="duration" value="60" data-min-rate="2.5"
                                        data-max-rate="12" class="hidden-radio">
                                    <input type="radio" name="duration" value="90" data-min-rate="4.5"
                                        data-max-rate="22" class="hidden-radio">
                                    <input type="radio" name="duration" value="180" data-min-rate="10"
                                        data-max-rate="50" class="hidden-radio">
                                    <input type="radio" name="duration" value="360" data-min-rate="25"
                                        data-max-rate="125" class="hidden-radio" checked>
                                </div>
                                <div class="exchange_third_section">
                                    <div class="form-group">
                                        <label> المبلغ </label>
                                        <div class="input_data">
                                            <input type="number" name="amount" id="amount" step="0.01"
                                                max="5000" min="1" placeholder="الحد الادني 5000 دولار"
                                                oninput="updateSummary()">
                                            <span>دولار </span>
                                            <button type="button" onclick="setMax()"> الحد الاقصي</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="exchange_fifth_section">
                                    <h6> الملخص </h6>
                                    <div class="summary">
                                        <div>
                                            <h4> مبلغ الاستثمار </h4>
                                            <span id="investmentAmount">5000 دولار</span>
                                        </div>
                                        <div>
                                            <h4> المكافئات المالية المقدرة </h4>
                                            <span id="expectedRewards" style="color: #11af59"> +2.5 دولار - +12.5 دولار
                                            </span>
                                        </div>
                                        <div>
                                            <h4> العائد السنوي </h4>
                                            <span id="annualReturn" style="color: #11af59">1% - 5%</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- الحقول المخفية -->
                                <input type="hidden" name="start_date" id="start_date" value="{{ date('Y-m-d') }}">
                                <input type="hidden" name="end_date" id="end_date">
                                <input type="hidden" name="interest_rate" id="interest_rate">
                                <div class="exchange_six_section">
                                    <p> تاريخ البدء : <span id="display_start_date">{{ date('d/m/Y') }}</span></p>
                                    <p> تاريخ الانتهاء : <span id="display_end_date"></span></p>
                                    <div class="form-check custom-checkbox">
                                        <input required class="form-check-input" type="checkbox" id="defaultCheck1">
                                        <label class="form-check-label" for="defaultCheck1">
                                            لقد قرأت ووافقت على <a target="_blank" href="{{ url('terms') }}">اتفاقية خدمة
                                                Binviste Staking</a>
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-success"> تأكيد </button>
                                </div>
                            </form>

                            <script>
                                function updateSummary(selectedOption = null) {
                                    const amount = parseFloat(document.getElementById('amount').value) || 5000; // المبلغ الافتراضي
                                    const duration = selectedOption ? parseInt(selectedOption.getAttribute('data-value')) :
                                        360; // الافتراضي 360 يوم
                                    const minRate = selectedOption ? parseFloat(selectedOption.getAttribute('data-min-rate')) : 25; // الافتراضي 25%
                                    const maxRate = selectedOption ? parseFloat(selectedOption.getAttribute('data-max-rate')) :
                                        125; // الافتراضي 125%

                                    // حساب أدنى وأقصى قيمة للمكافآت المالية
                                    const minRewards = (amount * minRate / 100).toFixed(2);
                                    const maxRewards = (amount * maxRate / 100).toFixed(2);

                                    // تحديث الحقول الظاهرة
                                    document.getElementById('investmentAmount').textContent = `${amount} دولار`;
                                    document.getElementById('expectedRewards').textContent = `+${minRewards} دولار - +${maxRewards} دولار`;
                                    document.getElementById('annualReturn').textContent = `${minRate}% - ${maxRate}%`;

                                    // تحديث الحقول المخفية
                                    document.getElementById('interest_rate').value =
                                        maxRate; // يمكنك استخدام النسبة القصوى أو المتوسطة حسب احتياجاتك
                                }

                                function calculateEndDate(duration) {
                                    const startDate = new Date();
                                    const endDate = new Date(startDate); // إنشاء نسخة من startDate
                                    endDate.setDate(startDate.getDate() + duration);

                                    // التحقق من صحة التاريخ
                                    if (isNaN(endDate.getTime())) {
                                        console.error("تاريخ النهاية غير صالح!");
                                        return null;
                                    }

                                    return endDate;
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

                                    // حساب تاريخ النهاية
                                    const duration = parseInt(element.getAttribute('data-value'));
                                    const endDate = calculateEndDate(duration);

                                    if (endDate) {
                                        // تحديث تاريخ الانتهاء في الواجهة
                                        document.getElementById('display_end_date').textContent = endDate.toLocaleDateString('en-GB');

                                        // تحديث الحقل المخفي لتاريخ الانتهاء
                                        document.getElementById('end_date').value = endDate.toISOString().split('T')[0];
                                    }

                                    // تحديث الملخص
                                    updateSummary(element);
                                }
                            </script>
                        </div>
                    </div>
                </div>
                @if (count($storages) > 0)
                    <div class="table-responsive my_new_container save_exchange_data">
                        <div class="open_trader">
                            <h6> الاستثمارت الحالية </h6>
                            <h3> BIN / USD </h3>
                            @foreach ($storages as $key => $storage)
                                <div class="open_trader_details">
                                    <div class="details">
                                        <div class="first_details">
                                            <p> مبلغ الاستثمار (دولار) </p>
                                        </div>
                                        <div class="first_details">
                                            <p> عائد الاستثمار / الربح </p>
                                        </div>
                                        <div class="first_details">
                                            <p> وقت وتاريخ الانتهاء </p>
                                        </div>
                                    </div>
                                    <div class="details">
                                        <div class="first_details">
                                            <span class="sp_span"> {{ number_format($storage['amount_invested'], 2) }}
                                                <small style="color: #aaa5a5"> ( {{ $storage['interest_date'] }} يوم )
                                                </small>
                                            </span>
                                        </div>
                                        <div class="first_details">
                                            @php
                                                $totalReturn = $storage->DailyInvestments->sum('amount_return');
                                                $totalProfit = $storage->DailyInvestments->sum('profit_percentage');
                                            @endphp
                                            <span class="sp_span"> {{ $totalReturn }} $ <small style="color: #aaa5a5"> (
                                                    {{ $totalProfit * 100 }} % ) </small>
                                            </span>
                                        </div>
                                        <div>
                                            <span style="font-size: 12px; color: #aaa5a5;"
                                                id="countdown-timer-{{ $key }}"
                                                data-end-date="{{ $storage['end_date'] }}">
                                            </span>
                                        </div>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const countdownElement = document.getElementById('countdown-timer-{{ $key }}');
                                                const endDate = countdownElement.getAttribute('data-end-date');
                                                const targetDate = new Date(endDate).getTime();

                                                function updateCountdown() {
                                                    const now = new Date().getTime();
                                                    const timeDifference = targetDate - now;

                                                    if (timeDifference <= 0) {
                                                        countdownElement.textContent = "انتهى الوقت";
                                                        clearInterval(interval);
                                                        return;
                                                    }

                                                    const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                                                    const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                    const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                                                    const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

                                                    countdownElement.textContent = `${days} ي / ${hours} س / ${minutes} د / ${seconds} ث`;
                                                }

                                                // تحديث العداد كل ثانية
                                                const interval = setInterval(updateCountdown, 1000);
                                                updateCountdown(); // تشغيله مرة عند التحميل
                                            });
                                        </script>
                                    </div>
                                    <br>
                                    <div class="details">
                                        <div class="first_details">
                                            <p> معدل الربح اليومي </p>
                                        </div>
                                        <div class="first_details">
                                            <p> من {{ $storage['start_date'] }} </p>
                                        </div>
                                        <div class="first_details">
                                            <p> الي {{ $storage['end_date'] }} </p>
                                        </div>
                                    </div>
                                    <div class="details">
                                        <div class="first_details">
                                            @php
                                                $lastInvestment = $storage
                                                    ->DailyInvestments()
                                                    ->latest('created_at')
                                                    ->first();
                                            @endphp
                                           <span class="sp_span">
                                            {{ number_format(data_get($lastInvestment, 'amount_return', 0), 5) }} $
                                        </span>
                                        </div>
                                        <div class="first_details">
                                            <span
                                                style="color: #aaa5a5;text-align: center;font-size: 12px;margin-left:-90%">
                                                المكافئات التالية
                                                <br>
                                                <small id="daily-timer-{{ $key }}"></small>
                                            </span>
                                        </div>
                                        <!--#################### Storage To CountDownTimer ##########################-->
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const timerElement = document.getElementById('daily-timer-{{ $key }}');

                                                function updateDailyCountdown() {
                                                    const now = new Date();
                                                    const tomorrow = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1, 0, 0,
                                                        0); // الساعة 12:00 منتصف الليل
                                                    const timeDifference = tomorrow - now;

                                                    if (timeDifference <= 0) {
                                                        timerElement.textContent = "انتهى الوقت!";
                                                        return;
                                                    }

                                                    const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                    const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                                                    const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

                                                    timerElement.textContent = `${hours} س / ${minutes} د / ${seconds} ث`;
                                                }
                                                // تحديث العد التنازلي كل ثانية
                                                setInterval(updateDailyCountdown, 1000);
                                                updateDailyCountdown(); // التحديث عند تحميل الصفحة مباشرةً
                                            });
                                        </script>
                                        <div class="first_details">
                                            <button href="#multiCollapseExample_{{ $storage['id'] }}"
                                                class="btn btn-sm storage_button_details toggle-transactions"
                                                data-bs-toggle="collapse" role="button" aria-expanded="false"
                                                aria-controls="multiCollapseExample1"> المعاملات <i class="bi bi-eye"></i>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                                @include('front.storage.storage_daily_investment')
                                <hr>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        document.querySelectorAll('.toggle-transactions').forEach(button => {
                                            button.addEventListener('click', function() {
                                                const storageId = this.getAttribute('data-storage-id'); // احصل على ID التخزين
                                                const transactionsContainer = document.getElementById(
                                                    `transactions-${storageId}`);
                                                // تحقق من وجود العنصر
                                                if (transactionsContainer) {
                                                    // تبديل العرض
                                                    if (transactionsContainer.style.display === 'none' || transactionsContainer
                                                        .style.display === '') {
                                                        transactionsContainer.style.display = 'block';
                                                    } else {
                                                        transactionsContainer.style.display = 'none';
                                                    }
                                                } else {
                                                    console.error(`Container with ID transactions-${storageId} not found.`);
                                                }
                                            });
                                        });
                                    });
                                </script>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

        </div>
        <!-- End Container Fluid -->

    </div>
    <!-- ==================================================== -->
    <!-- End Page Content -->
    <!-- ==================================================== -->
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
