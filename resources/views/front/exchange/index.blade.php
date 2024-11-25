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
                    <button class="save_exchange" >
                        <a href="{{url('user/storage')}}">  تخرين العملة </a>

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
                                                <input type="number" id="entryPrice" name="entryPrice" value="{{$market_price}}" readonly>
                                            </div>
                                        </div>

                                        <div class="section">
                                            <p>سعر البيع</p>
                                            <div class="buttons" style="margin-bottom: 10px;">
                                                <button onclick="decrement('sellPrice', event)">-</button>
                                                <input readonly type="number" min="{{$minimum_selling_price}}" name="selling_currency_rate" id="sellPrice"
                                                       value="{{$minimum_selling_price}}" step="0.01">
                                                <button onclick="increment('sellPrice', event)">+</button>
                                            </div>
                                        </div>

                                        <div class="section">
                                            <p>مبلغ الصفقة</p>
                                            <div class="buttons" style="margin-bottom: 10px;">
                                                <button onclick="decrement('dealAmount', event)">-</button>
                                                <input type="number" name="deal_amount" id="dealAmount" value="100"
                                                       step="10" min="0" onchange="updateDealAmount(this.value)">
                                                <button onclick="increment('dealAmount', event)">+</button>
                                            </div>
                                        </div>

                                        <div class="section">
                                            <h6> هل تريد شراء <span> 500 </span> مقابل <span> 150 </span> دولار </h6>
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
                    <div class="table-responsive my_new_container">
                        <div class="open_trader">
                            <h6> الصفقات المفتوحة </h6>
                            <h3> BIN / USD </h3>
                            @foreach($open_deals as $open_deal)
                                <div class="open_trader_details">
                                    <div class="details">
                                        <div class="first_details">
                                            <p> الربح والخسارة (usdt) </p>
                                            <span class="sp_span"> 15.88 </span>
                                        </div>
                                        <div class="first_details">
                                            <p> سعر الدخول (usdt) </p>
                                            <span>  {{$open_deal['enter_currency_rate']}} </span>
                                        </div>
                                    </div>
                                    <div class="details">
                                        <div class="first_details">
                                            <p> الحجم (usdt) </p>
                                            <span> 15.88 </span>
                                        </div>
                                        <div class="first_details">
                                            <p> سعر الحالي (usdt) </p>
                                            <span> {{$open_deal['currency_rate']}}  </span>
                                        </div>
                                    </div>
                                    <div class="details">
                                        <div class="first_details">
                                            <p> عائد الاستثمار </p>
                                            <span class="sp_span"> {{ number_format($open_deal['currency_amount'],2)}} </span>
                                        </div>
                                        <div class="first_details">
                                            <p> سعر البيع (usdt) </p>
                                            <span> {{$open_deal['selling_currency_rate']}} </span>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach

                            <h6 style="border-top: 1px solid #78797a;padding-top: 10px"> سجل الصفقات </h6>
                            <div class="trader_archive">
                                <div class="first_main">
                                    <h3> BIN / USD </h3>
                                    <p> ربح </p>
                                </div>
                                <div class="second_main">
                                    <div class="first">
                                        <div><p> الربح </p> <span class="sp_span"> 10  </span></div>
                                        <div><p> الحجم </p> <span> 300  </span></div>
                                        <div><p> العائد </p>  <span class="sp_span"> + 1%  </span></div>
                                    </div>
                                    <div class="second">
                                        <div style="margin-left: 8px">
                                            <p> سعر الدخول </p>
                                            <span> 1.00 </span>
                                        </div>
                                        <div>
                                            <p> سعر البيع (usdt) </p>
                                            <span> 1.00 </span>
                                        </div>
                                    </div>
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
        function increment(id, event) {
            event.preventDefault();
            let inputElement = document.getElementById(id);

            if (!inputElement) {
                console.error(`Element with id '${id}' not found.`);
                return;
            }

            let value = parseFloat(inputElement.value);
            let marketPrice = parseFloat(document.getElementById('entryPrice').value);

            // زيادة 1% من سعر السوق
            let incrementValue = marketPrice * 0.01;
            value += incrementValue;

            // التحقق من الحد الأدنى لسعر البيع
            if (id === 'sellPrice') {
                let minimumSellingPrice = parseFloat("{{$minimum_selling_price}}");
                if (value < minimumSellingPrice) {
                    value = minimumSellingPrice;
                }
            }

            inputElement.value = value.toFixed(7);
            calculateProfit(); // تحديث الربح
        }

        function decrement(id, event) {
            event.preventDefault();
            let inputElement = document.getElementById(id);

            if (!inputElement) {
                console.error(`Element with id '${id}' not found.`);
                return;
            }

            let value = parseFloat(inputElement.value);
            let marketPrice = parseFloat(document.getElementById('entryPrice').value);

            // تقليل 1% من سعر السوق
            let decrementValue = marketPrice * 0.01;
            value -= decrementValue;

            // التحقق من الحد الأدنى لسعر البيع
            if (id === 'sellPrice') {
                let minimumSellingPrice = parseFloat("{{$minimum_selling_price}}");
                if (value < minimumSellingPrice) {
                    value = minimumSellingPrice;
                }
            }

            // التأكد من عدم وجود قيم سالبة
            if (value < 0) value = 0;

            inputElement.value = value.toFixed(7);
            calculateProfit(); // تحديث الربح
        }

        function calculateProfit() {
            let entryPrice = parseFloat(document.getElementById('entryPrice').value);
            let sellPrice = parseFloat(document.getElementById('sellPrice').value);
            let dealAmount = parseFloat(document.getElementById('dealAmount').value);
            let profit = (sellPrice - entryPrice) * (dealAmount / entryPrice);
            console.log(`Profit: +${profit.toFixed(2)} $`);
        }

        function updateDealAmount(value) {
            if (value < 0) {
                document.getElementById('dealAmount').value = 0;
            }
            calculateProfit(); // تحديث الربح عند تعديل مبلغ الصفقة
        }

    </script>

@endsection
