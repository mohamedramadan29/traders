<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\Plan;
use App\Models\admin\Platform;
use App\Models\admin\PublicSetting;
use App\Models\admin\UserPlatformEarning;
use App\Models\front\Invoice;
use App\Models\front\SalesOrder;
use App\Models\front\User;
use App\Models\front\UserPlan;
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

        $Plans = UserPlan::where('user_id', Auth::id())->with('plan')->get();
        // dd($Plans);
        $investment_earning = UserPlatformEarning::where('user_id', $user->id)->sum('investment_return');
        $daily_earning = UserPlatformEarning::where('user_id', $user->id)->sum('daily_earning');
        $totalbalance = UserPlan::where('user_id', $user->id)->sum('total_investment');
        $Plans = $Plans->map(function ($plan) {
            $plan->plan_profit = UserPlatformEarning::where('user_id', Auth::id())
                ->where('plan_id', $plan['plan']->id)->sum('investment_return');
            return $plan;
        });
        return view('front.Plans.user_plans', compact('Plans', 'totalbalance', 'investment_earning', 'daily_earning'));
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

                $public_setting->currency_number -= $remaining_bin;
                $public_setting->total_capital += $remaining_bin * $market_price;
                $public_setting->save();

                $user->bin_balance += $remaining_bin;
                $user->dollar_balance -= $remaining_bin * $market_price;
                $user->save();
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

            DB::commit();

            return redirect()->route('user_plans')->with('success_message', 'تم الاشتراك بنجاح في الخطة.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ: ' . $e->getMessage());
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
