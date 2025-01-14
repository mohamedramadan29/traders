<?php

namespace App\Http\Controllers\front;

use Carbon\Carbon;
use App\Models\admin\Plan;
use App\Models\front\User;
use Illuminate\Http\Request;
use App\Models\front\Invoice;
use App\Models\admin\Platform;
use App\Models\front\UserPlan;
use App\Models\front\SalesOrder;
use App\Http\Traits\Message_Trait;
use App\Models\front\UserStatment;
use Illuminate\Support\Facades\DB;
use App\Models\admin\PublicSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PlanInvestMent;
use Illuminate\Support\Facades\Redirect;
use App\Models\admin\UserPlatformEarning;
use Illuminate\Support\Facades\Validator;
use App\Models\admin\UserDailyInvestmentReturn;
use Illuminate\Support\Facades\Notification;

class PlanController extends Controller
{
    use Message_Trait;

    public function index()
    {
        $plans = Plan::where('status', 1)->with('platform')->get();
        //   dd($plans);
        return view('front.Plans.index', compact('plans'));
    }

    public function user_plans()
    {
        $user = Auth::user();
        //  dd($user);
        $Plans = UserPlan::where('user_id', Auth::id())->where('status', 1)->with('plan')->get();
        // dd($Plans);
        $investment_earning = UserPlatformEarning::where('user_id', $user->id)->sum('investment_return');
        $daily_earning = UserPlatformEarning::where('user_id', $user->id)->sum('daily_earning');
        $daily_earning_percentage = UserPlatformEarning::where('user_id', $user->id)->sum('profit_percentage');
        $totalbalance = UserPlan::where('user_id', $user->id)->sum('total_investment');
        $Plans = $Plans->map(function ($plan) {
            $plan_id = $plan['plan']->id;

            // إجمالي الأرباح للخطة
            $plan->plan_profit = UserPlatformEarning::where('user_id', Auth::id())
                ->where('plan_id', $plan_id)
                ->sum('investment_return');
            // أرباح آخر يوم
            $last_return = UserDailyInvestmentReturn::where('user_id', Auth::id())
                ->where('plan_id', $plan_id)
                ->latest()
                ->first();

            $plan->plan_last_dayearning = $last_return ? $last_return->daily_return : 0;
            $plan->plan_last_daypercentage = $last_return ? $last_return->profit_percentage : 0;

            // حساب آخر 7 أيام
            $last7Days = [now()->subDays(7)->startOfDay(), now()->endOfDay()];
            $plan->last_7_days_earning = UserDailyInvestmentReturn::where('user_id', Auth::id())
                ->where('plan_id', $plan_id)
                ->whereBetween('created_at', $last7Days)
                ->sum('daily_return');
            $plan->last_7_days_percentage = UserDailyInvestmentReturn::where('user_id', Auth::id())
                ->where('plan_id', $plan_id)
                ->whereBetween('created_at', $last7Days)
                ->sum('profit_percentage');
            // حساب آخر 30 يومًا
            $last30Days = [now()->subDays(30)->startOfDay(), now()->endOfDay()];
            $plan->last_30_days_earning = UserDailyInvestmentReturn::where('user_id', Auth::id())
                ->where('plan_id', $plan_id)
                ->whereBetween('created_at', $last30Days)
                ->sum('daily_return');
            $plan->last_30_days_percentage = UserDailyInvestmentReturn::where('user_id', Auth::id())
                ->where('plan_id', $plan_id)
                ->whereBetween('created_at', $last30Days)
                ->sum('profit_percentage');

            return $plan;
        });

        return view('front.Plans.user_plans', compact('Plans', 'totalbalance', 'investment_earning', 'daily_earning', 'daily_earning_percentage'));
    }

    public function platformPlans($plan_id)
    {
        $user = Auth::user();
        $plans = Invoice::with('plan')
            ->where('user_id', $user->id)
            ->where('plan_id', $plan_id)
            ->get();

        return view('front.Plans.platform_plans', compact('plans'));
    }

    public function invoice_create(Request $request)
    {
        //dd($request->all());
        try {
            $user = User::where('id', Auth::id())->first();
            if (!$user) {
                return redirect()->back()->with('error', 'المستخدم غير موجود.');
            }
            $data = $request->all();
            // dd($data);
            // التحقق من إدخال السعر والخطة
            if (!isset($data['total_price']) || $data['total_price'] <= 0) {
                return redirect()->back()->with('error', 'يرجى إدخال مبلغ صحيح.');
            }
            if (!isset($data['plan_id'])) {
                return redirect()->back()->with('error', 'يرجى اختيار الخطة.');
            }
            if ($user->dollar_balance < $data['total_price']) {
                return redirect()->back()->with('error', 'رصيدك الحالي لا يكفي لإضافة الرصيد للخطة.');
            }
            $plan = Plan::find($data['plan_id']);
            if (!$plan) {
                return redirect()->back()->with('error', 'الخطة المختارة غير موجودة.');
            }
            $public_setting = PublicSetting::first();
            if (!$public_setting) {
                return redirect()->back()->with('error', 'إعدادات السوق غير موجودة.');
            }
            $market_price = $public_setting->market_price;
            $bin_amount = $data['total_price'] / $market_price;
            DB::beginTransaction();
            $remaining_bin = $bin_amount;
            // شراء العملات من الصفقات المفتوحة
            $open_sales = SalesOrder::where('status', 0)
                ->where('selling_currency_rate', '<=', $market_price)
                ->orderBy('selling_currency_rate', 'asc')
                ->get();
            foreach ($open_sales as $sale) {
                if ($remaining_bin <= 0)
                    break;
                $available_bin = $sale->bin_amount - $sale->bin_sold;
                $seller = User::find($sale->user_id);
                if ($available_bin >= $remaining_bin) {
                    $sale->bin_sold += $remaining_bin;

                    if ($seller) {
                        $seller->dollar_balance += $remaining_bin * $sale->selling_currency_rate;
                        $seller->save();
                    }

                    if ($sale->bin_sold == $sale->bin_amount) {
                        $sale->status = 1;
                    }

                    $sale->received_user_id = $user->id;
                    $sale->save();

                    $remaining_bin = 0;
                } else {
                    $sale->bin_sold += $available_bin;

                    if ($seller) {
                        $seller->dollar_balance += $available_bin * $sale->selling_currency_rate;
                        $seller->save();
                    }

                    $sale->status = 1;
                    $sale->received_user_id = $user->id;
                    $sale->save();

                    $remaining_bin -= $available_bin;
                }
            }

            // شراء العملات المتبقية من الشركة
            if ($remaining_bin > 0) {
                if ($public_setting->currency_number < $remaining_bin) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'لا توجد عملات كافية لإتمام العملية.');
                }
                // تحديث القيم
                $public_setting->currency_number -= $remaining_bin;
                $public_setting->total_capital += $remaining_bin * $market_price;
                // حساب سعر السوق الجديد
                $new_market_price = $public_setting->total_capital / max($public_setting->currency_number, 1);
                $public_setting->market_price = $new_market_price;
                $public_setting->old_market_price = $market_price;
                $public_setting-> market_price_percentage = ($new_market_price - $market_price) / $market_price * 100;
                // حفظ التحديثات في قاعدة البيانات
                $public_setting->save();
            }

            $orderId = uniqid();
            Invoice::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'plan_price' => $data['total_price'],
                'bin_amount' => $bin_amount,
                'order_id' => $orderId,
                'order_description' => "Payment for order #" . $orderId,
                'payment_status' => 'confirmed',
            ]);
            /////////////// Add Investment Price To user_plans Total tabel
            $userplanscount = UserPlan::where('user_id', $user->id)->where('plan_id', $plan->id)->count();
            if ($userplanscount > 0) {
                $planrecord = UserPlan::where('user_id', $user->id)->where('plan_id', $plan->id)->first();
                $planrecord->total_investment += $data['total_price'];
                $planrecord->save();
            } else {
                $userplans = new UserPlan();
                $userplans->user_id = $user->id;
                $userplans->plan_id = $plan->id;
                $userplans->total_investment = $data['total_price'];
                $userplans->save();
            }

            $user->dollar_balance -= $data['total_price'];
            $user->bin_balance += $bin_amount;
            $user->save();

            //////////// Add Statment To User Statments
            $statment = new UserStatment();
            $statment->user_id = Auth::id();
            $statment->plan_id = $plan->id;
            $statment->transaction_type = 'addbalance';
            $statment->amount = $data['total_price'];
            $statment->save();

            ############### Send Notification To User ###################

            Notification::send($user, new PlanInvestMent($user,$user->id ,$plan->id, $plan->name, $data['total_price']));

            DB::commit();

            return redirect()->route('user_plans')->with('success_message', 'تم الاشتراك بنجاح في الخطة.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    public function invoice_withdraw(Request $request)
    {
        $data = $request->all();
        // $user = Auth::user();
        $user = User::where('id', Auth::id())->first();
        $userplan = UserPlan::where('user_id', $user->id)->where('plan_id', $data['plan_id'])->first();
        //dd($userplan);
        $planinvestment = $userplan->total_investment;
        $total_balance = $user['dollar_balance'];
        try {
            // التحقق من البيانات المدخلة

            $rules = [
                'plan_id' => 'required',
                'total_price' => 'required|min:1',
            ];

            $messages = [
                'plan_id.required' => 'من فضلك حدد الخطة ',
                'total_price.required' => ' من فضلك ادخل المبلغ  ',
                'total_price.min' => 'المبلغ يجب أن يكون أكبر من صفر',
            ];

            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }

            if ($planinvestment < $data['total_price']) {
                return Redirect::back()->withInput()->withErrors(' مبلغ الاستثمار في الخطا لا يكفي لهذا الطلب  ');
            }

            // حساب النسبة المطلوبة من المستخدم
            $withdraw_percentage = $data['total_price'] / $planinvestment;

            // حساب الكمية المطلوبة من العملات (Crypto Balance)
            $crypto_balance = $user['bin_balance']; // افترض أن لديك حقل في جدول المستخدمين يحمل رصيد العملات الرقمية
            $crypto_to_withdraw = $crypto_balance * $withdraw_percentage;

            if ($crypto_balance < $crypto_to_withdraw) {
                return Redirect::back()->withInput()->withErrors('رصيد العملات الرقمية غير كافٍ لتغطية السحب المطلوب.');
            }
            $public_setting = PublicSetting::first();
            $market_price = $public_setting['market_price']; // افترض أن هذه دالة تجلب سعر السوق الحالي
            DB::beginTransaction();
            $sales = new SalesOrder();
            $sales->user_id = 1;
            $sales->currency_rate = $market_price;
            $sales->enter_currency_rate = $market_price;
            $sales->selling_currency_rate = $market_price;
            $sales->currency_amount = $data['total_price'];
            $sales->bin_amount = $crypto_to_withdraw;
            $sales->bin_sold = 0;
            $sales->save();
            // تحديث رصيد العملات الرقمية
            $user->bin_balance -= $crypto_to_withdraw;
            $user->dollar_balance  = $user->dollar_balance + $data['total_price'];
            $user->Save();
            ############## Update Plan Investment
            $userplan->total_investment -= $data['total_price'];
            $userplan->save();

            #################### Add Statments
            $statment = new UserStatment();
            $statment->user_id = Auth::id();
            $statment->plan_id = $data['plan_id'];
            $statment->transaction_type = 'withdrawbalance';
            $statment->amount = $data['total_price'];
            $statment->save();
            DB::commit();
            return $this->success_message('  تم تعديل مبلغ الاستثمار في الخطة بنجاح  ');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception_message($e);
        }
    }



    // PlanController.php
    public function getPlanReport($platformId, $period)
    {
        $userId = auth()->id();

        // تأسيس الاستعلام العام بناءً على `user_id` و `plan_id`
        $query = \App\Models\admin\UserDailyInvestmentReturn::where('user_id', $userId)
            ->where('plan_id', $platformId);

        // تحديد الفترات وجمع البيانات المتاحة لكل فترة
        if ($period === 'day') {
            $query->whereDate('created_at', now()->subDay());
            $dailyEarning = $query->sum('daily_return');
            $dailyPercentage = $query->sum('profit_percentage');
        } elseif ($period === '7day') {
            $query->whereDate('created_at', '>=', now()->subDays(7));
            $dailyEarning = $query->sum('daily_return');
            $dailyPercentage = $query->sum('profit_percentage');
        } elseif ($period === '30day') {
            $query->whereDate('created_at', '>=', now()->subDays(30));
            $dailyEarning = $query->sum('daily_return');
            $dailyPercentage = $query->sum('profit_percentage');
        }

        // تنسيق القيم للعرض
        return response()->json([
            'daily_earning' => number_format($dailyEarning, 2),
            'daily_percentage' => number_format($dailyPercentage, 2),
        ]);
    }
}
