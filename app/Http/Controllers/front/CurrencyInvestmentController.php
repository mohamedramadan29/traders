<?php

namespace App\Http\Controllers\front;

use App\Models\admin\CurrencyPlan;
use App\Models\front\User;
use Illuminate\Http\Request;
use App\Http\Traits\Message_Trait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\admin\CurrencyPlanInvestment;

class CurrencyInvestmentController extends Controller
{
    use Message_Trait;


    public function investment(Request $request)
    {
        $data = $request->all();
        $currencyplan = CurrencyPlan::where('id', $data['currecny_plan_id'])->first();
        $currencyNumber = $currencyplan['curreny_number'];
        $currencyPrice = $currencyplan['currency_current_price'] != 0 ? $currencyplan['currency_current_price'] : $currencyplan['currency_main_price'];

        $userCurrencyNumber = $data['currency_price'] / $currencyPrice;

        $user = User::where('id', Auth::id())->first();
        if (!$user) {
            return Redirect::route('user_login');
        }
        $rules = [
            'currecny_plan_id' => 'required|integer',
            'currency_price' => 'required|numeric|min:10',
        ];
        $messages = [
            'currency_plan_id.required' => ' من فضلك حدد الخطة بشكل صحيح  ',
            'currecny_plan_id.integer' => ' من فضلك حدد خطة الاستثمار بشكل صحيح  ',
            'currency_price.required' => ' من فضلك ادخل مبلغ الاستثمار بشكل صحيح  ',
            'currency_price.numeric' => ' من فضلك مبلغ الاستثمار يجب ان يكون رقم صحيح  ',
            'currency_price.min' => '  مبلغ الاستثمار يجب ان يكون اكثر من 10 دولار ',
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
        $currencyplan->currency_current_price = ($currencyplan->current_investments + $data['currency_price'] + $currencyplan->main_investment) / $currencyplan->curreny_number;
        $currencyplan->save();
        ############# Update User Data ###############
        $user->dollar_balance = $user->dollar_balance - $data['currency_price'];
        $user->save();
        ############################# Send Mail  To User And DB Notification  ############################

        DB::commit();
        return $this->success_message('تم انشاء الاستثمار في العملة بنجاح');
    }
}
