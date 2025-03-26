<div class="modal fade edit_balance_tab" id="main_withdraw_balance" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color:#2a3040">
            <div class="modal-header">
                <p class="modal-title" id="exampleModalLabel"> سحب الرصيد </p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="add_balance" role="tabpanel"
                    aria-labelledby="add_balance_tap" tabindex="0">
                    <form action="{{ url('user/withdraw/add') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="exchange_third_section withdraw_main_section">
                                <div class="form-group">
                                    <label for="amount"> ادخل مبـلغ الســحـب </label>
                                    <div class="input_data mb-3">
                                        <input required type="number" id="amount" min="10"
                                            max="{{ Auth::user()->dollar_balance }}" name="amount"
                                            placeholder=" اقل مبلغ للسحب 10 ">
                                        <span>دولار </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="withdraw_method"> حـدد المحفــظة </label>
                                    <div class="mb-3 input_data">
                                        <select required id="withdraw_method" required name="withdraw_method"
                                            class="form-select">
                                            <option selected disabled value=""> -- حدد المحفظة -- </option>
                                            <option selected value="USDT-TRC20"> USDT-TRC20 </option>
                                            <option selected value="USDT-TRC20"> USDT-TRC20 </option>
                                            <option selected value="USDT-TRC20"> USDT-TRC20 </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="withdraw_method"> ادخل عنوان المحفــظـة </label>
                                    <div class="mb-3 input_data">
                                        <input required class="form-control" type="text" name="usdt_link"
                                            value="" placeholder="ادخل عنوان المحفظة ">
                                    </div>
                                    <p class="available"> متاح {{ number_format(Auth::user()->dollar_balance, 2) }}
                                        دولار
                                    </p>
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
