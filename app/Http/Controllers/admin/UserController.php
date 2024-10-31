<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\UserDailyInvestmentReturn;
use App\Models\admin\UserPlatformEarning;
use App\Models\front\Invoice;
use App\Models\front\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use Message_Trait;

    public function index()
    {
        $users = User::all();
        return view('admin.users.index',compact('users'));
    }

    public function report($id)
    {
        $user = User::findORFail($id);

        $invoices = Invoice::with('plan')->where('user_id',$id)->get();
        $invoice_count = count($invoices);
        $invoice_count_active = count(Invoice::where('user_id',$id)->where('status',1)->get());
        $user_daily_invests = UserDailyInvestmentReturn::where('user_id',$id)->with('plan')->get();
        $user_investment_return_from_plan = UserPlatformEarning::with('plan_invest')->where('user_id',$id)->get();
        $total_investment = UserPlatformEarning::where('user_id',$id)->sum('investment_return');

        return view('admin.users.report',compact('user','invoices','invoice_count','invoice_count_active','user_daily_invests','total_investment','user_investment_return_from_plan'));

    }
}
