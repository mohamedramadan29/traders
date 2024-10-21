<div class="modal fade" id="edit_withdraw_{{$platform['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> تعديل المنصة   </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('admin/platform/update/'.$platform['id'])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for=""> الاسم  </label>
                        <input required type="text" name="name" class="form-control"
                               value="{{$platform['name']}}">
                    </div>
                    <div class="mb-3">
                        <label for="">  اللوجو   </label>
                        <input type="file" name="logo" class="form-control" >
                        <img width="80px" src="{{ Storage::url('uploads/platforms/'.$platform['logo']) }}" alt="">

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
