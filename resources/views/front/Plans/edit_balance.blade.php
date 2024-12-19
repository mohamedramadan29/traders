<div class="modal fade edit_balance_tab" id="edit_balance_{{ $plan_details['plan']['id'] }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color:#2a3040">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> تعديل رصيد الاستثمار في الخطة  </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab-{{ $plan_details['plan']['id'] }}" role="tablist">
                    <button class="nav-link active" id="add_balance_tab_{{ $plan_details['plan']['id'] }}"
                        data-bs-toggle="tab" data-bs-target="#add_balance_{{ $plan_details['plan']['id'] }}"
                        type="button" role="tab" aria-controls="add_balance_{{ $plan_details['plan']['id'] }}"
                        aria-selected="true">
                        اضافة رصيد
                    </button>
                    <button class="nav-link" id="withdraw_balance_tab_{{ $plan_details['plan']['id'] }}"
                        data-bs-toggle="tab" data-bs-target="#withdraw_balance_{{ $plan_details['plan']['id'] }}"
                        type="button" role="tab" aria-controls="withdraw_balance_{{ $plan_details['plan']['id'] }}"
                        aria-selected="false">
                        سحب رصيد
                    </button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent-{{ $plan_details['plan']['id'] }}">
                <div class="tab-pane fade show active" id="add_balance_{{ $plan_details['plan']['id'] }}"
                    role="tabpanel" aria-labelledby="add_balance_tab_{{ $plan_details['plan']['id'] }}" tabindex="0">
                    <form action="{{ url('user/invoice_create') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="exchange_third_section">
                                <div class="form-group">
                                    <div class="input_data">
                                        <input  style="width: 90%" type="number" name="total_price" step="0.01"
                                            placeholder="الحد الادني 0.01">
                                        <input type="hidden" name="plan_id" value="{{ $plan_details['plan']['id'] }}">
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
                <div class="tab-pane fade" id="withdraw_balance_{{ $plan_details['plan']['id'] }}" role="tabpanel"
                    aria-labelledby="withdraw_balance_tab_{{ $plan_details['plan']['id'] }}" tabindex="0">
                    <form action="{{ url('user/invoice_withdraw') }}" method="post" class="withdraw_form">
                        @csrf
                        <div class="modal-body">
                            <div class="exchange_third_section">
                                <div class="form-group">
                                    <div class="input_data">
                                        <input  style="width: 90%" type="number" name="total_price" step="0.01"
                                            placeholder="">
                                        <input type="hidden" name="plan_id" value="{{ $plan_details['plan']['id'] }}">
                                        <span>دولار </span>
                                    </div>
                                    <p> مجموع الاستثمارت المتاح في الخطة <span style="color:#11af59"> {{ number_format($plan_details['total_investment'], 2) }} دولار  </span>  </p>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> رجوع</button>
                            <button type="submit" class="btn"
                                style="background-color:#11af59;color:#fff;">حفظ</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
