<div class="modal fade edit_balance_tab" id="main_add_balance" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color:#2a3040">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> ايداع رصيد في حسابك  </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="add_balance" role="tabpanel" aria-labelledby="add_balance_tap" tabindex="0">
                    <form action="{{url('user/deposit')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="exchange_third_section">
                                <div class="form-group">
                                    <div class="input_data">
                                        <input min="1" style="width: 100%" type="number" name="deposit" step="0.01" placeholder="الحد الادني 10">
                                        <span style="margin-left: 10px"> دولار  </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn" style="background-color:#11af59;color:#fff;"> تاكيد  </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> رجوع</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
