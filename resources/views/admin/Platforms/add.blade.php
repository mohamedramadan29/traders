<div class="modal fade" id="add_attribute" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">  اضافة مستوي جديد   </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('admin/user-level/add')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for=""> الاسم  </label>
                        <input required type="text" name="name" class="form-control" placeholder="اسم المستوي"
                               value="{{old('name')}}">
                    </div>
                    <div class="mb-3">
                        <label for="">  حجم التداول  </label>
                        <input required type="number" name="turnover" class="form-control" placeholder="حجم التداول "
                               value="{{old('turnover')}}">
                    </div>
                    <div class="mb-3">
                        <label for="">  نسبة ال volshare  </label>
                        <input required type="text" name="percent_volshare" class="form-control" placeholder="النسبة"
                               value="{{old('percent_volshare')}}">
                    </div>
                    <div class="mb-3">
                        <label for=""> Bonus  </label>
                        <input required type="text" name="bonus" class="form-control" placeholder="Bonus"
                               value="{{old('bonus')}}">
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
