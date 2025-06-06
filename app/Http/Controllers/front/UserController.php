<?php

namespace App\Http\Controllers\front;

use Carbon\Carbon;
use App\Models\admin\Plan;
use App\Models\front\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\front\UserPlan;
use App\Http\Traits\Message_Trait;
use App\Http\Traits\Upload_Images;
use App\Models\admin\CurrencyPlan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use Message_Trait;
    use Upload_Images;

    public function index()
    {
        $user = Auth::user();
        $plans = Plan::where('status', 1)->with('platform', 'total_plans', 'investmentReturns')->get();
        $count_plans = $plans->count();
        ################## Plan With Returns #################
        $plansWithReturns = $plans->map(function ($plan) {
            $returns = $plan->investmentReturns;
            // الحصول على تاريخ آخر إدخال
            $lastEntryDate = $returns->max('return_date');
            // إذا لم يتم إدخال عوائد اليوم، استخدم آخر إدخال متاح
            $todayReturns = $returns->where('return_date', Carbon::today())->sum('return_amount');
            if ($todayReturns == 0 && $lastEntryDate) {
                $todayReturns = $returns->where('return_date', $lastEntryDate)->sum('return_amount');
            }

            // عوائد آخر 7 أيام (حتى اليوم أو آخر إدخال متاح)
            $last7DaysReturns = $returns->whereBetween('return_date', [
                Carbon::now()->subDays(7),
                $lastEntryDate ?? Carbon::now()
            ])->sum('return_amount');

            // عوائد آخر 30 يومًا (حتى اليوم أو آخر إدخال متاح)
            $last30DaysReturns = $returns->whereBetween('return_date', [
                Carbon::now()->subDays(30),
                $lastEntryDate ?? Carbon::now()
            ])->sum('return_amount');

            // إجمالي الاستثمار في الخطة
            $totalInvestmentPlan = $plan->total_plans->sum('total_investment');
            $total_subscriptions = $plan->total_plans ? $plan->total_plans->count() : 0;

            return [
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
                'current_price' => $plan->current_price,
                'step_price' => $plan->step_price,
                'logo' => $plan->logo,
                'total_subscriptions' => $total_subscriptions,
                'totalinvestment' => $totalInvestmentPlan,
                'platform_name' => $plan->platform_name,
                'platform_link' => $plan->platform_link,
                'today_returns_percentage' => $totalInvestmentPlan > 0 ? $todayReturns : 0,
                'last_7_days_percentage' => $totalInvestmentPlan > 0 ? $last7DaysReturns : 0,
                'last_30_days_percentage' => $totalInvestmentPlan > 0 ? $last30DaysReturns : 0,
            ];
        });
        ################# Start Currency Plans #################
        $currencyPlans = CurrencyPlan::with('investments')->where('status', 1)->get();
        $count_currency_plans = $currencyPlans->count();
        ################ End Currency Plans #####################

        return view('front.dashboard', compact('plansWithReturns', 'plans', 'currencyPlans', 'count_plans', 'count_currency_plans'));
    }


    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            try {
                // تأكيد ما إذا كان التسجيل يتم باستخدام كود إحالة
                $referral_code = $request->input('referral_code');
                //dd($referral_code);
                $referring_user = null;
                if ($referral_code) {
                    // ابحث عن المستخدم الذي يملك كود الإحالة
                    $referring_user = User::where('referral_code', $referral_code)->first();
                }
                $new_user_referral_code = Str::random(10);
                ### check if the new user referral code is already used
                $check_new_user_referral_code = User::where('referral_code', $new_user_referral_code)->count();
                if($check_new_user_referral_code > 0){
                    $new_user_referral_code = $new_user_referral_code . '-' . $check_new_user_referral_code;
                }
                // ابحث عن المستخدم الذي يملك كود الإحالة
                DB::beginTransaction();
                $data = $request->all();
                // dd($data);
                $email = $data['email'];
                $checkUseremail = User::where('email', $email)->count();
                if ($checkUseremail > 0) {
                    return redirect()->back()->withErrors([' البريد الالكتروني مستخدم بالفعل من فضلك ادخل بريد الكتروني جديد  '])->withInput();
                }
                $rules = [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email|max:150',
                    'password' => 'required|min:8',
                    'confirm-password' => 'required|same:password'
                ];
                $messages = [
                    'name.required' => ' من فضلك ادخل الاسم  ',
                    'email.required' => 'من فضلك ادخل البريد الالكتروني ',
                    'email.unique' => 'البريد الالكتروني مستخدم بالفعل ',
                    'email.email' => 'من فضلك ادخل بريد الكتروني بشكل صحيح ',
                    'email.max' => 'من فضلك ادخل بريد الكتروني اقل من 150 حرف ',
                    'password.required' => 'من فضلك ادخل كلمة المرور ',
                    'password.min' => ' من فضلك ادخل كلمة مرور قوية اكثر من 8 احرف وارقام ',
                    'confirm-password.same' => 'من فضلك اكد كلمة المرور بشكل صحيح ',
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'account_status' => 0,
                    'referral_code' => $new_user_referral_code,
                    'referred_by' => $referring_user ? $referring_user->id : null,
                ]);
                ////////// Login User To Dashboard #################

                ////////////////////// Send Confirmation Email ///////////////////////////////
                ///
                // $email = $data['email'];
                // $MessageDate = [
                //     'name' => $data['name'],
                //     "email" => $data['email'],
                //     'code' => base64_encode($email)
                // ];
                // Mail::send('front.mails.UserActivationEmail', $MessageDate, function ($message) use ($email) {
                //     $message->to($email)->subject(' تفعيل الحساب الخاص بك  ');
                // });
                DB::commit();
                Auth::login($user);
                return redirect()->route('dashboard');
                //return $this->success_message('تم انشاء الحساب بنجاح من فضلك فعل حسابك من خلال البريد المرسل  ⚡️');
            } catch (\Exception $e) {
                return $this->exception_message($e);
            }
        }
        return view('front.sign-up');
    }

    public function send_confirm_email(Request $request)
    {
        $email = Auth::user()->email;
        $MessageDate = [
            'name' => Auth::user()->name,
            "email" => Auth::user()->email,
            'code' => base64_encode($email)
        ];
        Mail::send('front.mails.UserActivationEmail', $MessageDate, function ($message) use ($email) {
            $message->to($email)->subject(' تفعيل الحساب الخاص بك  ');
        });
        return $this->success_message('  تم ارسال رابط التفعيل الخاص بك علي البريد الالكتروني المسجل  ⚡️');
    }

    // Active User Email
    public function UserConfirm($email)
    {
        $email = base64_decode($email);
        // check if this email exist in users or not
        $user_details = User::where('email', $email)->first();
        $userCount = User::where('email', $email)->count();
        if ($userCount > 0) {
            if ($user_details->account_status == 1) {
                //$message = 'تم تفعيل البريد الالكتروني بالفعل ! سجل دخولك الان ';
                // return redirect('login')->with('Error_Message', $message);
                return redirect()->route('profile')->withErrors([' تم تفعيل الحساب الخاص بك من قبل !! '])->withInput();
            } else {
                // Update User Status
                User::where('email', $email)->update(['account_status' => 1]);
                // Redirect User To Login/ Regitser Page With Message
                $message = ' تم تفعيل الحساب الخاص بك بنجاح  ';
                return redirect()->route('profile')->with('Success_message', $message);
            }
        } else {
            abort(404);
        }
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            try {
                $data = $request->all();
                $rules = [
                    'email' => 'required|email',
                    'password' => 'required'
                ];
                $messages = [
                    'email.required' => '  من فضلك ادخل البريد الالكتروني   ',
                    'email.email' => ' من فضلك ادخل بريد الكتروني صحيح  ',
                    'password.required' => ' من فضلك ادخل كلمة المرور ',
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $request['remeber'])) {
                    //                    if (Auth::user()->status == 0) {
                    //                        Auth::logout();
                    //                        return Redirect::back()->withInput()->withErrors('  من فضلك يجب تفعيل الحساب الخاص بك اولا  ');
                    //                    }
                    return \redirect('user/dashboard');
                } else {
                    return Redirect::back()->withInput()->withErrors('لا يوجد حساب بهذه البيانات  ');
                }
            } catch (\Exception $e) {
                return $this->exception_message($e);
            }
        }
        if (Auth::user()) {
            return \redirect('user/dashboard');
        }
        return view('front.login');
    }

    public function forget_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);
            $email = $data['email'];
            $user = User::where('email', $email)->count();
            if ($user > 0) {
                ////////////////////// Send Forget Mail To User  ///////////////////////////////
                ///
                DB::beginTransaction();
                $email = $data['email'];
                $MessageDate = [
                    'code' => base64_encode($email)
                ];
                Mail::send('front.mails.UserChangePasswordMail', $MessageDate, function ($message) use ($email) {
                    $message->to($email)->subject(' رابط تغير كلمة المرور ');
                });
                DB::commit();
                return $this->success_message(' تم ارسال رابط تغير كلمة المرور علي البريد الالكتروني  ');
            } else {
                return Redirect::back()->withErrors(['للاسف لا يوجد حساب بهذة البيانات ']);
                // return $this->Error_message(' للاسف لا يوجد حساب بهذة البيانات  ');
            }
        }
        return view('front.forget-password');
    }

    public function change_forget_password(Request $request, $email)
    {
        $email = base64_decode($email);
        return view('front.change-password', compact('email'));
    }

    public function update_forget_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);
            $email = $data['email'];
            //dd($data);
            $usercount = User::where('email', $email)->count();
            if ($usercount > 0) {
                ////////// Start Change Password
                $user = User::where('email', $email)->first();
                $rules = [
                    'password' => 'required',
                    'confirm_password' => 'required|same:password'
                ];
                $messages = [
                    'password.required' => ' من فضلك ادخل كلمة المرور  ',
                    'confirm_password.required' => ' من فضلك اكد كلمة المرور ',
                    'confirm_password.same' => ' من فضلك يجب تاكيد كلمة المرور بنجاح '
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                }
                $user->update([
                    'password' => Hash::make($data['password']),
                ]);
                return redirect()->to('/login')->with('Success_message', '   تم تعديل كلمة المرور بنجاح سجل ذخولك الان ');
            } else {
                return Redirect::back()->withErrors(['للاسف لا يوجد حساب بهذة البيانات ']);
            }
        }
    }


    // check admin password in client side
    public function check_user_password(Request $request)
    {
        $data = $request->all();
        $old_password = $data['current_password'];
        if (Hash::check($old_password, Auth::user()->password)) {
            return "true";
        } else {
            return "false";
        }
    }

    /////// Update Admin Password /////////////
    public function update_user_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $request_data = $request->all();
            //check if old password is correct or not
            if (Hash::check($request_data['old_password'], Auth::user()->password)) {
                // check if the new password == confirm password
                if ($request_data['new_password'] == $request_data['confirm_password']) {
                    $user = User::where('id', Auth::user()->id)->first();
                    $user->update([
                        'password' => bcrypt($request_data['new_password'])
                    ]);
                    return $this->success_message('تم تعديل كلمة المرور بنجاح ');
                } else {
                    return $this->Error_message('يجب تأكيد كلمة المرور بشكل صحيح');
                }
            } else {
                return $this->Error_message('كلمة المرو القديمة غير صحيحة');
            }
        }
    }

    public function updateProfileImage(Request $request)
    {
        // $user = Auth::user();
        $user = User::where('id', Auth::id())->first();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $this->saveImage($file, public_path('assets/uploads/users/'));
            // $filename = time() . '.' . $file->getClientOriginalExtension();
            //  $file->move(public_path('assets/uploads/users'), $filename);

            // حذف الصورة القديمة إذا وجدت
            if ($user->image && file_exists(public_path('assets/uploads/users/' . $user->image))) {
                $oldimage = public_path('assets/uploads/users/' . $user->image);
                @unlink($oldimage);
            }
            // تحديث صورة المستخدم
            $user->image = $filename;
            $user->save();

            return response()->json([
                'success' => true,
                'imageUrl' => asset('assets/uploads/users/' . $filename)
            ]);
        }

        return response()->json(['success' => false]);
    }


    ///////////////// Update Admin Details  //////////
    public function update_user_details(Request $request)
    {
        $user = User::where('id', Auth::id())->first();

        if ($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);
            $all_update_data = $request->all();
            ////////////////////// Make Validation //////////////
            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                //'email' => 'required|email|unique:users,email,' . Auth::user()->id,
                'country' => 'required|regex:/^[\pL\s\-]+$/u',
                'city' => 'required|regex:/^[\pL\s\-]+$/u',

            ];
            $customeMessage = [
                'name.required' => 'من فضلك ادخل الأسم',
                'name.regex' => 'من فضلك ادخل الأسم بشكل صحيح ',
                // 'email.required' => 'من فضلك ادخل البريد الألكتروني',
                //  'email.email' => 'من فضلك ادخل البريد الألكتروني بشكل صحيح',
                //  'email.unique' => 'هذا البريد الألكتروني موجود من قبل من فضلك ادخل بريد الكتروني جديد',
                'country.required' => ' من فضلك ادخل الدولة  ',
                'country.regex' => ' من فضلك ادخل الدولة بشكل صحيح  ',
                'city.required' => ' من فضلك ادخل المدينة   ',
                'city.regex' => ' من فضلك ادخل المدينة بشكل صحيح  ',

            ];
            $this->validate($request, $rules, $customeMessage);
            $user->update([
                'name' => $all_update_data['name'],
                'country' => $all_update_data['country'],
                'city' => $all_update_data['city'],
            ]);
            return $this->success_message('تم تحديث البيانات بنجاح');
            //            return redirect()->back()->with(['Success_message'=>'']);
        }
    }

    ////////////// User Profile
    public function profile()
    {
        $user = Auth::user();
        return view('front.user.profile', compact('user'));
    }
    /////////////////// Logout Admin /////////////////////
    ///
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
