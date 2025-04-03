@extends('front.layouts.master_dashboard')
@section('title')
    خططي
@endsection
@section('css')
    {{--    <!-- DataTables CSS --> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection
@section('content')

    @php
        $allprofit = 0;
        $total_profit = 0;
    @endphp
    @if ($userCurrencyPlans->count() > 0)
        @foreach ($userCurrencyPlans as $currencyplan)
            @php
                ############ Get All WithDraw In this Plan
                $TotalDrawForPlan = App\Models\front\WithDrawCurrencyPlan::where(
                    'currency_plan',
                    $currencyplan->CurrencyPlan['id'],
                )
                    ->where('user_id', Auth::id())
                    ->sum('amount');
                $total_profit_for_plan =
                    $currencyplan['currency_number'] * $currencyplan->CurrencyPlan['currency_current_price'] -
                    ($currencyplan['total_investment'] + $TotalDrawForPlan);
                $total_profit += $total_profit_for_plan;
            @endphp
            @php
                $allprofitforplan =
                    $currencyplan['currency_number'] * $currencyplan->CurrencyPlan['currency_current_price'] -
                    $currencyplan['total_investment'];
                $allprofit += $allprofitforplan;
            @endphp
        @endforeach
    @endif

    <!-- ==================================================== -->
    <div class="page-content user_plans user_plans_details">
        <!-- Start Container Fluid -->
        <div class="container-xxl">
            <div class="row">
                <div class="col-xl-12">
                    <div class="user_plans_page_info my_new_container" style="background-color: #191f31">
                        <div class="info">
                            <h5> اجمالي الاسثمارات الكلية </h5>
                            @php
                                $total = $userCurrencyTotalInvestment + $totalbalance;

                                if ($total > 0) {
                                    $percentage = ($allprofit / $total) * 100;
                                } else {
                                    $percentage = 0; // تجنب القسمة على صفر
                                }
                            @endphp
                            <h4 class="total_investment"> {{ number_format($total, 2) }} دولار </h4>
                            <div class="investment_percentages">
                                <p class="percentage"> +{{ number_format($percentage, 3) }} %
                                    {{-- ({{ $daily_earning_percentage * 100 }}%)  --}}

                                    {{-- <span>

                                        <i class="bi bi-arrow-up-short"></i>
                                    </span> --}}
                                </p>
                            </div>
                            <div class="buttons">
                                <a href="#" class="public_button" data-bs-toggle="modal"
                                    data-bs-target="#main_add_balance"> إيداع </a>
                                <a href="#" class="stat"> الاحصائيات </a>
                            </div>
                            @include('front.layouts.add_balance')
                        </div>

                        <div class="info">
                            <h5> الارباح الكلية </h5>
                            @php
                                $total_profit_investment = $allprofit + $investment_earning;
                            @endphp
                            <h4 class="profit_balance" style="margin-bottom: 0px">
                                {{ number_format($total_profit, 2) }} دولار </h4>
                            <span
                                style="color: #999999;display: block;margin-top: 10px;margin-bottom: 10px;font-size: 18px;">
                                ( {{ number_format($allprofit, 2) }} دولار )</span>
                            <button style="border: none;" class="stat" data-bs-toggle="modal"
                                data-bs-target="#main_withdraw_balance"> سحب </button>
                            <a href="#" class="stat WithDrawTransactions" data-plan-id="WithDrawTransactions"> السجل
                            </a>
                            @include('front.Plans.withdraw')

                        </div>
                        <div class="info">
                            <h5> الرقم التعريفي : {{ Auth::user()->id }} </h5>
                            @if (empty(Auth::user()->image))
                                <img src="{{ asset('assets/front/uploads/user2.png') }}" alt="">
                            @else
                                <img src="{{ asset('assets/uploads/users/' . Auth::user()->image) }}">
                            @endif
                        </div>
                    </div>
                    @include('front.Plans.WithdrawTransactions')
                    <hr>
                    @if ($Plans->count() > 0)
                        @foreach ($Plans as $plan_details)
                            <div class="user_plans_page_info my_new_container">
                                <div class="info">
                                    <h5> خطة الاستثمار في : {{ $plan_details['plan']['name'] }} </h5>
                                    <h4 class="total_investment"> {{ number_format($plan_details['total_investment'], 2) }}
                                        دولار
                                    </h4>
                                    <div class="buttons">
                                        <a href="#" class="public_button" data-bs-toggle="modal"
                                            data-bs-target="#edit_balance_{{ $plan_details['plan']['id'] }}"> تعديل الرصيد
                                        </a>
                                        <a href="#" class="stat toggle-transactions"
                                            data-plan-id="{{ $plan_details['plan']['id'] }}"> المعاملات </a>
                                    </div>
                                </div>
                                @include('front.Plans.edit_balance')
                                <div class="info">
                                    <h5 class="select_h5">
                                        <select name="" class="form-select" placeholder=" الربح"
                                            id="statsDropdown-{{ $plan_details->id }}"
                                            onchange="updateStats({{ $plan_details->id }})">
                                            <option value="360" selected> الربح [ الكلي ] </option>
                                            <option value="24"> الربح [ 24 ساعة ] </option>
                                            <option value="7"> الربح [ 7 ايام ] </option>
                                            <option value="30"> الربح [ 30 يوم ] </option>
                                        </select>
                                    </h5>

                                    <!-- الربح الكلي -->
                                    <h4 class="profit_balance stats" id="stats-360-{{ $plan_details->id }}">
                                        {{ number_format($plan_details->plan_profit, 2) }} دولار
                                    </h4>

                                    <!-- الربح لآخر 24 ساعة -->
                                    <h4 class="profit_balance stats" id="stats-24-{{ $plan_details->id }}"
                                        style="display:none;">
                                        @if ($plan_details->plan_last_dayearning != 0)
                                            <span
                                                style="color: {{ $plan_details->plan_last_dayearning > 0 ? '#10AE59' : '#FF0000' }}">
                                                {{ $plan_details->plan_last_dayearning > 0 ? '+' : '' }}
                                                {{ number_format($plan_details->plan_last_dayearning, 2) }}
                                                ({{ $plan_details->plan_last_daypercentage * 100 }} %)
                                                <i
                                                    class="bi {{ $plan_details->plan_last_dayearning > 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                            </span>
                                        @else
                                            <span style="color: #999999"> % 0.00 </span>
                                        @endif
                                    </h4>

                                    <!-- الربح لآخر 7 أيام -->
                                    <h4 class="profit_balance stats" id="stats-7-{{ $plan_details->id }}"
                                        style="display:none;">
                                        @if ($plan_details->last_7_days_earning != 0)
                                            <span
                                                style="color: {{ $plan_details->last_7_days_earning > 0 ? '#10AE59' : '#FF0000' }}">
                                                {{ $plan_details->last_7_days_earning > 0 ? '+' : '' }}
                                                {{ number_format($plan_details->last_7_days_earning, 2) }}
                                                ({{ $plan_details->last_7_days_percentage * 100 }} %)
                                                <i
                                                    class="bi {{ $plan_details->last_7_days_earning > 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                            </span>
                                        @else
                                            <span style="color: #999999"> % 0.00 </span>
                                        @endif
                                    </h4>

                                    <!-- الربح لآخر 30 يوم -->
                                    <h4 class="profit_balance stats" id="stats-30-{{ $plan_details->id }}"
                                        style="display:none;">
                                        @if ($plan_details->last_30_days_earning != 0)
                                            <span
                                                style="color: {{ $plan_details->last_30_days_earning > 0 ? '#10AE59' : '#FF0000' }}">
                                                {{ $plan_details->last_30_days_earning > 0 ? '+' : '' }}
                                                {{ number_format($plan_details->last_30_days_earning, 2) }}
                                                ({{ $plan_details->last_30_days_percentage * 100 }} %)
                                                <i
                                                    class="bi {{ $plan_details->last_30_days_earning > 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                            </span>
                                        @else
                                            <span style="color: #999999"> % 0.00 </span>
                                        @endif
                                    </h4>
                                    <!------------- Under Revision Untill Sales Order Compeled ------------->
                                    @if ($plan_details['TotalBalanceRevision'] > 0)
                                        <h4 class="under_revision"> تحت المراجعة :: <strong> -
                                                {{ number_format($plan_details['TotalBalanceRevision'], 2) }} دولار
                                            </strong>
                                        </h4>
                                    @endif

                                    <!------------- Under Revision Untill Sales Order Compeled ------------->
                                </div>
                                <div class="info">
                                    <h5> {{ $plan_details['plan']['name'] }} </h5>
                                    <a href="{{ $plan_details['plan']['platform_link'] }}">
                                        <img src="{{ asset('assets/uploads/plans/' . $plan_details['plan']['logo']) }}">
                                    </a>
                                </div>
                            </div>

                            <!-- #################################### Start Plan Transaction Details ############################# -->
                            @include('front.Plans.user_plan_statments')
                            <!-- #################################### End Plan Transaction Details ############################# -->
                        @endforeach
                    @else
                        {{-- <div class="alert alert-warning">
                        لا يوجد خطط متاحة
                    </div> --}}
                    @endif
                    <hr>

                    @if ($userCurrencyPlans->count() > 0)
                        {{-- <h4 style="color: #fff;font-size:16px"> خطط الاستثمار في العملات الرقمية </h4> --}}

                        @foreach ($userCurrencyPlans as $currencyplan)
                            <div class="user_plans_page_info my_new_container">
                                <div class="info">
                                    <h5> خطة الاستثمار في : {{ $currencyplan->CurrencyPlan['name'] }} </h5>
                                    <h4 class="total_investment"> {{ number_format($currencyplan['total_investment'], 2) }}
                                        دولار
                                    </h4>
                                    <div class="buttons">
                                        <a href="#" class="public_button" data-bs-toggle="modal"
                                            data-bs-target="#edit_currency_balance_{{ $currencyplan['id'] }}"> تعديل الرصيد
                                        </a>
                                        {{-- <a href="#" class="stat toggle-transactions-currency"
                                            data-plan-id="{{ $currencyplan->CurrencyPlan['id'] }}"> المعاملات </a> --}}
                                    </div>
                                </div>
                                @include('front.Plans._edit_currency_balance')
                                <div class="info">
                                    <h5 class="select_h5">
                                        الربح الكلي
                                    </h5>
                                    <!-- الربح الكلي -->
                                    <h4 class="profit_balance stats">
                                        @php
                                            ############ Get All WithDraw In this Plan
                                            $TotalDraw = App\Models\front\WithDrawCurrencyPlan::where(
                                                'currency_plan',
                                                $currencyplan->CurrencyPlan['id'],
                                            )
                                                ->where('user_id', Auth::id())
                                                ->sum('amount');
                                            $total_profit =
                                                $currencyplan['currency_number'] *
                                                    $currencyplan->CurrencyPlan['currency_current_price'] -
                                                ($currencyplan['total_investment'] + $TotalDraw);
                                            $allprofit =
                                                $currencyplan['currency_number'] *
                                                    $currencyplan->CurrencyPlan['currency_current_price'] -
                                                $currencyplan['total_investment'];
                                        @endphp
                                        {{ number_format($total_profit, 2) }} دولار
                                        <span style="color: #999999;display: block;margin-top: 10px;">
                                            ({{ number_format($allprofit, 2) }} دولار)
                                        </span>
                                    </h4>
                                    <div class="info d-flex">
                                        <form action="{{ route('withdraw_currency_profit') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="currency_plan_id"
                                                value="{{ $currencyplan->CurrencyPlan['id'] }}">
                                            <button style="border: none;" class="stat" type="submit"> سحب ونقل الارباح
                                            </button>
                                        </form>

                                        {{-- <a href="#" class="stat WithDrawTransactions"
                                            data-plan-id="WithDrawTransactions"> سجل
                                            السحوبات </a>
                                        @include('front.Plans.withdraw') --}}

                                    </div>
                                    <!------------- Under Revision Untill Sales Order Compeled ------------->
                                </div>
                                <div class="info">
                                    <h5> {{ $currencyplan->CurrencyPlan['name'] }} </h5>
                                    <a href="{{ $currencyplan->CurrencyPlan['url'] }}">
                                        <img
                                            src="{{ asset('assets/uploads/currency/' . $currencyplan->CurrencyPlan['logo']) }}">
                                    </a>
                                </div>
                            </div>

                            <!-- #################################### Start Plan Transaction Details ############################# -->
                            {{-- @include('front.Plans._user_curreny_plan_statments') --}}
                            <!-- #################################### End Plan Transaction Details ############################# -->
                        @endforeach
                    @endif

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            // إضافة حدث لجميع الأزرار
                            document.querySelectorAll('.toggle-transactions').forEach(button => {
                                button.addEventListener('click', (e) => {
                                    e.preventDefault(); // منع التحديث
                                    const planId = button.getAttribute('data-plan-id'); // الحصول على ID الخطة
                                    const container = document.getElementById(
                                        `transactions-${planId}`); // البحث عن القسم الخاص بالخطة
                                    if (container.style.display === 'none' || !container.style.display) {
                                        container.style.display = 'block'; // إظهار المعاملات
                                    } else {
                                        container.style.display = 'none'; // إخفاء المعاملات
                                    }
                                });
                            });
                        });
                    </script>
                    <!-- Show Hide Currency Plan Transactions  -->
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            // إضافة حدث لجميع الأزرار
                            document.querySelectorAll('.toggle-transactions-currency').forEach(button => {
                                button.addEventListener('click', (e) => {
                                    e.preventDefault(); // منع التحديث
                                    const planId = button.getAttribute('data-plan-id'); // الحصول على ID الخطة
                                    const container = document.getElementById(
                                        `transactions-${planId}`); // البحث عن القسم الخاص بالخطة
                                    if (container.style.display === 'none' || !container.style.display) {
                                        container.style.display = 'block'; // إظهار المعاملات
                                    } else {
                                        container.style.display = 'none'; // إخفاء المعاملات
                                    }
                                });
                            });
                        });
                    </script>
                    <!-- Show Hide Currency Plan Transactions  -->
                    <!--################------ Show hide 24 / 7 / 30 Days ###################  !-->
                    <script>
                        function updateStats(planId) {
                            const selectedPeriod = document.getElementById(`statsDropdown-${planId}`).value;

                            // إخفاء جميع الإحصائيات الخاصة بهذه الخطة
                            document.querySelectorAll(`#stats-360-${planId}, #stats-24-${planId}, #stats-7-${planId}, #stats-30-${planId}`)
                                .forEach(stat => {
                                    stat.style.display = 'none';
                                });

                            // إظهار الإحصائية المناسبة بناءً على الفترة المحددة
                            document.getElementById(`stats-${selectedPeriod}-${planId}`).style.display = 'block';
                        }

                        // عند تحميل الصفحة، تأكد من أن الربح الكلي يظهر بشكل افتراضي لكل خطة
                        document.addEventListener('DOMContentLoaded', function() {
                            @foreach ($Plans as $plan_details)
                                updateStats({{ $plan_details->id }}); // لتحديث الإحصائيات المعروضة عند تحميل الصفحة
                            @endforeach
                        });
                    </script>
                    <!-- ################------ Show WithDrawTransactions ###################  !-->
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            // إضافة حدث لجميع الأزرار
                            document.querySelectorAll('.WithDrawTransactions').forEach(button => {
                                button.addEventListener('click', (e) => {
                                    e.preventDefault(); // منع التحديث
                                    const planId = button.getAttribute('data-plan-id'); // الحصول على ID الخطة
                                    const container = document.getElementById(
                                        `WithDrawTransactions`); // البحث عن القسم الخاص بالخطة
                                    if (container.style.display === 'none' || !container.style.display) {
                                        container.style.display = 'block'; // إظهار المعاملات
                                    } else {
                                        container.style.display = 'none'; // إخفاء المعاملات
                                    }
                                });
                            });
                        });
                    </script>
                    <!-- ################------ Show WithDrawTransactions ###################  !-->
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
