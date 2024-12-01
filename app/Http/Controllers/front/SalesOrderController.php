<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\PublicSetting;
use App\Models\front\SalesOrder;
use App\Models\front\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SalesOrderController extends Controller
{
    use Message_Trait;

    public function create(Request $request)
    {
        $user = User::where('id', Auth::id())->first();
        $user_dollar_balance = $user['dollar_balance'];
        $user_bin_balance = $user['bin_balance'];
        $public_setting = PublicSetting::first();
        if (!$public_setting) {
            return $this->error_message('لا يوجد إعدادات عامة.');
        }
        $market_price = $public_setting['market_price'];
        $total_capital = $public_setting['total_capital'];
        $currency_number = $public_setting['currency_number'];

        try {
            $data = $request->all();
            if (!isset($data['deal_amount']) || $data['deal_amount'] <= 0) {
                return $this->error_message('الرجاء إدخال مبلغ الصفقة بشكل صحيح.');
            }
            if ($data['deal_amount'] > $user_dollar_balance) {
                return Redirect::back()->withErrors('رصيدك الحالي لا يسمح بدخول الصفقة، اشحن رصيدك!');
            }

            DB::beginTransaction();
            $bin_amount = $data['deal_amount'] / $market_price;
            $open_sales = SalesOrder::where('status', 0)
                ->where('selling_currency_rate', '<=', $market_price)
                ->orderBy('selling_currency_rate', 'asc')
                ->orderBy('created_at', 'asc')
                ->get();

            $remaining_bin = $bin_amount;

            foreach ($open_sales as $sale) {
                $available_bin = $sale->bin_amount - $sale->bin_sold;
                if ($remaining_bin <= 0) break;

                if ($available_bin >= $remaining_bin) {
                    $sale->bin_sold += $remaining_bin;
                    if ($sale->bin_sold == $sale->bin_amount) {
                        $sale->status = 1;
                    }
                    $sale->received_user_id = Auth::id();
                    $sale->save();

                    if ($sale->user_id !== Auth::id()) {
                        $seller = User::find($sale->user_id);
                        $profit = round(($sale->selling_currency_rate - $market_price) * $remaining_bin, 2);
                        $seller->dollar_balance = round($seller->dollar_balance + $profit, 2);
                        $seller->save();
                    }

                    $user->bin_balance += $remaining_bin;
                    $user->dollar_balance -= $remaining_bin * $market_price;
                    $user->save();

                    $remaining_bin = 0;
                } else {
                    $sale->bin_sold += $available_bin;
                    $sale->status = 1;
                    $sale->received_user_id = Auth::id();
                    $sale->save();

                    if ($sale->user_id !== Auth::id()) {
                        $seller = User::find($sale->user_id);
                        $profit = round(($sale->selling_currency_rate - $market_price) * $available_bin, 2);
                        $seller->dollar_balance = round($seller->dollar_balance + $profit, 2);
                        $seller->save();
                    }

                    $user->bin_balance += $available_bin;
                    $user->dollar_balance -= $available_bin * $market_price;
                    $user->save();

                    $remaining_bin -= $available_bin;
                }
            }

            // التحقق من اكتمال الشراء بالكامل قبل الشراء من الشركة
            if ($remaining_bin > 0) {
                if ($currency_number < $remaining_bin) {
                    return $this->error_message('لا توجد عملات كافية لإتمام الصفقة.');
                }

                $public_setting->currency_number -= $remaining_bin;
                $public_setting->total_capital += $remaining_bin * $market_price;
                $public_setting->save();

                $user->bin_balance += $remaining_bin;
                $user->dollar_balance -= $remaining_bin * $market_price;
                $user->save();

                $remaining_bin = 0;
            }

            if ($remaining_bin > 0) {
                return $this->error_message('لم يتم شراء الكمية المطلوبة بالكامل بسبب نقص العملات.');
            }

            $sales = new SalesOrder();
            $sales->user_id = Auth::id();
            $sales->currency_rate = $market_price;
            $sales->enter_currency_rate = $market_price;
            $sales->selling_currency_rate = $data['selling_currency_rate'];
            $sales->currency_amount = $data['deal_amount'];
            $sales->bin_amount = $bin_amount;
            $sales->bin_sold = 0;
            $sales->save();

            $new_total_capital = $total_capital + $data['deal_amount'];
            $new_currency_number = $currency_number - $bin_amount;
            $new_market_price = $new_total_capital / $currency_number;

            $public_setting->total_capital = $new_total_capital;
            $public_setting->market_price = $new_market_price;
            $public_setting->currency_number = $new_currency_number;

            if (!$public_setting->save()) {
                DB::rollBack();
                return $this->error_message('فشل في تحديث سعر السوق.');
            }

            $user->save();
            DB::commit();

            return $this->success_message('تم دخول الصفقة بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception_message($e);
        }
    }

}
