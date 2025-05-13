<div class="modal fade" id="remove_balance_{{$plan['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">  ازالة رصيد من قيمة الاستثمار    </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('admin/currency_plan/remove_balance/'.$plan['id'])}}" method="post">
                @csrf

                <div class="modal-body">
                    <input type="hidden" name="plan_id" value="{{ $plan['id'] }}">
                    <label for=""> ازالة رصيد من قيمة الاستثمار   </label>
                    <input type="number" name="amount" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> رجوع</button>
                    <button type="submit" class="btn btn-danger">اضافة</button>
                </div>
            </form>
            <div class="modal-body">
                <div>
                    <ul class="list-unstyled d-flex justify-content-between" style='border-bottom:1px solid #ccc'>
                        @foreach ($plan->RemoveBalanceToInvestmentBlans as $removedbalance)
                            <li style="color:red"> <strong>المبلغ : </strong> - {{ $removedbalance['amount'] }} دولار</li>
                            <li> <strong>التاريخ : </strong>
                                {{ date('Y-m-d H:i A', strtotime($removedbalance['created_at'])) }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
