<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\PublicSetting;
use App\Models\front\SalesOrder;
use App\Models\front\StorageInvestment;
use App\Models\front\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class StorageInvestmentController extends Controller
{
    use Message_Trait;

    public function index()
    {
        $storages = StorageInvestment::with('DailyInvestments')->where("user_id", Auth::user()->id)->get();
        return view('front.storage.index',compact('storages'));
    }

    public function store(Request $request)
    {
        // $user = Auth::user();
        $user = User::where('id', Auth::id())->first();
        $user_dollar_balance = $user->dollar_balance;
        $public_setting = PublicSetting::first();
        if (!$public_setting) {
            return $this->error_message('لا يوجد إعدادات عامة.');
        }

        try {
            $data = $request->all();
            $rules = [
                'duration' => 'required',
                'amount' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'interest_rate' => 'required',
            ];
            $messages = [
                'duration.required' => ' من فضلك حدد مدة الاستثمار  ',
                'amount.required' => ' من فضلك حدد مبلغ الاستثمار  ',
                'start_date.required' => ' يجب تحديد بداية التاريخ  ',
                'end_date.required' => ' يجب تحديد نهاية التاريخ  '
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            }

            // التحقق من رصيد المستخدم
            if ($data['amount'] > $user_dollar_balance) {
                return Redirect::back()->withErrors('رصيدك الحالي لا يسمح بإجراء هذه العملية.');
            }

            // تحديد نسبة الفائدة بناءً على المدة
            $interest_rate = $data['interest_rate'];

            // تحديد تاريخ البدء والانتهاء
            $start_date = $data['start_date'];
            $end_date = $data['end_date'];

            // حساب عدد العملات التي سيتم شراؤها
            $bin_amount = $data['amount'] / $public_setting->market_price;
            DB::beginTransaction();

            // شراء العملات
            $remaining_bin = $bin_amount;

            // شراء العملات من صفقات البيع السابقة
            $open_sales = SalesOrder::where('status', 0)
                ->where('selling_currency_rate', '<=', $public_setting->market_price)
                ->orderBy('selling_currency_rate', 'asc')
                ->get();

            foreach ($open_sales as $sale) {
                if ($remaining_bin <= 0) break;
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

            // تحقق إذا كانت الكمية المتبقية صفرًا بعد معالجة العمليات السابقة
            if ($remaining_bin <= 0) {
                DB::commit();
                return $this->success_message('تم تخزين العملة بنجاح دون الحاجة إلى الشراء من الشركة.');
            }

            // إذا كانت هناك عملات متبقية، نشتريها من الشركة
            if ($remaining_bin > 0) {
                if ($public_setting->currency_number < $remaining_bin) {
                    return $this->error_message('لا توجد عملات كافية لإتمام العملية.');
                }

                // خصم العملات من رصيد الشركة
                $public_setting->currency_number -= $remaining_bin;
                $public_setting->total_capital += $remaining_bin * $public_setting->market_price;
                $public_setting->save();

                // زيادة رصيد المستخدم
                $user->bin_balance += $remaining_bin;
                $user->dollar_balance -= $remaining_bin * $public_setting->market_price;
                $user->save();
            }

            // إنشاء عملية الاستثمار
            $investment = new StorageInvestment();
            $investment->user_id = $user->id;
            $investment->amount_invested = $data['amount'];
            $investment->interest_date = $data['duration'];
            $investment->interest_rate = $data['interest_rate'];
            $investment->bin_amount = $bin_amount;
            $investment->start_date = $data['start_date'];
            $investment->end_date = $data['end_date'];
            $investment->save();

            DB::commit();
            return $this->success_message('تم تخزين العملة بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception_message($e);
        }
    }
}
