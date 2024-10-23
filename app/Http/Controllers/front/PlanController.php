<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\Plan;
use App\Models\admin\Platform;
use App\Models\front\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PlanController extends Controller
{
    use Message_Trait;

    public function plans()
    {
        $plans = Plan::where('status', 1)->get();
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
       // dd($platforms);

        return view('front.Plans.user_plans', compact('platforms','totalPlansCount'));
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
                'platform_id'=>$platform_id,
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
