@extends('front.layouts.master_dashboard')
@section('title')
    واجهة تغير العملة
@endsection
@section('css')

    {{--    <!-- DataTables CSS -->--}}
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
                <div class="exchange_header">
                    <h4> 148.00 <span> USD </span></h4>
                    <h4> 30.00 <span> BIN </span></h4>
                    <h4 class="exchange"> استبدال <i class="bi bi-arrow-left-right"></i></h4>
                </div>
                <div class="open_exchange">
                    <button class="open_button">
                        فتح صفقة
                    </button>
                    <h4> {{$market_price}} <span> +1 % </span></h4>
                    <button class="save_exchange">
                        تخرين العملة
                    </button>
                </div>
                <div class="col-xl-12">
                    <div>
                        <div class="table-responsive my_new_container">
                            <div class="main_data">
                                <div class="right_data">
                                    <form action="{{url('user/sales/create')}}" method="post">
                                        @csrf
                                        <div class="section">
                                            <p>سعر الدخول</p>
                                            <div class="buttons" style="margin-bottom: 10px;">
                                                {{--                                            <button onclick="decrement('entryPrice')">-</button>--}}
                                                <span class="value" id="entryPrice"> {{$market_price}} </span>
                                                {{--                                            <button onclick="increment('entryPrice')">+</button>--}}
                                            </div>

                                        </div>

                                        <div class="section">
                                            <p>سعر البيع</p>
                                            <div class="buttons" style="margin-bottom: 10px;">
                                                <button onclick="decrement('sellPrice',event)">-</button>
                                                <span class="value" id="sellPrice">{{$minimum_selling_price}}</span>
                                                <button onclick="increment('sellPrice',event)">+</button>

                                                <input type="hidden" name="selling_currency_rate" id="sellPriceInput" value="{{$market_price}}">
                                            </div>
{{--                                            <input type="range" id="entryPrice" class="slider" min="0" max="100" step="0.1" oninput="updateValue('sellPrice', this.value)" value="10.5">--}}
                                        </div>

                                        <div class="section">
                                            <p>مبلغ الصفقة</p>
                                            <div class="buttons" style="margin-bottom: 10px;">
                                                <button onclick="decrement('dealAmount', event)">-</button>
                                                <span class="value" id="dealAmount">100</span>
                                                <button onclick="increment('dealAmount', event)">+</button>
                                            </div>
{{--                                            <input type="range" id="amountSlider" class="slider" min="0" max="1000" step="10"--}}
{{--                                                   oninput="updateValue('dealAmount', this.value)" value="150">--}}
                                            <input type="hidden" name="currency_amount" id="dealAmountInput" value="100">
                                        </div>
                                        <div class="section">
                                            <h6> هل تريد شراء <span> 500  </span> مقابل <span> 150 </span> دولار </h6>
                                        </div>
                                        <button class="submit-btn" type="submit">دخول الصفقة</button>
                                    </form>
                                </div>
                                <div class="left_data">
                                    <button> معلومات الصفقة</button>
                                    <div class="data_info">
                                        <h4> سعر الدخول </h4>
                                        <span> 10.5 $ </span>
                                    </div>
                                    <div class="data_info">
                                        <h4> سعر البيع </h4>
                                        <span> 11.5 $ </span>
                                    </div>
                                    <div class="data_info">
                                        <h4> مبلغ الصفقة </h4>
                                        <span> 115.00 $ </span>
                                    </div>
                                    <div class="data_info">
                                        <h4> الربح المتوقع </h4>
                                        <span class="profit" id="profit">+4.00 $</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- end table-responsive -->
                    </div>
                    <div>

                        <div class="table-responsive my_new_container expert_report">

                            <div class="plans_total_report plan_report_section">
                                <div class="plans">
                                    <h5> سجل التداول </h5>
                                    <div class="plans_details">
                                        <div class="plan1">
                                            <h4 style="background: #10AE59"> ربح </h4>
                                            <h4> مبلغ الصفقة </h4>
                                            <h4> سعر </h4>
                                        </div>
                                        <div class="plan1">
                                            <h4> الدخول </h4>
                                            <h4> 20 $ </h4>
                                            <h4> 20 $ </h4>
                                        </div>
                                        <div class="plan1">
                                            <h4> البيع </h4>
                                            <h4> 20 $ </h4>
                                            <h4> 20 $ </h4>
                                        </div>
                                        <div class="plan1">
                                            <h4> الربح </h4>
                                            <h4 style="color:#10AE59"> 20 $ </h4>
                                            <h4> 20 $ </h4>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- end table-responsive -->
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
        function increment(id, event) {
            event.preventDefault();
            let element = document.getElementById(id);
            let value = parseFloat(element.innerText);
            value += (id === 'dealAmount') ? 10 : 0.1;
            element.innerText = value.toFixed(2);
            updateHiddenInput(id, value);
            calculateProfit();
        }

        function decrement(id, event) {
            event.preventDefault();
            let element = document.getElementById(id);
            let value = parseFloat(element.innerText);
            value -= (id === 'dealAmount') ? 10 : 0.1;
            if (value < 0) value = 0;
            element.innerText = value.toFixed(2);
            updateHiddenInput(id, value);
            calculateProfit();
        }

        function updateValue(id, value) {
            document.getElementById(id).innerText = parseFloat(value).toFixed(2);
            updateHiddenInput(id, value);
            calculateProfit();
        }

        function updateHiddenInput(id, value) {
            // تحديث قيمة المدخل المخفي بناءً على ID العنصر
            if (id === 'sellPrice') {
                document.getElementById('sellPriceInput').value = parseFloat(value).toFixed(2);
            } else if (id === 'dealAmount') {
                document.getElementById('dealAmountInput').value = parseFloat(value).toFixed(2);
            }
        }
        function calculateProfit() {
            let entryPrice = parseFloat(document.getElementById('entryPrice')?.innerText || 0);
            let sellPrice = parseFloat(document.getElementById('sellPrice').innerText);
            let dealAmount = parseFloat(document.getElementById('dealAmount').innerText);
            let profit = (sellPrice - entryPrice) * (dealAmount / entryPrice);
            document.getElementById('profit').innerText = `+${profit.toFixed(2)} $`;
        }
    </script>
@endsection
