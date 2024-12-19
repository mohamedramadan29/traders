<div class="my_new_container transactions" id="transactions-{{ $plan_details['plan']['id'] }}" style="display: none;">
    <div class="top_buttons nav nav-tabs" id="nav-tab-{{ $plan_details['plan']['id'] }}" role="tablist">
        <button class="nav-link trans_button active" id="nav-transactions-tab-{{ $plan_details['plan']['id'] }}"
            data-bs-toggle="tab" data-bs-target="#nav-transactions-{{ $plan_details['plan']['id'] }}" type="button"
            role="tab" aria-controls="nav-transactions-{{ $plan_details['plan']['id'] }}" aria-selected="true"> كل
            المعاملات </button>

        <button class="nav-link trans_button" id="nav-addbalance-tab-{{ $plan_details['plan']['id'] }}"
            data-bs-toggle="tab" data-bs-target="#nav-addbalance-{{ $plan_details['plan']['id'] }}" type="button"
            role="tab" aria-controls="nav-addbalance-{{ $plan_details['plan']['id'] }}" aria-selected="false">اضافة
            رصيد </button>

        <button class="nav-link trans_button" id="nav-withdrawbalance-tab-{{ $plan_details['plan']['id'] }}"
            data-bs-toggle="tab" data-bs-target="#nav-withdrawbalance-{{ $plan_details['plan']['id'] }}" type="button"
            role="tab" aria-controls="nav-withdrawbalance-{{ $plan_details['plan']['id'] }}" aria-selected="false">
            سحب رصيد </button>

        <button class="nav-link trans_button" id="nav-dayprofit-tab-{{ $plan_details['plan']['id'] }}"
            data-bs-toggle="tab" data-bs-target="#nav-dayprofit-{{ $plan_details['plan']['id'] }}" type="button"
            role="tab" aria-controls="nav-dayprofit-{{ $plan_details['plan']['id'] }}" aria-selected="false">
            الارباح اليومية </button>
    </div>
    <div class="trans_info tab-content" id="nav-tabContent-{{ $plan_details['plan']['id'] }}">
        <div class="tab-pane fade show active" id="nav-transactions-{{ $plan_details['plan']['id'] }}" role="tabpanel"
            aria-labelledby="nav-transactions-tab-{{ $plan_details['plan']['id'] }}" tabindex="0">
            <ul class="list-unstyled">
                @if (count($plan_details['plan']['PlanStaments']) > 0)
                    @foreach ($plan_details['plan']['PlanStaments'] as $statment)
                        @if ($statment['transaction_type'] == 'addbalance')
                            <li>
                                <span class="increase"> + {{ $statment['amount'] }} </span>دولار الي
                                راس المال بتاريخ <span> {{ $statment['created_at'] }}</span>
                            </li>
                        @elseif($statment['transaction_type'] == 'withdrawbalance')
                            <li>
                                <span class="decrease"> - {{ $statment['amount'] }} </span>دولار الي
                                راس المال بتاريخ <span>
                                    {{ $statment['created_at'] }}
                                </span>
                            </li>
                        @endif
                    @endforeach
                @else
                    <li>
                        لا يوجد معاملات حتي الان
                    </li>
                @endif
            </ul>
        </div>
        <div class="tab-pane fade" id="nav-addbalance-{{ $plan_details['plan']['id'] }}" role="tabpanel"
            aria-labelledby="nav-addbalance-tab-{{ $plan_details['plan']['id'] }}" tabindex="0">
            <ul class="list-unstyled">
                @foreach ($plan_details['plan']['PlanStaments'] as $statment)
                    @if ($statment['transaction_type'] == 'addbalance')
                        <li>
                            <span class="increase"> + {{ $statment['amount'] }} </span>دولار الي
                            راس المال بتاريخ <span> {{ $statment['created_at'] }}</span>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="tab-pane fade" id="nav-withdrawbalance-{{ $plan_details['plan']['id'] }}" role="tabpanel"
            aria-labelledby="nav-withdrawbalance-tab-{{ $plan_details['plan']['id'] }}" tabindex="0">
            <ul class="list-unstyled">
                @php
                    $withdrawTransactions = $plan_details['plan']['PlanStaments']->filter(function ($statment) {
                        return $statment['transaction_type'] == 'withdrawbalance';
                    });
                @endphp

                @if ($withdrawTransactions->isEmpty())
                    <li>لا توجد عمليات سحب إلى الآن</li>
                @else
                    @foreach ($withdrawTransactions as $statment)
                        <li>
                            <span class="decrease"> - {{ $statment['amount'] }} </span>دولار إلى
                            رأس المال بتاريخ <span>
                                {{ $statment['created_at'] }}
                            </span>
                        </li>
                    @endforeach
                @endif
            </ul>

        </div>
        <div class="tab-pane fade" id="nav-dayprofit-{{ $plan_details['plan']['id'] }}" role="tabpanel"
            aria-labelledby="nav-dayprofit-tab-{{ $plan_details['plan']['id'] }}" tabindex="0">
            <ul class="list-unstyled">
                @foreach ($plan_details['plan']['PlanDailyInvestMentReturn'] as $daily_return)
                    <li>
                        <span class="increase">  + {{ $daily_return['daily_return'] }} ({{ $daily_return['profit_percentage'] }} %)  </span>دولار الي
                        راس المال بتاريخ <span> {{ $daily_return['created_at'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
