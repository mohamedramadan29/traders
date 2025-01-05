<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\admin\Storageplan;
use App\Http\Traits\Message_Trait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\admin\Storagedailyinvestmentreturn;
use App\Models\admin\UserDailyInvestmentReturn;
use App\Models\admin\Userstoragedailyinvestment;
use App\Models\front\StorageInvestment;
use App\Models\front\User;
use Storage;

class StoragePlanController extends Controller
{
    use Message_Trait;
    public function index()
    {
        $storageplans = Storageplan::all();
        return view('admin.StorageReturn.plans', compact('storageplans'));
    }
    public function StorageDailyReturn(Request $request, $plan_id)
    {

        $plan = Storageplan::find($plan_id);
        $dailyreturns = Storagedailyinvestmentreturn::where('storage_plan', $plan_id)->get();
        ############### Need Get TotalInvestment Storage In This Plan Storage #############
        $total_invetsment_count = StorageInvestment::where('interest_date', $plan['days'])->where('status', 1)->count();

        $total_invetsment = StorageInvestment::where('interest_date', $plan['days'])->where('status', 1)->sum('amount_invested');
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [
                'return_profit' => 'required'
            ];
            $messages = [
                'return_profit.required' => ' من فضلك ادخل العائد اليومي '
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }
            if ($total_invetsment_count < 1) {
                return Redirect()->back()->withErrors(' لا يوجد استثمارات بعد في هذة الخطة ');
            }
            ############### Start Add Storgae Profit ################
            DB::BeginTransaction();
            $storage_return = new Storagedailyinvestmentreturn();
            $storage_return->storage_plan = $plan_id;
            $storage_return->daily_return_percentage = $data['return_profit'];
            $storage_return->return_date = date('Y-m-d');
            $storage_return->total_dollar_amount = $total_invetsment * $data['return_profit'];
            $storage_return->save();
            ################### Insert User Daily Return In Storage Plan ################
            $total_investments = StorageInvestment::where('interest_date', $plan['days'])->where('status', 1)->get();
            foreach ($total_investments as $investment_return) {
                $userstoragedailyinvestment = new Userstoragedailyinvestment();
                $userstoragedailyinvestment->create([
                    'user_id' => $investment_return->user_id,
                    'sotrage_plan' => $plan_id,
                    'storage_days' => $plan['days'],
                    'investment_id' => $investment_return->id,
                    'profit_percentage' => $data['return_profit'],
                    'amount_return' => $data['return_profit'] * $investment_return->amount_invested,
                    'return_date' => date('Y-m-d')
                ]);
                ######################## Increase User Dollar Balance ###########################
                $user = User::where('id', $investment_return->user_id)->first();
                $user_old_balance = $user['dollar_balance'];
                $user_new_balance = $user_old_balance + ($data['return_profit'] * $investment_return->amount_invested);
                $user->dollar_balance = $user_new_balance;
                $user->save();
            }
            ################### Increase Total Investment In This Storage Plan ################
            $plan_old_total_investment = $plan['total_amount_return'];
            $plan_new_total_investment = $plan_old_total_investment + ($total_invetsment * $data['return_profit']);
            $plan->total_amount_return = $plan_new_total_investment;
            $plan->save();

            DB::commit();
            return $this->success_message(' تم اضافة العائد اليومي بنجاح  ');
        }
        return view('admin.StorageReturn.StorageDailyReturn', compact('plan', 'dailyreturns', 'total_invetsment'));
    }

}
