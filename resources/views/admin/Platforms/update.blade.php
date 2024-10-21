<div class="modal fade" id="edit_withdraw_{{$level['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">  تعديل المستوي  </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('admin/user-level/update/'.$level['id'])}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for=""> الاسم  </label>
                        <input required type="text" name="name" class="form-control" placeholder="اسم المستوي"
                               value="{{$level['name']}}">
                    </div>
                    <div class="mb-3">
                        <label for="">  حجم التداول  </label>
                        <input required type="number" name="turnover" class="form-control" placeholder="حجم التداول "
                               value="{{$level['turnover']}}">
                    </div>
                    <div class="mb-3">
                        <label for="">  نسبة ال volshare  </label>
                        <input required type="text" name="percent_volshare" class="form-control" placeholder="النسبة"
                               value="{{$level['percent_volshare']}}">
                    </div>
                    <div class="mb-3">
                        <label for=""> Bonus  </label>
                        <input required type="text" name="bonus" class="form-control" placeholder="Bonus"
                               value="{{$level['Bonus']}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> رجوع</button>
                    <button type="submit" class="btn btn-primary"> تعديل  </button>
                </div>
            </form>
        </div>
    </div>
</div>
