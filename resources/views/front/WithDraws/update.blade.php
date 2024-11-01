<div class="modal fade" id="edit_withdraw_{{$withdraw['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> تعديل حالة الطلب </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('user/withdraw/update/'.$withdraw['id'])}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for=""> المبلغ </label>
                        <input type="text" name="name" class="form-control" value="{{$withdraw['amount']}}">
                    </div>
                    <div class="mb-3">
                        <label for=""> تعديل الحالة  </label>
                        <select name="status" id="" class="form-control">
                            <option value="0"> تحت المراجعه  </option>
                            <option value="1"> تم التحويل  </option>
                            <option value="2"> رفض العملية  </option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> رجوع</button>
                    <button type="submit" class="btn btn-primary"> تعديل حالة العملية  </button>
                </div>
            </form>
        </div>
    </div>
</div>
