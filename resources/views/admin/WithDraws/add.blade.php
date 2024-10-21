<div class="modal fade" id="add_attribute" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> اضافة طلب سحب </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('admin/withdraw/add')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for=""> المستخدم </label>
                        <select required name="user_id" class="form-control" id="">
                            @foreach($users as $user)
                                <option value="{{$user['id']}}">{{$user['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">المبلغ <span class="badge badge-danger bg-danger"> دولار </span> </label>
                        <input required type="number" min="1" name="amount" class="form-control" placeholder="المبلغ "
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
                        <input class="form-control" type="text" name="usdt_link" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> رجوع</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
