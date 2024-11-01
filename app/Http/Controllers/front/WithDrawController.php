<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\Admin\WithDraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class WithDrawController extends Controller
{
    use Message_Trait;

    public function index()
    {
        $user = Auth::user();
        $total_balance = $user['total_balance'];
        $withdraws = WithDraw::where('user_id',Auth::id())->orderBy('id','desc')->get();
        // WithDrawSum Under Revision
        $withdrawSum = WithDraw::where('user_id',Auth::id())->where('status',0)->sum('amount');
        ////// WithDrawSum Compeleted
        $withdrawSumCompeleted = WithDraw::where('user_id',Auth::id())->where('status',1)->sum('amount');
        return view('front.WithDraws.index',compact('withdraws','total_balance','withdrawSum','withdrawSumCompeleted'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $total_balance = $user['total_balance'];

        ////// WithDrawSum Compeleted
        $withdrawSumCompeleted = WithDraw::where('user_id',Auth::id())->where('status',1)->sum('amount');
        $withdrawSumPending = WithDraw::where('user_id',Auth::id())->where('status',0)->sum('amount');
        //dd($withdrawSumPending);
        $last_total_balance = $total_balance - ($withdrawSumPending + $withdrawSumCompeleted);
        try {
            $data = $request->all();
            $rules = [
                'amount' => 'required',
                'withdraw_method' => 'required',
                'usdt_link'=>'required'
            ];
            $messages = [
                'amount.required' => ' من فضلك حدد المبلغ ',
                'withdraw_method.required' => ' من فضلك حدد طريقة السحب ',
                'usdt_link.required'=>' من فضلك ادخل عنوان المحفظة  '
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            if ($last_total_balance < $data['amount']) {
                return Redirect::back()->withInput()->withErrors('رصيدك الحالي لا يكفي لاجراء طلب السحب ');
            }

            DB::beginTransaction();
            $withdraw = new WithDraw();
            $withdraw->user_id = Auth::id();
            $withdraw->amount = $data['amount'];
            $withdraw->withdraw_method = $data['withdraw_method'];
            $withdraw->usdt_link = $data['usdt_link'];
            $withdraw->save();
            DB::commit();
            return $this->success_message(' تم اضافة طلب سحب بنجاح  ');

        } catch (\Exception $e) {
            return $this->exception_message($e);
        }
    }

    public function delete($id)
    {
        $withdraw = WithDraw::findOrFail($id);
        if ($withdraw['status'] == 1){
            return Redirect::back()->withInput()->withErrors(' لا يمكن حذف تلك العملية  ');
        }
        /////////// Update User Balance
//        $withdraw_amount = $withdraw['amount'];
//        $user = Auth::user();
//        $main_balance = $user['total_balance'] + $withdraw_amount;
//        $user->total_balance = $main_balance;
//        $user->save();
        $withdraw->delete();
        return $this->success_message(' تم حذف طلب السحب   ');
    }
}
