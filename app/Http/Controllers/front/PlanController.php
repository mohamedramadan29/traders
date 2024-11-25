<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\Plan;
use App\Models\admin\Platform;
use App\Models\admin\UserPlatformEarning;
use App\Models\front\Invoice;
use App\Models\front\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

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
        // الحصول على عدد الاشتراكات لكل منصة
        $Plans = Plan::withCount(['invoices' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->get();
        $totalPlansCount = Invoice::where('user_id', $user->id)->count();
        $totalbalance = Invoice::where('user_id', $user->id)->sum('plan_price');
        $investment_earning = UserPlatformEarning::where('user_id', $user->id)->sum('investment_return');
        $daily_earning = UserPlatformEarning::where('user_id', $user->id)->sum('daily_earning');

        // تأكد من أن إجمالي رأس المال أكبر من صفر لتجنب القسمة على الصفر
        if ($totalbalance > 0) {
            // جلب العوائد من كل منصة للمستخدم
            $userPlatforms = UserPlatformEarning::where('user_id', $user->id)->get();

            // متغير لتجميع النسب الموزونة
            $weightedProfitPercentage = 0;

            foreach ($userPlatforms as $platformEarning) {
                // رأس المال المستخدم في هذه المنصة (المبلغ المدفوع في خطط هذه المنصة)
                $platformCapital = Invoice::where('user_id', $user->id)
                    ->where('platform_id', $platformEarning->platform_id)
                    ->sum('plan_price');

                // نسبة الربح اليومية لهذه المنصة
                $platformDailyPercentage = $platformEarning->profit_percentage; // نسبة الربح لكل منصة محفوظة لديك

                // حساب النسبة الموزونة (نسبة رأس المال * نسبة الربح)
                $weightedProfitPercentage += ($platformCapital / $totalbalance) * $platformDailyPercentage;
            }
            // النتيجة هي النسبة الإجمالية الموزونة
            $totalDailyPercentage = $weightedProfitPercentage;
        } else {
            // في حال عدم وجود رأس مال (على سبيل المثال: جميع المنصات لها صفر)
            $totalDailyPercentage = 0;
        }


        return view('front.Plans.user_plans', compact('Plans', 'totalPlansCount', 'totalbalance', 'investment_earning', 'daily_earning', 'totalDailyPercentage'));
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
        try {
            $data = $request->all();
            $plan = Plan::findOrFail($data['plan_id']);
         //   $plan_step = $plan['step_price'];
           // $current_price = $plan['current_price'];

            $current_price = $data['total_price'];

           // $quantity = isset($data['quantity']) ? (int)$data['quantity'] : 1; // احصل على عدد الاشتراكات من الطلب، 1 كحد أدنى
            DB::beginTransaction();

//            for ($i = 0; $i < $quantity; $i++) {
                $orderId = uniqid();

                // إنشاء سجل جديد في جدول الفواتير لكل اشتراك
                Invoice::create([
                    'user_id' => Auth::id(),
                    'plan_id' => $plan['id'],
                    'plan_price' => $current_price,
                    'order_id' => $orderId,
                    'order_description' => "Payment for order #" . $orderId,
                    'payment_status' => 'confirmed',
                ]);

//                // تحديث السعر بعد كل اشتراك
//                $current_price += $plan_step;
//            }

            // تحديث سعر الخطة في النهاية
//            $plan->update([
//                'current_price' => $current_price
//            ]);

            DB::commit();

            return Redirect::route('user_plans')->with('success_message', ' تم الاشتراك بنجاح في الخطة ');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception_message($e);
        }
    }


    //////////////// انسحاب المستخدم من الخظة
    public function invoice_withdraw(Request $request)
    {
        try {
            $data = $request->all();
            $invoice_id = $data['invoice_id'];
            $invoice = Invoice::findOrFail($invoice_id);
            $invoice_price = $invoice['plan_price'];
            $plan_id = $invoice['plan_id'];
            $user_id = $invoice['user_id'];
            $plan_data = Plan::findOrFail($plan_id);
            $discount_percentage = $plan_data['withdraw_discount'];
            $user_data = User::findOrFail($user_id);
            // dd($user_data);
            $user_old_balance = $user_data['total_balance'];
            if ($discount_percentage > 0) {
                $total_discount = $invoice_price * ($discount_percentage / 100);
            } else {
                $total_discount = 0;
            }
            $invoice_after_discount = $invoice_price - $total_discount;
            $user_new_balance = $invoice_after_discount + $user_old_balance;
            DB::beginTransaction();
            $user_data->total_balance = $user_new_balance;
            $user_data->save();

            //////// Update Invoice Status
            ///
            $invoice->status = 3;
            $invoice->save();
            DB::commit();
            return $this->success_message('تم الانسحاب من الخطة بنجاح ');
        } catch (\Exception $e) {
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
