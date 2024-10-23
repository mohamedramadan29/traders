<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\Plan;
use App\Models\admin\Platform;
use App\Models\admin\UserPlatformEarning;
use App\Models\front\Invoice;
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
        $platforms = Platform::withCount(['invoices' => function ($query) use ($user) {
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


        return view('front.Plans.user_plans', compact('platforms', 'totalPlansCount', 'totalbalance', 'investment_earning', 'daily_earning','totalDailyPercentage'));
    }

    public function platformPlans($platform_id)
    {
        $user = Auth::user();
        $plans = Invoice::with('plan')
            ->where('user_id', $user->id)
            ->where('platform_id', $platform_id)
            ->get();

        return view('front.Plans.platform_plans', compact('plans'));
    }

    public function invoice_create(Request $request)
    {
        try {
            $data = $request->all();
            $plan = Plan::findOrFail($data['plan_id']);
            // dd($plan['platform_id']);
            $plan_step = $plan['step_price'];
            $current_price = $plan['current_price'];
            $platform_id = $plan['platform_id'];

            //$invoice = new Invoice();
            DB::beginTransaction();
            $orderId = uniqid();
            Invoice::create([
                'user_id' => Auth::id(), // ID المستخدم الحالي
                // 'transaction_id' => Invoice::max('id') + 1, // يمكنك استخدام رقم الفاتورة وزيادته بمقدار 1
                'plan_id' => $plan['id'], // ID الخطة
                'platform_id' => $platform_id,
                'plan_price' => $current_price, // السعر
                'order_id' => $orderId, // ID الطلب
                'order_description' => "Payment for order #" . $orderId, // وصف الطلب
                'payment_status' => 'confirmed', // حالة الدفع مبدئيًا
            ]);
            $new_plan_price = $current_price + $plan_step;
            $plan->update([
                'current_price' => $new_plan_price
            ]);
            DB::commit();
            return Redirect::route('user_plans')->with('success_message', ' تم الاشتراك بنجاح في الخطة  ');

            // return Redirect::route('user/user_plans')->with('success_message', 'تم الاشتراك بنجاح في الخطة');

        } catch (\Exception $e) {
            return $this->exception_message($e);
        }
    }
}
