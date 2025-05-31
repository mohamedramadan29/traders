<?php
namespace App\Http\Controllers\front;


use App\Http\Controllers\Controller;
use App\Models\front\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\front\ReferalWithdraw;

class ReferalWithDrawController extends Controller
{
    public function ReferalWithdraw(Request $request){
        $data = $request->all();
        $amount = $data['amount'];
        $user = User::where('id',Auth::id())->first();
        //dd($user);

        $referrals = $user->referrals;

        if ($referrals->count() > 0){
            $alldeposit = 0;
            $allinvestment = 0;
            $allyouprofit = 0;
            $allprofit = 0;

        foreach ($referrals as $referral){
            $alldeposit += $referral->Transactions()->sum('price_amount');
            $allinvestment += $referral->CurrencyInvestments()->sum('total_investment');


        if ($referral->CurrencyInvestments()->count() > 0){
            foreach ($referral->CurrencyInvestments() as $currencyplan){
                $allprofitforplan =
                    $currencyplan['currency_number'] * $currencyplan->CurrencyPlan['currency_current_price'] -
                            $currencyplan['total_investment'];
                        $allprofit += $allprofitforplan;
                        $allyouprofit += ($allprofitforplan * 0.05) / 2;
                    }
        }
    }
      //  dd($allprofit);
    }else{
        return redirect()->back()->with('Error_Message', 'لا يوجد اعضاء في الفريق');
    }
      ### Get The Old Sum Referals WithDraws
      $oldsum = $user->ReferalWithdraws->sum('amount');
      $newallyouprofit = $allyouprofit - $oldsum;
    if ($amount > $newallyouprofit){
        return redirect()->back()->with('Error_Message', ' لا يمكن اتمام عملية السحب  ');
    }
    $referalWithdraw = new ReferalWithdraw();
    $referalWithdraw->user_id = $user->id;
    $referalWithdraw->amount = $amount;
    $referalWithdraw->save();

    ######## Add Balance To User

    $user->dollar_balance += $amount;
    $user->save();
    return redirect()->back()->with('Success_Message', 'تم اتمام عملية السحب بنجاح');

      //  dd($data);
    }
}
