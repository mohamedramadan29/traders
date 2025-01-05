<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\Admin;
use App\Models\front\StorageInvestment;
use App\Models\front\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    // Use Trait For Success Or Error Messages
    use Message_Trait;

    public function dashboard()
    {
        ############### Plans Reports #############
        $countuserinvestments = UserPlan::count();
        $totalplaninvestments = UserPlan::sum('total_investment');
        ################# InvestMentStorage ##########
        $totalcountinvestmentstorage = StorageInvestment::count();
        $totalcountinvestmentstorageactive = StorageInvestment::where('status', 1)->count();
        $totalcountinvestmentstoragedisactive = $totalcountinvestmentstorageactive - $totalcountinvestmentstorage;
        $suminvestmentstorage = StorageInvestment::sum('amount_invested');
        $suminvestmentstorageactive = StorageInvestment::where('status', 1)->sum('amount_invested');
        $suminvestmentstoragedisactive = $suminvestmentstorage - $suminvestmentstorageactive;
        ####################################################
        return view('admin.dashboard', compact('countuserinvestments', 'totalplaninvestments',
    'totalcountinvestmentstorage','totalcountinvestmentstorageactive','totalcountinvestmentstoragedisactive',
    'suminvestmentstorage','suminvestmentstorageactive','suminvestmentstoragedisactive'
    ));
    }

    ////////////////////// Login Admin //////////////
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            //            $data = $request->all();
            $rules = [
                'email' => 'required|email',
                'password' => 'required',
            ];
            $customMessage = [
                'email.required' => 'من فضلك ادخل البريد الإلكتروني',
                'email.email' => 'من فضلك ادخل بريد الكتوني صحيح',
                'password.required' => 'من فضلك ادخل كلمة المرور',
            ];
            $this->validate($request, $rules, $customMessage);
            $email = $request->email;
            $password = $request->password;


            if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password])) {
                if (Auth::guard('admin')->user()->type == 'vendor' && Auth::guard('admin')->user()->confirm == '0') {
                    $this->Error_message('يجب تفعيل البريد الالكتروني الخاص بك اولا ');
                } elseif (Auth::guard('admin')->user()->type != 'vendor' && Auth::guard('admin')->user()->status == '0') {
                    $this->Error_message(' حساب الادمن الخاص بك غير فعال  ');
                } else {
                    //  dd('Goood');
                    return redirect('admin/dashboard');
                }
            } else {

                //$this->Error_message(' لا يوجد حساب بهذه البيانات  ');
                return Redirect::back()->withInput()->withErrors('لا يوجد حساب بهذه البيانات  ');
            }
        }

        return view('admin.login');
    }


    ///////////////////////// Sign Up //////////////////////
    ///
    public function signup()
    {
        return view('admin.sign-up');
    }
    public function forget_password()
    {
        return view('admin.forget-password');
    }
    // check admin password in client side
    public function check_admin_password(Request $request)
    {
        $data = $request->all();
        $old_password = $data['current_password'];
        if (Hash::check($old_password, Auth::guard('admin')->user()->password)) {
            return "true";
        } else {
            return "false";
        }
    }

    /////// Update Admin Password /////////////
    public function update_admin_password(Request $request)
    {
        if ($request->isMethod('post')) {

            $request_data = $request->all();
            //check if old password is correct or not
            if (Hash::check($request_data['old_password'], Auth::guard('admin')->user()->password)) {
                // check if the new password == confirm password
                if ($request_data['new_password'] == $request_data['confirm_password']) {
                    $admin_user = Admin::where('id', Auth::guard('admin')->user()->id);
                    $admin_user->update([
                        'password' => bcrypt($request_data['new_password'])
                    ]);
                    $this->success_message('تم تعديل كلمة المرور بنجاح');
                } else {
                    $this->Error_message('يجب تأكيد كلمة المرور بشكل صحيح');
                }
            } else {
                $this->Error_message('كلمة المرو القديمة غير صحيحة');
            }
        }
        $admin_data = Admin::where('email', Auth::guard('admin')->user()->email)->first();
        return view('admin.AdminSetting.update_admin_password', compact('admin_data'));
    }

    ///////////////// Update Admin Details  //////////
    public function update_admin_details(Request $request)
    {
        $admin_data = Admin::where('id', Auth::guard('admin')->user()->id)->first();
        $id = $admin_data['id'];
        if ($request->isMethod('post')) {
            $all_update_data = $request->all();
            ////////////////////// Make Validation //////////////
            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'email' => 'required|email|unique:admins,email,' . $id,
                'phone' => 'required|numeric|digits_between:8,14',
            ];
            $customeMessage = [
                'name.required' => 'من فضلك ادخل الأسم',
                'name.regex' => 'من فضلك ادخل الأسم بشكل صحيح ',
                'email.required' => 'من فضلك ادخل البريد الألكتروني',
                'email.email' => 'من فضلك ادخل البريد الألكتروني بشكل صحيح',
                'email.unique' => 'هذا البريد الألكتروني موجود من قبل من فضلك ادخل بريد الكتروني جديد',
                'phone.required' => 'من فضلك ادخل رقم الهاتف',
                'phone.digits_between' => 'رقم الهاتف يجب ان يكون من 8 الي 14 رقم',
            ];
            $this->validate($request, $rules, $customeMessage);
            $admin_data->update([
                'name' => $all_update_data['name'],
                'email' => $all_update_data['email'],
                'phone' => $all_update_data['phone'],
            ]);
            $this->success_message('تم تحديث البيانات بنجاح');
            //            return redirect()->back()->with(['Success_message'=>'']);
        }
        return view('admin.AdminSetting.update_admin_data', compact('admin_data'));
    }

    ////////////////// View Admins , Sub Admins , Vendors
    ///
    ///
    public function admins($type = null)
    {
        if ($type != null) {
            $admins = Admin::where('type', $type)->get();
            $title = ucfirst($type);
        }
        if ($type == 'all') {
            $admins = Admin::all();
            $title = 'مشاهدة الكل ';
        }
        //        dd($admins);
        return view('admin.admins.admins', compact('admins', 'title'));
    }
    /////////////////// Logout Admin /////////////////////
    ///
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
