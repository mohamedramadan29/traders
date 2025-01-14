@extends('front.layouts.master_dashboard')
@section('title')
    واجهة تغير العملة
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
                {{-- <div class="exchange_header">
                    <h4> 148.00 <span> USD </span></h4>
                    <h4> 30.00 <span> BIN </span></h4>
                    <h4 class="exchange"> استبدال <i class="bi bi-arrow-left-right"></i></h4>
                </div> --}}
                <div class="open_exchange">

                    <button class="open_button" data-bs-toggle="modal" data-bs-target="#open_new_deal"> فتح صفقة </button>
                    <h4> {{ number_format($market_price, 4) }} <span> دولار </span></h4>
                    {{-- <h4>  <span> +1 % ( نسبة الصعود خلال اخر ٢٤ ساعة  ) </span></h4> --}}
                    <h4> <span> {{ $market_price_percentage }} % </span></h4>
                </div>

                <div class="col-xl-12 open_exchange_model">
                    <div class="modal fade edit_balance_tab" id="open_new_deal" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"> فتح صفقة جديدة </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div>
                                    <div class="table-responsive">
                                        <div class="main_data">
                                            <div class="right_data">
                                                <form action="{{ url('user/sales/create') }}" method="post">
                                                    @csrf
                                                    <div class="section">
                                                        <p>سعر الدخول</p>
                                                        <div class="buttons" style="margin-bottom: 10px;">
                                                            <input type="number" id="entryPrice" name="entryPrice"
                                                                value="{{ $market_price }}" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="section">
                                                        <p>سعر البيع</p>
                                                        <div class="buttons" style="margin-bottom: 10px;">
                                                            <button onclick="decrement('sellPrice', event)">-</button>
                                                            <input readonly type="number"
                                                                min="{{ $minimum_selling_price }}"
                                                                name="selling_currency_rate" id="sellPrice"
                                                                value="{{ $minimum_selling_price }}" step="0.01">
                                                            <button onclick="increment('sellPrice', event)">+</button>
                                                        </div>
                                                    </div>

                                                    <div class="section">
                                                        <p>مبلغ الصفقة</p>
                                                        <div class="buttons" style="margin-bottom: 10px;">
                                                            <button onclick="decrement('dealAmount', event)">-</button>
                                                            <input type="number" step="0.01" name="deal_amount"
                                                                id="dealAmount" value="100" min="0"
                                                                onchange="updateDealAmount(this.value)">
                                                            <button onclick="increment('dealAmount', event)">+</button>
                                                        </div>
                                                    </div>

                                                    <div class="section">
                                                        {{-- <h6> هل تريد شراء <span> 500 </span> مقابل <span> 150 </span> دولار </h6> --}}
                                                    </div>
                                                    <button class="submit-btn" type="submit">دخول الصفقة</button>
                                                </form>

                                            </div>
                                            <div class="left_data">
                                                <button> معلومات الصفقة</button>
                                                <div class="data_info">
                                                    <h4> سعر الدخول </h4>
                                                    <span> {{ $market_price }} دولار </span>
                                                </div>
                                                <div class="data_info">
                                                    <h4> سعر البيع </h4>
                                                    <span id="salePriceDisplay">{{ $minimum_selling_price }} </span>
                                                </div>
                                                <div class="data_info">
                                                    <h4> مبلغ الصفقة </h4>
                                                    <span id="dealAmountDisplay"> 100 </span>
                                                </div>
                                                <div class="data_info">
                                                    <h4> الربح </h4>
                                                    <span class="profit" id="profit"> </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end table-responsive -->
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($open_deals->count() > 0)
                        <div class="table-responsive my_new_container">
                            <div class="open_trader">
                                <h6> الصفقات المفتوحة </h6>
                                <h3> BIN / USD </h3>
                                @foreach ($open_deals as $open_deal)
                                    <div class="open_trader_details">
                                        <div class="details">
                                            @php
                                                // عائد الاستثمار
                                                $return_percentage =
                                                    ($open_deal['selling_currency_rate'] -
                                                        $open_deal['enter_currency_rate']) *
                                                    100;
                                                $profit_lose =
                                                    ($return_percentage * $open_deal['currency_amount']) / 100;
                                            @endphp
                                            <div class="first_details">
                                                <p> الربح والخسارة (دولار) </p>
                                                <span class="sp_span"> {{ number_format($profit_lose, 2) }} </span>
                                            </div>
                                            <div class="first_details">
                                                <p> سعر الدخول (دولار) </p>
                                                <span> {{ $open_deal['enter_currency_rate'] }} </span>
                                            </div>
                                        </div>
                                        <div class="details">
                                            <div class="first_details">
                                                <p> الحجم (دولار) </p>
                                                <span> {{ number_format($open_deal['currency_amount'], 2) }} </span>
                                            </div>
                                            <div class="first_details">
                                                <p> سعر الحالي (دولار) </p>
                                                <span> {{ $open_deal['currency_rate'] }} </span>
                                            </div>
                                        </div>
                                        <div class="details">
                                            <div class="first_details">
                                                <p> عائد الاستثمار </p>

                                                <span class="sp_span"> {{ number_format($return_percentage, 4) }} %
                                                </span>
                                            </div>
                                            <div class="first_details">
                                                <p> سعر البيع (دولار) </p>
                                                <span> {{ $open_deal['selling_currency_rate'] }} </span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <!-------------------------------------------- سجل الصفقات --------------------------------------------->
                    @if ($closed_deals->count() > 0)
                        <div class="table-responsive my_new_container">
                            <div class="open_trader">
                                <h6 style="border-top: 1px solid #78797a;padding-top: 10px"> سجل الصفقات </h6>
                                @foreach ($closed_deals as $deal)
                                    @php
                                        // عائد الاستثمار
                                        $return_percentage =
                                            ($deal['selling_currency_rate'] - $deal['enter_currency_rate']) * 100;
                                        $profit_lose = ($return_percentage * $deal['currency_amount']) / 100;
                                    @endphp
                                    <div class="trader_archive">
                                        <div class="first_main">
                                            <h3> BIN / USD </h3>
                                            <p> ربح </p>
                                        </div>
                                        <div class="second_main">
                                            <div class="first">
                                                <div>
                                                    <p> الربح </p> <span class="sp_span"> {{ number_format($profit_lose,2) }} </span>
                                                </div>
                                                <div>
                                                    <p> الحجم </p> <span> {{ number_format($deal['currency_amount'], 2) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <p> العائد </p> <span class="sp_span"> + {{ $return_percentage  }}% </span>
                                                </div>
                                            </div>
                                            <div class="second">
                                                <div style="margin-left: 8px">
                                                    <p> سعر الدخول </p>
                                                    <span> {{ $deal['enter_currency_rate'] }} </span>
                                                </div>
                                                <div>
                                                    <p> سعر البيع (دولار) </p>
                                                    <span> {{ $deal['selling_currency_rate'] }} </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif


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
        function increment(id, event) {
            event.preventDefault();
            const inputElement = document.getElementById(id);
            const marketPrice = parseFloat(document.getElementById('entryPrice').value);

            if (!inputElement || isNaN(marketPrice)) {
                console.error(`Element with id '${id}' not found or market price is invalid.`);
                return;
            }

            let value = parseFloat(inputElement.value) || 0;
            const incrementValue = marketPrice * 0.01; // زيادة 1% من سعر السوق
            value += incrementValue;

            if (id === 'sellPrice') {
                const minimumSellingPrice = parseFloat("{{ $minimum_selling_price }}");
                value = Math.max(value, minimumSellingPrice); // التحقق من الحد الأدنى لسعر البيع
            }

            inputElement.value = value.toFixed(7);
            updateDisplay(id, value); // تحديث النصوص المعروضة
            calculateProfit(); // تحديث الربح
        }

        function decrement(id, event) {
            event.preventDefault();
            const inputElement = document.getElementById(id);
            const marketPrice = parseFloat(document.getElementById('entryPrice').value);

            if (!inputElement || isNaN(marketPrice)) {
                console.error(`Element with id '${id}' not found or market price is invalid.`);
                return;
            }

            let value = parseFloat(inputElement.value) || 0;
            const decrementValue = marketPrice * 0.01; // تقليل 1% من سعر السوق
            value -= decrementValue;

            if (id === 'sellPrice') {
                const minimumSellingPrice = parseFloat("{{ $minimum_selling_price }}");
                value = Math.max(value, minimumSellingPrice); // التحقق من الحد الأدنى لسعر البيع
            }

            value = Math.max(value, 0); // التأكد من عدم وجود قيم سالبة

            inputElement.value = value.toFixed(7);
            updateDisplay(id, value); // تحديث النصوص المعروضة
            calculateProfit(); // تحديث الربح
        }

        function updateDisplay(id, value) {
            if (id === 'sellPrice') {
                const salePriceDisplay = document.getElementById('salePriceDisplay');
                if (salePriceDisplay) {
                    salePriceDisplay.textContent = `${value.toFixed(7)} $`;
                }
            }

            if (id === 'dealAmount') {
                const dealAmountDisplay = document.getElementById('dealAmountDisplay');
                if (dealAmountDisplay) {
                    dealAmountDisplay.textContent = `${value.toFixed(7)} $`;
                }
            }
        }

        function calculateProfit() {
            const entryPrice = parseFloat(document.getElementById('entryPrice').value) || 0;
            const sellPrice = parseFloat(document.getElementById('sellPrice').value) || 0;
            const dealAmount = parseFloat(document.getElementById('dealAmount').value) || 0;

            if (entryPrice <= 0) {
                console.error("Entry price must be greater than zero.");
                return;
            }

            const profit = (sellPrice - entryPrice) * (dealAmount / entryPrice);

            // تحديث الربح في العرض
            const profitElement = document.getElementById('profit');
            if (profitElement) {
                profitElement.textContent = `${profit >= 0 ? '+' : ''}${profit.toFixed(7)} $`;
            }
        }

        function updateDealAmount(value) {
            const dealAmountInput = document.getElementById('dealAmount');
            if (!dealAmountInput) {
                console.error("Deal amount input not found.");
                return;
            }

            const dealAmount = parseFloat(value) || 0;
            if (dealAmount < 0) {
                dealAmountInput.value = 0; // منع القيم السالبة
            }

            updateDisplay('dealAmount', dealAmount); // تحديث النصوص المعروضة
            calculateProfit(); // تحديث الربح عند تعديل مبلغ الصفقة
        }
    </script>
@endsection
