<div class="modal fade" id="lock_plan_{{$plan['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">  هل انت متاكد من  اغلاق الصفقة      </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('admin/plan/lock/'.$plan['id'])}}" method="post">
                @csrf
                <div class="modal-body">
                    <label for=""> الاسم  </label>
                    <input type="text" name="name" class="form-control" disabled readonly value="{{$plan['name']}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> رجوع</button>
                    <button type="submit" class="btn btn-danger">اغلاق الصفقة  </button>
                </div>
            </form>
        </div>
    </div>
</div>
