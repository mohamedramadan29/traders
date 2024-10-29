<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Http\Traits\Upload_Images;
use App\Models\admin\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PlatformController extends Controller
{
    use Message_Trait;
    use Upload_Images;

    public function index()
    {
        $platforms = Platform::all();

        return view('admin.Platforms.index',compact('platforms'));
    }
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            try {
                $data = $request->all();

                $rules = [
                    'name' => 'required',
                    'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // إضافة تحقق من نوع الملف وحجمه
                ];

                $messages = [
                    'name.required' => ' من فضلك ادخل اسم المنصة   ',
                    'logo.required' => ' من فضلك ادخل لوجو المنصة    ',
                    'logo.image' => 'يجب أن يكون الملف صورة.',
                    'logo.mimes' => 'يجب أن يكون اللوجو بصيغة jpeg, png, jpg, gif.',
                    'logo.max' => 'يجب أن لا يزيد حجم الصورة عن 2 ميجابايت.',
                ];

                // تحقق من صحة البيانات
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                }

                // معالجة الصورة وحفظها
                if ($request->hasFile('logo')){
                    $filename = $this->saveImage($request->file('logo'),'uploads/platforms/');
                } else {
                    return Redirect::back()->withInput()->withErrors(['logo' => 'حدث خطأ في رفع الصورة.']);
                }

                // إنشاء السجل في قاعدة البيانات
                Platform::create([
                    'name' => $data['name'],
                    'logo' => $filename,
                    'status' => 1,
                ]);

                return $this->success_message('تم اضافة المنصة بنجاح');
            } catch (\Exception $e) {
                return $this->exception_message($e);
            }
        }
        return view('admin.Platforms.store');
    }
    public function update(Request $request,$id)
    {
        $platform = Platform::findOrFail($id);
        if ($request->isMethod('post')) {
            try {
                $data = $request->all();
                $rules = [
                    'name' => 'required',
                ];

                if ($request->hasFile('logo')){
                    $rules['logo'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
                }
                $messages = [
                    'name.required' => ' من فضلك ادخل اسم المنصة   ',
                    'logo.required' => ' من فضلك ادخل لوجو المنصة    ',
                    'logo.image' => 'يجب أن يكون الملف صورة.',
                    'logo.mimes' => 'يجب أن يكون اللوجو بصيغة jpeg, png, jpg, gif.',
                    'logo.max' => 'يجب أن لا يزيد حجم الصورة عن 2 ميجابايت.',
                ];

                // تحقق من صحة البيانات
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                }

                // معالجة الصورة وحفظها
                if ($request->hasFile('logo')){
                    $filename = $this->saveImage($request->file('logo'),'uploads/platforms/');
                    //////// Delete Old Image
                    ///
                    if ($platform->logo){
                        Storage::delete('uploads/platforms/' . $platform->logo);
                    }
                    $platform->update([
                        'logo'=>$filename
                    ]);
                } else {
                    return Redirect::back()->withInput()->withErrors(['logo' => 'حدث خطأ في رفع الصورة.']);
                }

                // إنشاء السجل في قاعدة البيانات
                Platform::updated([
                    'name' => $data['name'],
                ]);

                return $this->success_message('تم تعديل  المنصة بنجاح');
            } catch (\Exception $e) {
                return $this->exception_message($e);
            }
        }
    }

    public function delete($id)
    {
        $platform = Platform::findOrFail($id);
        //////
       Storage::delete('uploads/platforms/'.$platform['logo']);
       // unlink($oldimage);
        $platform->delete();
        return $this->success_message( ' تم الحذف بنجاح  ');
    }

}
