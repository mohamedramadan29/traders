<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\Plan;
use App\Models\admin\Platform;
use App\Models\admin\PlatformInvestmentReturn;
use App\Models\admin\UserDailyInvestmentReturn;
use App\Models\admin\UserPlatformEarning;
use App\Models\front\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PlatFormInvestmentController extends Controller
{
    use Message_Trait;

    public function index($id)
    {
        $plan = Plan::findOrFail($id);
        $plan_invests = PlatformInvestmentReturn::where('plan_id', $plan['id'])->get();
        return view('admin.Plans.investments', compact('plan', 'plan_invests'));
    }

    public function store(Request $request, $id)
    {
        try {
            $plan = Plan::findOrFail($id);
            //dd($plan);
            $data = $request->all();
            $rules = [
                'return_amount' => 'required|min:0'
            ];
            $message = [
                'return_amount.required' => ' من فضلك ادخل المبلغ  ',
                'return_amount.min' => 'اقل مبلغ  0',
            ];
            $validator = Validator::make($data, $rules, $message);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            DB::beginTransaction();
            PlatformInvestmentReturn::create([
                'plan_id' => $plan->id,
                'return_amount' => $request->return_amount,
                'return_date' => now(),
            ]);

            //       جلب جميع الفواتير المتعلقة بالمنصة
            // جلب جميع الفواتير المتعلقة بالمنصة
            //  $invoices = Invoice::where('platform_id', $platform->id)->get();

            $invoices = Invoice::where('plan_id', $plan->id)->where('status', 1)
                ->with('user') // لجلب بيانات المستخدم
                ->get();
            // dd($invoices);

            if ($invoices->isEmpty()) {
                return redirect()->back()->with('error', 'لا يوجد مشتركين في هذه المنصة.');
            }

            // حساب إجمالي عدد الفواتير في هذه المنصة
            $totalSubscriptions = $invoices->count();

            // حساب العائد لكل اشتراك
            $returnPerSubscription = $request->return_amount / $totalSubscriptions;

            // توزيع العائد على المستخدمين بناءً على عدد خططهم في المنصة
            foreach ($invoices->groupBy('user_id') as $userInvoices) {
                // dd($plan->id);
                $user = $userInvoices->first()->user;
                /////////// حساب اجمالي قيمة الاشتراكات للمستخدم
                $totalbalance = $invoices->sum('plan_price');
                $dailyProfit = $totalbalance * $request->return_amount;

                //  dd($user);
                // جلب سجل عائد الاستثمار للمستخدم في هذه المنصة
                //  dd($plan->id);
                $userEarning = UserPlatformEarning::firstOrCreate([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                ]);
                // إضافة العائد بناءً على عدد الاشتراكات الخاصة بالمستخدم
                $userEarning->increment('investment_return', $dailyProfit);
                $profitPercentage = $request->return_amount;
                // يمكنك هنا حفظ أو عرض نسبة الربح

                $userEarning->profit_percentage = $profitPercentage;
                $userEarning->daily_earning = $dailyProfit;
                $userEarning->save();

                $user_daily_investment_return = new UserDailyInvestmentReturn();
                $user_daily_investment_return->user_id = $user->id;
                $user_daily_investment_return->plan_id = $plan->id;
                $user_daily_investment_return->daily_return = $dailyProfit;
                $user_daily_investment_return->profit_percentage = $request->return_amount;
                $user_daily_investment_return->save();

                // يمكنك هنا تسجيل البيانات أو إرسال إشعار للمستخدم إن أردت
                ///////////// تحديث ربح الكلي للمستخدم
                $old_user_balance = $user['dollar_balance'];
                $new_user_balance = $old_user_balance + $dailyProfit;
                $user->dollar_balance = $new_user_balance;
                $user->update();
            }
            DB::commit();

            return $this->success_message(' تم اضافة العائد بنجاح  ');
        } catch (\Exception $e) {
            return $this->exception_message($e);
        }
    }
}
