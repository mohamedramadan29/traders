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
        ////// Get User Dollar Balance
        $user_dollar_balance = $user['dollar_balance'];
        $user_bin_balance = $user['bin_balance'];
        $public_setting = PublicSetting::first();
        if (!$public_setting) {
            return $this->error_message('لا يوجد إعدادات عامة.');
        }
        $market_price = $public_setting['market_price']; /// سعر السوق
        $total_capital = $public_setting['total_capital']; // راس المال الكلي
        $currency_number = $public_setting['currency_number']; // عدد العملات للشزكة
        try {
            $data = $request->all();
            if (!isset($data['deal_amount']) || $data['deal_amount'] <= 0) {
                return $this->error_message('الرجاء إدخال مبلغ الصفقة بشكل صحيح.');
            }
            if ($data['deal_amount'] > $user_dollar_balance) {
                return Redirect::back()->withErrors('رصيدك الحالي لا يسمح بدخول الصفقة اشحن رصيدك !!');
            }

            DB::beginTransaction();
            /////////// Get The User Get Bin Amount
            /// عدد العملات ال المستخدم هيحصل عليها مقابل مبلغ دخول الصفقة
            $bin_amount = $data['deal_amount'] / $market_price;
            // البحث عن صفقات قديمة بسعر يطابق سعر السوق الحالي وتحديث حالتها إلى "sold"
            ////// البحث عن الصفقات المفتوحة وترتيبها حسب أقل سعر ثم الأقدم
            $open_sales = SalesOrder::where('status', 0) // الصفقات المفتوحة
            ->where('selling_currency_rate', '<=', $market_price) // سعر البيع يطابق أو أقل من سعر السوق
            ->orderBy('selling_currency_rate', 'asc') // ترتيب حسب أقل سعر للبيع
            ->orderBy('created_at', 'asc') // ترتيب حسب الأقدمية
            ->get();

            // dd($open_sales);
            $remaining_bin = $bin_amount; // العملات المتبقية للشراء
            ////// معالجة الصفقات
            foreach ($open_sales as $sale) {
                $available_bin = $sale->bin_amount - $sale->bin_sold; // العملات المتاحة للشراء من الصفقة
                if ($remaining_bin <= 0) break; // إذا تم شراء الكمية المطلوبة

                if ($available_bin >= $remaining_bin) {
                    // تحديث الصفقة (تمت عملية الشراء بالكامل)
                    $sale->bin_sold += $remaining_bin;
                    if ($sale->bin_sold == $sale->bin_amount) {
                        $sale->status = 1; // تحديث الحالة إلى مكتملة
                    }
                    $sale->received_user_id = Auth::id();
                    $sale->save();

                    // حساب ربح البائع
                    if ($sale->user_id !== Auth::id()) { // إذا لم يكن البائع هو المستخدم الحالي
                        $seller = User::find($sale->user_id); // جلب بيانات البائع
                      //  $profit = ($sale->selling_currency_rate - $market_price) * $remaining_bin; // ربح البائع
                        $profit = round(($sale->selling_currency_rate - $market_price) * $remaining_bin, 2);
                       // $seller->dollar_balance += $profit; // إضافة الربح إلى رصيد البائع
                        $seller->dollar_balance = round($seller->dollar_balance + $profit, 2);
                        $seller->save();
                    }

                    // تحديث رصيد المستخدم (المشتري)
                    $user->bin_balance += $remaining_bin; // زيادة رصيد العملات
                    $user->dollar_balance -= $remaining_bin * $market_price; // خصم المبلغ بالدولار
                    $user->save();

                    $remaining_bin = 0; // تم شراء الكمية بالكامل
                } else {
                    // تحديث الصفقة (شراء جزئي)
                    $sale->bin_sold += $available_bin;
                    $sale->status = 1; // حالة مكتملة لأن جميع العملات المتاحة تم بيعها
                    $sale->received_user_id = Auth::id();
                    $sale->save();

                    // حساب ربح البائع
                    if ($sale->user_id !== Auth::id()) { // إذا لم يكن البائع هو المستخدم الحالي
                        $seller = User::find($sale->user_id); // جلب بيانات البائع
                        //$profit = ($sale->selling_currency_rate - $market_price) * $available_bin; // ربح البائع
                        $profit = round(($sale->selling_currency_rate - $market_price) * $remaining_bin, 2);
                        //$seller->dollar_balance += $profit; // إضافة الربح إلى رصيد البائع
                        $seller->dollar_balance = round($seller->dollar_balance + $profit, 2);
                        $seller->save();
                    }
                    // تحديث رصيد المستخدم (المشتري)
                    $user->bin_balance += $available_bin; // زيادة رصيد العملات
                    $user->dollar_balance -= $available_bin * $market_price; // خصم المبلغ بالدولار
                    $user->save();
                    $remaining_bin -= $available_bin; // تقليل العملات المتبقية للشراء
                }
            }
            ////// شراء العملات المتبقية من الشركة
            if ($remaining_bin > 0) {
                if ($currency_number < $remaining_bin) {
                    return $this->error_message('لا توجد عملات كافية لإتمام الصفقة.');
                }
                // خصم العملات من الشركة
                $public_setting->currency_number -= $remaining_bin;
                $public_setting->total_capital += $remaining_bin * $market_price; // زيادة رأس المال بالدولار
                $public_setting->save();
                // تحديث رصيد المستخدم (المشتري)
                $user->bin_balance += $remaining_bin; // زيادة رصيد العملات
                $user->dollar_balance -= $remaining_bin * $market_price; // خصم المبلغ بالدولار
                $user->save();
                $remaining_bin = 0; // تم شراء الكمية بالكامل
            }
            ////// التحقق من اكتمال العملية
            if ($remaining_bin > 0) {
                return $this->error_message('لم يتم شراء الكمية المطلوبة بالكامل بسبب نقص العملات.');
            }
            // الآن يتم إنشاء الصفقة الجديدة للمستخدم الحالي
            $sales = new SalesOrder();
            $sales->user_id = Auth::id();
            $sales->currency_rate = $market_price;
            $sales->enter_currency_rate = $market_price;
            $sales->selling_currency_rate = $data['selling_currency_rate'];
            $sales->currency_amount = $data['deal_amount'];
            $sales->bin_amount = $bin_amount;
            $sales->bin_sold = 0;
            $sales->save();

            // تحديث رأس المال وسعر السوق بعد إضافة الصفقة الجديدة
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
            /////////// Update User Data
            ///
            $new_user_dollar_balance = $user_dollar_balance - $data['deal_amount'];
            $new_user_bin_balance = $user_bin_balance + $bin_amount;

            $user->dollar_balance = $new_user_dollar_balance;
            $user->bin_balance = $new_user_bin_balance;
            $user->save();

            DB::commit();
            return $this->success_message('تم دخول الصفقة بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception_message($e);
        }
    }


}


