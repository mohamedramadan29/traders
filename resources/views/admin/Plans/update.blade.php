<div class="modal fade" id="edit_withdraw_{{$plan['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> تعديل الخطة </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('admin/plan/update/'.$plan['id'])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for=""> الاسم </label>
                        <input required type="text" name="name" class="form-control"
                               value="{{$plan['name']}}">
                    </div>
                    <div class="mb-3">
                        <label for=""> اسم المنصة  </label>
                        <input required type="text" name="platform_name" class="form-control"
                               value="{{$plan['platform_name']}}">
                    </div>
                    <div class="mb-3">
                        <label for="">  لوجو المنصة  </label>
                        <input type="file" name="platform_logo" class="form-control">
                        <img src="{{asset('assets/uploads/plans/'.$plan['logo'])}}" width="40px" height="40px" alt="">
                    </div>
                    <div class="mb-3">
                        <label for="">  رابط المنصة  </label>
                        <input required type="text" name="platform_link" class="form-control"
                               value="{{$plan['platform_link']}}">
                    </div>
                    <div class="mb-3">
                        <label for=""> سعر الخطة </label>
                        <input required type="number" name="main_price" class="form-control"
                               value="{{$plan['main_price']}}" step="0.01">
                    </div>

                    <div class="mb-3">
                        <label for=""> قيمة الزيادة عند اشتراك جديد </label>
                        <input required type="number" name="step_price" class="form-control" step="0.01" min="0"
                               value="{{$plan['step_price']}}">
                    </div>

                    <div class="mb-3">
                        <label for=""> العائد الاستثماري </label>
                        <input required type="number" name="return_investment" class="form-control"
                               value="{{$plan['return_investment']}}" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="">  نسبة الخصم عند الانسحاب    </label>
                        <input type="number" name="withdraw_discount" class="form-control"
                               value="{{$plan['withdraw_discount']}}">
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
