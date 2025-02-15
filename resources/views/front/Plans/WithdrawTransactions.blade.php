<div class="my_new_container transactions" id="WithDrawTransactions" style="display: none;">
    <div class="top_buttons nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link trans_button active" id="nav-transactions-tab" data-bs-toggle="tab"
            data-bs-target="#nav-transactions" type="button" role="tab" aria-controls="nav-transactions"
            aria-selected="true"> سجل السحب </button>

    </div>
    <div class="trans_info tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-transactions" role="tabpanel"
            aria-labelledby="nav-transactions-tab" tabindex="0">
            <ul class="list-unstyled">
                @foreach ($user_withdraw_statments as $user_withdraw_statment)
                    <li class="d-flex justify-content-between">
                        <div>
                            <span class="decrease"> - {{ $user_withdraw_statment['amount'] }} </span>
                            مبلغ السحب
                        </div>
                        <div>
                            <span>
                                {{ $user_withdraw_statment['created_at'] }}
                            </span>
                        </div>
                        <div>
                            @if ($user_withdraw_statment['status'] == 0)
                                <span class="badge bg-warning"> تحت المراجعه </span>
                            @elseif($user_withdraw_statment['status'] == 1)
                                <span class="badge bg-success"> تم التحويل </span>
                            @elseif($user_withdraw_statment['status'] == 2)
                                <span class="badge bg-danger"> تم رفض العملية </span>
                            @endif
                        </div>

                    </li>
                @endforeach

            </ul>
        </div>
    </div>
</div>
