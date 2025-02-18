<?php

namespace App\Http\Controllers\front;

use App\Models\front\User;
use Illuminate\Http\Request;
use App\Models\admin\OksSetting;
use App\Http\Traits\Message_Trait;
use App\Models\front\OksInvestment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class OksContoller extends Controller
{

    use Message_Trait;

    public function index()
    {
        $okssetting = OksSetting::find(1);
        $investments = OksInvestment::all();
        ########## ْUser Investments
        $userInvestments = OksInvestment::where('user_id', Auth::id())->get();

        return view('front.oks.index', compact('okssetting', 'investments','userInvestments'));
    }
    public function OksInvestment(Request $request)
    {
        try {
            $okssetting = OksSetting::find(1);
            $oks_current_numbers = $okssetting->oks_numbers; // عدد العملات المتاحة
            $oks_current_price = $okssetting->current_price; // السعر الحالي
            $total_price = $request->input('total_price'); // مبلغ الاستثمار

            // التحقق من رصيد المستخدم
            $user = User::where('id', Auth::id())->first();
            if ($user->dollar_balance < $total_price) {
                return Redirect()->back()->withErrors(['رصيدك الحالي لا يكفي للاشتراك في الخطة']);
            }

            // حساب عدد العملات التي سيحصل عليها المستخدم
            $user_oks_numbers = $total_price / $oks_current_price;

            // إضافة الاستثمار الجديد
            $investment = new OksInvestment();
            $investment->user_id = Auth::id();
            $investment->oks_numbers = $user_oks_numbers;
            $investment->total_investment = $total_price;
            $investment->total_profit = 0;
            $investment->total_withdraw = 0;
            $investment->save();

            // تحديث رصيد المستخدم
            $user->dollar_balance -= $total_price;
            $user->save();

            // تحديث بيانات النظام
            $okssetting->total_investment += $total_price;
            $okssetting->oks_numbers -= $user_oks_numbers;

            // حساب السعر الجديد بطريقة تدريجية
            if ($okssetting->total_investment > 0) {
                $okssetting->current_price = $oks_current_price * (1 + ($total_price / ($okssetting->total_investment + $total_price)));
            }

            $okssetting->save();

            return $this->success_message(' تم الاستثمار بنجاح  ');
        } catch (\Exception $e) {
            return $this->exception_message($e);
        }
    }


}
