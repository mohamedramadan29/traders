<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\front\User;
use App\Models\front\UserStatment;
use App\Notifications\ChargeBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserBalanceController extends Controller
{
    use Message_Trait;

    public function deposit(Request $request)
    {
        $user = User::where('id', Auth::id())->first();
        if ($user) {
            try {
                $data = $request->all();
                $rules = [
                    'deposit' => 'required|numeric|min:1'
                ];
                $messages = [
                    'deposit.required' => ' من فضلك ادخل المبلغ  ',
                    'deposit.numeric' => ' من فضلك ادخل المبلغ بشكل صحيح ',
                    'deposit.min' => ' اقل مبلغ ايداع هو 1 دولار '
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                }
                //////////// Insert Balance To User Account
                $user_balance = $user['dollar_balance'];
                $new_balance = $user_balance + $data['deposit'];
                DB::beginTransaction();
                $user->dollar_balance = $new_balance;
                $user->save();
                /////////// Add New User Transaction
                ///
                $statement = new UserStatment();
                $statement->user_id = Auth::id();
                $statement->transaction_type = 'deposit';
                $statement->amount = $data['deposit'];
                $statement->save();
                ################### Send Notification To User ###########################
                Notification::send($user, new ChargeBalance($user, Auth::id(), $data['deposit'], date('Y-m-d H:i:s')));
                DB::commit();
                return $this->success_message(' تم ايداع المبلغ بنجاح  ');
            } catch (\Exception $e) {
                return $this->exception_message($e);
            }
        }
        abort(404);
    }

}
