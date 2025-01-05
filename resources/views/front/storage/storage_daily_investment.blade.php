<div class="my_new_container transactions collapse multi-collapse" id="multiCollapseExample_{{ $storage['id'] }}">
    <div class="top_buttons nav nav-tabs" id="nav-tab-{{ $storage['id'] }}" role="tablist">
        <button class="nav-link trans_button active" id="nav-transactions-tab-{{ $storage['id'] }}" data-bs-toggle="tab"
            data-bs-target="#nav-transactions-{{ $storage['id'] }}" type="button" role="tab"
            aria-controls="nav-transactions-{{ $storage['id'] }}" aria-selected="true"> كل
            المعاملات </button>
    </div>
    <div class="trans_info tab-content" id="nav-tabContent-{{ $storage['id'] }}">
        <div class="tab-pane fade show active" id="nav-transactions-{{ $storage['id'] }}" role="tabpanel"
            aria-labelledby="nav-transactions-tab-{{ $storage['id'] }}" tabindex="0">
            <ul class="list-unstyled">
                @if ($storage->DailyInvestments->count() > 0)
                    @foreach ($storage->DailyInvestments as $statment)
                        <li>
                            <span class="increase"> + {{ $statment['amount_return'] }} </span> دولار إلى
                            رأس المال بتاريخ <span> {{ $statment['created_at'] }} </span>
                        </li>
                    @endforeach
                @else
                    <li>
                        لا يوجد معاملات حتى الآن
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
