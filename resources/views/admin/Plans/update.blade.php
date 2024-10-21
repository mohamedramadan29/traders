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
                        <label for=""> منصة التداول </label>
                        <select name="platform_id" id="" class="form-select">
                            <option value="" selected disabled> -- حدد --</option>
                            @foreach($platforms as $platform)
                                <option @if($plan['platform_id'] == $platform['id']) selected
                                        @endif value="{{$platform['id']}}"> {{ $platform['name'] }}</option>
                            @endforeach
                        </select>
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
                        <label for=""> نسبة الربح اليوم </label>
                        <input type="number" name="daily_percentage" class="form-control" step="0.01" min="0"
                               value="{{$plan['daily_percentage']}}">
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
