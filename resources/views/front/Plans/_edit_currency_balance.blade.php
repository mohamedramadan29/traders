<div class="modal fade edit_balance_tab" id="edit_currency_balance_{{ $currencyplan['id'] }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color:#2a3040">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> تعديل رصيد الاستثمار في الخطة </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab-{{ $currencyplan['id'] }}" role="tablist">
                    <button class="nav-link active" id="add_balance_tab_{{ $currencyplan['id'] }}" data-bs-toggle="tab"
                        data-bs-target="#add_balance_{{ $currencyplan['id'] }}" type="button" role="tab"
                        aria-controls="add_balance_{{ $currencyplan['id'] }}" aria-selected="true">
                        اضافة رصيد
                    </button>
                    <button class="nav-link" id="withdraw_balance_tab_{{ $currencyplan['id'] }}" data-bs-toggle="tab"
                        data-bs-target="#withdraw_balance_{{ $currencyplan['id'] }}" type="button" role="tab"
                        aria-controls="withdraw_balance_{{ $currencyplan['id'] }}" aria-selected="false">
                        سحب رصيد
                    </button>

                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent-{{ $currencyplan['id'] }}">
                <div class="tab-pane fade show active" id="add_balance_{{ $currencyplan['id'] }}" role="tabpanel"
                    aria-labelledby="add_balance_tab_{{ $currencyplan['id'] }}" tabindex="0">
                    <form action="{{ route('currency_investment') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="exchange_third_section">
                                <div class="form-group">
                                    <div class="input_data">
                                        <input style="width: 90%" type="number" min="0.01" name="currency_price"
                                            step="0.01" placeholder="الحد الادني 0.01">
                                        <input type="hidden" name="currency_plan_id"
                                            value="{{ $currencyplan->CurrencyPlan['id'] }}">
                                        <span>دولار </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn" style="background-color:#11af59;color:#fff;"> تاكيد
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> رجوع</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="withdraw_balance_{{ $currencyplan['id'] }}" role="tabpanel"
                    aria-labelledby="withdraw_balance_tab_{{ $currencyplan['id'] }}" tabindex="0">
                    <form action="{{ route('currency_withdraw') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <p> مجموع الاستثمارت المتاح في الخطة <span style="color:#11af59">{{ number_format($currencyplan['total_investment'], 2) }} دولار </span></p>
                            <p> المبلغ المتاح للسحب <span style="color:#11af59">{{ number_format($allprofit / 2 - $TotalEditBalanceWithdraw, 2) }}دولار </span></p>

                            <div class="exchange_third_section">
                                <div class="form-group">
                                    <div class="input_data">
                                        <input style="width: 90%" type="number" max="{{ number_format($allprofit / 2 - $TotalEditBalanceWithdraw, 2) }}" name="amount"
                                            step="0.01" placeholder="الحد الادني 0.01">
                                        <input type="hidden" name="currency_plan_id"
                                            value="{{ $currencyplan->CurrencyPlan['id'] }}">
                                        <span>دولار </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn" style="background-color:#11af59;color:#fff;"> تاكيد
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> رجوع</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
