<?php

namespace App\Http\Controllers\front;

use App\Models\admin\Userstoragedailyinvestment;
use Illuminate\Http\Request;
use App\Models\Admin\WithDraw;
use App\Models\front\UserPlan;
use App\Models\front\SalesOrder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\front\StorageInvestment;
use App\Models\admin\UserPlatformEarning;
use App\Models\admin\Storagedailyinvestmentreturn;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalinvestments = UserPlan::where('user_id', $user->id)->sum('total_investment');
        /////// رصيد التداول
        $trading_balance = SalesOrder::where('user_id', $user->id)->where('status', 0)->sum('currency_amount');

        /////////// Need trading return percentage

        $trading_selling_currency_rate = SalesOrder::where('user_id', $user->id)->where('status', 0)->sum('selling_currency_rate');
        $trading_enter_currency_rate = SalesOrder::where('user_id', $user->id)->where('status', 0)->sum('enter_currency_rate');
        $return_all_percentage = ($trading_selling_currency_rate - $trading_enter_currency_rate) * 100;
        $profit_lose = $return_all_percentage * $trading_balance / 100;
        ////////////رصيد الاستثمار
        $storage_investment = StorageInvestment::where('user_id', $user->id)->where('status', 1)->sum('amount_invested');
        $daily_earning = UserPlatformEarning::where('user_id', $user->id)->sum('daily_earning');
        $daily_earning_percentage = UserPlatformEarning::where('user_id', $user->id)->sum('profit_percentage');

        ############################ Storage Investment Returns ########################
        ##### Daily Earning And Percentage
        ########### Get The Last Date
        $lastReturnDate = Userstoragedailyinvestment::where('user_id', $user->id)->max('return_date');
        ########## Total Earning In Last Day
        if ($lastReturnDate) {
            $storageTotalEarning = Userstoragedailyinvestment::where('user_id', $user->id)
                ->where('return_date', $lastReturnDate)
                ->sum('amount_return');
            ########## Total Percentage
            $storageTotalPercentage = Userstoragedailyinvestment::where('user_id', $user->id)
                ->where('return_date', $lastReturnDate)
                ->sum('profit_percentage');
        } else {
            $storageTotalEarning = 0;
            $storageTotalPercentage = 0;
        }
        return view('front.user.wallet', compact(
            'storage_investment',
            'trading_balance',
            'totalinvestments',
            'daily_earning',
            'daily_earning_percentage',
            'storageTotalEarning',
            'storageTotalPercentage',
            'return_all_percentage',
            'profit_lose'
        ));
    }
}
