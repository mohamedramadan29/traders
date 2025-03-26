<?php

namespace App\Http\Controllers\front;

use Exception;
use App\Models\front\User;
use Illuminate\Http\Request;
use App\Http\Traits\Message_Trait;
use App\Models\admin\CurrencyPlan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PlanInvestMent;
use App\Models\front\CurrencyPlanStep;
use Illuminate\Support\Facades\Redirect;
use App\Notifications\CurrencyInvestment;
use Illuminate\Support\Facades\Validator;
use App\Models\front\WithDrawCurrencyPlan;
use App\Models\admin\CurrencyPlanInvestment;
use Illuminate\Support\Facades\Notification;

class CurrencyInvestmentController extends Controller
{
    use Message_Trait;
    public function investment(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $user = User::where('id', Auth::id())->first();
        if (!$user) {
            return redirect()->back()->withErrors(['المستخدم غير موجود.']);
        }

        if (!isset($data['currency_price']) || $data['currency_price'] < 0.01) {
            return redirect()->back()->withErrors([' اقل مبلغ للاستثمار هو 0.01 ']);
        }

        if (!isset($data['currecny_plan_id'])) {
            return redirect()->back()->withErrors(['يرجى اختيار الخطة.']);
        }

        if ($user->dollar_balance < $data['currency_price']) {
            return redirect()->back()->withErrors(['رصيدك الحالي لا يكفي لإضافة الرصيد للخطة.']);
        }

       // dd($data);
        $currencyplan = CurrencyPlan::where('id', $data['currecny_plan_id'])->first();
        //dd($currencyplan);

        $currencyName = $currencyplan['name'];
        $currencyNumber = $currencyplan['curreny_number'];
        $currencyPrice = $currencyplan['currency_current_price'] != 0 ? $currencyplan['currency_current_price'] : $currencyplan['currency_main_price'];

        $userCurrencyNumber = $data['currency_price'] / $currencyPrice;




        if (!$user) {
            return Redirect::route('user_login');
        }
        $rules = [
            'currecny_plan_id' => 'required|integer',
            'currency_price' => 'required|numeric|min:0.01',
        ];
        $messages = [
            'currency_plan_id.required' => ' من فضلك حدد الخطة بشكل صحيح  ',
            'currecny_plan_id.integer' => ' من فضلك حدد خطة الاستثمار بشكل صحيح  ',
            'currency_price.required' => ' من فضلك ادخل مبلغ الاستثمار بشكل صحيح  ',
            'currency_price.numeric' => ' من فضلك مبلغ الاستثمار يجب ان يكون رقم صحيح  ',
            'currency_price.min' => '  مبلغ الاستثمار يجب ان يكون اكثر من 0.01 دولار ',
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator);
        }
        DB::beginTransaction();
        ########### First InsertInvestment ############
        ##### check If This User Hase Investment In this Plan Or Not
        $userinvestments = CurrencyPlanInvestment::where('user_id', Auth::id())->where('currency_plan', $data['currecny_plan_id'])->count();
        if ($userinvestments > 0) {
            $investment = CurrencyPlanInvestment::where('user_id', Auth::id())->where('currency_plan', $data['currecny_plan_id'])->first();
            $investment->total_investment = $investment['total_investment'] + $data['currency_price'];
            $investment->currency_number = $investment['currency_number'] + $userCurrencyNumber;
            $investment->currency_price = $currencyPrice;
            $investment->save();
        } else {
            $investment = new CurrencyPlanInvestment();
            $investment->currency_plan = $data['currecny_plan_id'];
            $investment->user_id = Auth::id();
            $investment->total_investment = $data['currency_price'];
            $investment->currency_number = $userCurrencyNumber;
            $investment->currency_price = $currencyPrice;
            $investment->save();
        }

        ########### Update Currency Data #############
        $currencyplan->curreny_number = $currencyNumber - $userCurrencyNumber;
        $currencyplan->current_investments = $currencyplan->current_investments + $data['currency_price'];
        $currencyplan->currency_current_price = ($currencyplan->current_investments + $currencyplan->main_investment) / max($currencyplan->main_investment, 1);
        $currencyplan->save();
        ############# Update User Data ###############
        $user->dollar_balance = $user->dollar_balance - $data['currency_price'];
        $user->save();
        ################### Add Currency Step To Currency Plan Steps #####################################
        $currencyStep = new CurrencyPlanStep();
        $currencyStep->currency_plan_id = $data['currecny_plan_id'];
        $currencyStep->currency_price = ($currencyplan->current_investments + $currencyplan->main_investment) / max($currencyplan->main_investment, 1);
        $currencyStep->user_id = Auth::id();
        $currencyStep->save();
        ############################# Send Mail  To User And DB Notification  ############################
        // Notification::send($user, new CurrencyInvestment($user, $user->id, $data['currecny_plan_id'], $currencyName, $data['currency_price'], $userCurrencyNumber));
        DB::commit();
        return $this->success_message('تم انشاء الاستثمار في العملة بنجاح');
    }

    ################ WithDraw Currency Plan Proft ###################

    public function withdraw_currency_profit(Request $request)
    {
        try {
            $data = $request->all();
            //  dd($data);
            $currencyPlan = CurrencyPlan::where('id', $data['currency_plan_id'])->first();
            $user = User::where('id', Auth::id())->first();
            if (!$user) {
                return Redirect::route('user_login');
            }
            ######### Get The User Investments And Get Profit
            $currencyInvestments = CurrencyPlanInvestment::where('currency_plan', $currencyPlan['id'])->where('user_id', Auth::id())->first();
            //dd($currencyInvestments);
            ############ Get All WithDraw In this Plan
            $TotalDraw = WithDrawCurrencyPlan::where('currency_plan', $currencyPlan['id'])->where('user_id', Auth::id())->sum('amount');
            // dd($TotalDraw);
            $total_profit =
                ($currencyInvestments['currency_number'] * $currencyPlan['currency_current_price']) - ($currencyInvestments['total_investment'] + $TotalDraw);
            //dd($total_profit);
            DB::beginTransaction();
            ######### Transfer Total Profit To User Dollar Balance
            $user->dollar_balance = $user->dollar_balance + $total_profit;
            $user->save();
            ########### Add WithDraw Statment To Withdraw Table

            $withdraw = new WithDrawCurrencyPlan();
            $withdraw->currency_plan = $currencyPlan['id'];
            $withdraw->user_id = Auth::id();
            $withdraw->amount = $total_profit;
            $withdraw->status = 1;
            $withdraw->save();
            DB::commit();
            return $this->success_message(' تم نقل الارباح الخاصة بك بنجاح  ');
        } catch (Exception $e) {
            return $this->exception_message($e);
        }
    }
}
