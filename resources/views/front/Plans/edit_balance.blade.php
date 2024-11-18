<div class="modal fade edit_balance_tab" id="edit_balance" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color:#2a3040">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> تعديل الرصيد   </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="add_balance_tap" data-bs-toggle="tab" data-bs-target="#add_balance" type="button" role="tab" aria-controls="add_balance" aria-selected="true"> اضافة رصيد  </button>
                    <button class="nav-link" id="withdraw_balance_tap" data-bs-toggle="tab" data-bs-target="#withdraw_balance" type="button" role="tab" aria-controls="withdraw_balance" aria-selected="false"> سحب رصيد </button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="add_balance" role="tabpanel" aria-labelledby="add_balance_tap" tabindex="0">
                    <form action="{{url('user/withdraw/add')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="exchange_third_section">
                                <div class="form-group">
                                    <div class="input_data">
                                        <input type="number" step="0.01" placeholder="الحد الادني 0.01">
                                        <span>usdt</span>
                                        <button> الحد الاقصي</button>
                                    </div>
                                    <p class="available"> متاح 40.6000 </p>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <p> اضافة رصيد 10 دولار الي حطة التداول في منصة Quotex </p>
                            <button type="submit" class="btn" style="background-color:#11af59;color:#fff;"> تاكيد  </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> رجوع</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="withdraw_balance" role="tabpanel" aria-labelledby="withdraw_balance_tap" tabindex="0">
                    <form action="{{url('user/withdraw/add')}}" method="post" class="withdraw_form">
                        @csrf
                        <div class="modal-body">
                                <input class="form-control" type="hidden" disabled readonly value="{{\Illuminate\Support\Facades\Auth::user()->name}}">
                            <div class="mb-3">
                                <label for="">المبلغ   </label>
                                <input required type="number"  step="0.01"  name="amount" class="form-control" placeholder="المبلغ "
                                       value="">
                            </div>
                            <div class="mb-3">
                                <label for=""> حدد المحفظة </label>
                                <select required name="withdraw_method" class="form-control" id="">
                                    <option selected value="USDT-TRC20"> USDT-TRC20 </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for=""> ادخل عنوان المحفظة  </label>
                                <input required class="form-control" type="text" name="usdt_link" value="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> رجوع</button>
                            <button type="submit" class="btn" style="background-color:#11af59;color:#fff;">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
