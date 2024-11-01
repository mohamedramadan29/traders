<div class="modal fade" id="add_attribute" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> اضافة طلب سحب </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('user/withdraw/add')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for=""> المستخدم </label>
                        <input class="form-control" type="text" disabled readonly value="{{\Illuminate\Support\Facades\Auth::user()->name}}">
                    </div>
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
