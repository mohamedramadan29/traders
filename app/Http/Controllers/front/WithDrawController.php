<?php

namespace App\Http\Controllers\front;

use App\Models\front\User;
use Illuminate\Http\Request;
use App\Models\Admin\WithDraw;
use App\Models\front\UserPlan;
use App\Models\front\SalesOrder;
use App\Http\Traits\Message_Trait;
use Illuminate\Support\Facades\DB;
use App\Models\admin\PublicSetting;
use App\Http\Controllers\Controller;
use App\Models\front\StorageInvestment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class WithDrawController extends Controller
{
    use Message_Trait;
    public function store(Request $request)
    {
        // dd($request->all());
        // $user = Auth::user();


        $user = User::where('id', Auth::id())->first();
        $total_balance = $user['dollar_balance'];

        // إجمالي السحب المكتمل والمعلق
        $withdrawSumCompeleted = WithDraw::where('user_id', Auth::id())->where('status', 1)->sum('amount');
        $withdrawSumPending = WithDraw::where('user_id', Auth::id())->where('status', 0)->sum('amount');

        $last_total_balance = $total_balance - $withdrawSumPending;

        try {
            // التحقق من البيانات المدخلة
            $data = $request->all();
            $rules = [
                'amount' => 'required|numeric|min:1',
                'withdraw_method' => 'required',
                'usdt_link' => 'required',
            ];

            $messages = [
                'amount.required' => 'من فضلك حدد المبلغ',
                'amount.numeric' => 'المبلغ يجب أن يكون رقمًا صحيحًا',
                'amount.min' => 'المبلغ يجب أن يكون أكبر من صفر',
                'withdraw_method.required' => 'من فضلك حدد طريقة السحب',
                'usdt_link.required' => 'من فضلك أدخل عنوان المحفظة',
            ];

            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }

            if ($last_total_balance < $data['amount']) {
                return Redirect::back()->withInput()->withErrors('رصيدك الحالي لا يكفي لإجراء طلب السحب.');
            }

            ####### Check If Request Amount Is Less Than 10 $
            if ($data['amount'] < 10) {
                return Redirect::back()->withInput()->withErrors('المبلغ المدخل يجب ان يكون على الاقل 10 دولار');
            }

            DB::beginTransaction();

            // إنشاء طلب سحب
            $withdraw = new WithDraw();
            $withdraw->user_id = Auth::id();
            $withdraw->amount = $data['amount'];
            $withdraw->withdraw_method = $data['withdraw_method'];
            $withdraw->usdt_link = $data['usdt_link'];
            $withdraw->save();

            // تحديث رصيد العملات الرقمية
            $user->dollar_balance = $last_total_balance;
            $user->Save();
            DB::commit();
            return $this->success_message('تم إضافة طلب السحب بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception_message($e);
        }
    }


    public function delete($id)
    {
        $withdraw = WithDraw::findOrFail($id);
        if ($withdraw['status'] == 1) {
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
