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

        <!-- Start Container Fluid -->
        <div class="container-xxl">

            <div class="row">
                <div class="exchange_header">
                    <h4> 148.00 <span> USD </span> </h4>
                    <h4> 30.00 <span> BIN </span> </h4>
                    <h4 class="exchange"> استبدال <i class="bi bi-arrow-left-right"></i> </h4>
                </div>
                <div class="open_exchange">
                    <button class="open_button">
                        فتح صفقة
                    </button>
                    <h4> 1.00009 <span> +1 % </span> </h4>
                    <button class="save_exchange">
                        تخرين العملة
                    </button>
                </div>
                <div class="col-xl-12">
                    <div>
                        <div class="table-responsive my_new_container">
                            <div class="main_data">
                                <div class="right_data">
                                    <div class="section">
                                        <p>سعر الدخول</p>
                                        <div class="buttons">
                                            <button onclick="decrement('entryPrice')">-</button>
                                            <span class="value" id="entryPrice">10.50</span>
                                            <button onclick="increment('entryPrice')">+</button>
                                        </div>
                                        <input type="range" id="entrySlider" class="slider" min="0" max="100" step="0.1" oninput="updateValue('entryPrice', this.value)" value="10.5">
                                    </div>

                                    <div class="section">
                                        <p>سعر البيع</p>
                                        <div class="buttons">
                                            <button onclick="decrement('sellPrice')">-</button>
                                            <span class="value" id="sellPrice">11.50</span>
                                            <button onclick="increment('sellPrice')">+</button>
                                        </div>
                                        <input type="range" id="sellSlider" class="slider" min="0" max="100" step="0.1" oninput="updateValue('sellPrice', this.value)" value="11.5">
                                    </div>

                                    <div class="section">
                                        <p>مبلغ الصفقة</p>
                                        <div class="buttons">
                                            <button onclick="decrement('dealAmount')">-</button>
                                            <span class="value" id="dealAmount">150</span>
                                            <button onclick="increment('dealAmount')">+</button>
                                        </div>
                                        <input type="range" id="amountSlider" class="slider" min="0" max="1000" step="10" oninput="updateValue('dealAmount', this.value)" value="150">
                                    </div>
                                    <div class="section">
                                        <h6> هل تريد شراء <span> 500  </span> مقابل  <span> 150 </span> دولار </h6>
                                    </div>

                                    <button class="submit-btn">دخول الصفقة</button>
                                </div>
                                <div class="left_data">
                                   <button> معلومات الصفقة  </button>
                                    <div class="data_info">
                                       <h4> سعر الدخول  </h4>
                                        <span> 10.5 $ </span>
                                    </div>
                                    <div class="data_info">
                                        <h4> سعر البيع   </h4>
                                        <span> 11.5 $ </span>
                                    </div>
                                    <div class="data_info">
                                        <h4> مبلغ الصفقة  </h4>
                                        <span> 115.00 $ </span>
                                    </div>
                                    <div class="data_info">
                                        <h4> الربح المتوقع  </h4>
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
                                        <h5> سجل التداول  </h5>
                                        <div class="plans_details">
                                            <div class="plan1">
                                                <h4 style="background: #10AE59"> ربح   </h4>
                                                <h4> مبلغ الصفقة    </h4>
                                                <h4> سعر   </h4>
                                            </div>
                                            <div class="plan1">
                                                <h4> الدخول  </h4>
                                                <h4> 20 $ </h4>
                                                <h4 > 20 $ </h4>
                                            </div>
                                            <div class="plan1">
                                                <h4> البيع   </h4>
                                                <h4 > 20 $ </h4>
                                                <h4  > 20 $ </h4>
                                            </div>
                                            <div class="plan1">
                                                <h4> الربح   </h4>
                                                <h4 style="color:#10AE59"> 20 $ </h4>
                                                <h4  > 20 $ </h4>
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
        function increment(id) {
            let element = document.getElementById(id);
            let value = parseFloat(element.innerText);
            value += (id === 'dealAmount') ? 10 : 0.1;
            element.innerText = value.toFixed(2);
            calculateProfit();
        }

        function decrement(id) {
            let element = document.getElementById(id);
            let value = parseFloat(element.innerText);
            value -= (id === 'dealAmount') ? 10 : 0.1;
            if (value < 0) value = 0;
            element.innerText = value.toFixed(2);
            calculateProfit();
        }

        function updateValue(id, value) {
            document.getElementById(id).innerText = parseFloat(value).toFixed(2);
            calculateProfit();
        }

        function calculateProfit() {
            let entryPrice = parseFloat(document.getElementById('entryPrice').innerText);
            let sellPrice = parseFloat(document.getElementById('sellPrice').innerText);
            let dealAmount = parseFloat(document.getElementById('dealAmount').innerText);
            let profit = (sellPrice - entryPrice) * (dealAmount / entryPrice);
            document.getElementById('profit').innerText = `+${profit.toFixed(2)} $`;
        }
    </script>
@endsection
