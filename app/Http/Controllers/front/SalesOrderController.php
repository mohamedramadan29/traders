<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\PublicSetting;
use App\Models\front\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesOrderController extends Controller
{
    use Message_Trait;

    public function create(Request $request)
    {
        $public_setting = PublicSetting::first();
        if (!$public_setting) {
            return $this->error_message('لا يوجد إعدادات عامة.');
        }

        $market_price = $public_setting['market_price'];
        $total_capital = $public_setting['total_capital'];
        $currency_number = $public_setting['currency_number'];

        try {
            $data = $request->all();

            if (!isset($data['currency_amount']) || $data['currency_amount'] <= 0) {
                return $this->error_message('الرجاء إدخال مبلغ الصفقة بشكل صحيح.');
            }

            DB::beginTransaction();

            // البحث عن صفقات قديمة بسعر يطابق سعر السوق الحالي وتحديث حالتها إلى "sold"
            $existing_sales = SalesOrder::where('selling_currency_rate', $market_price)
                ->where('status', 0) // تأكد من أن الحالة هي "pending" للصفقات التي لم تُباع بعد
                ->get();

            foreach ($existing_sales as $sale) {
                $sale->status = 1; // تحديث الحالة إلى "sold" (مباعة)
                $sale->received_user_id = Auth::id(); // حفظ المستخدم الذي قام بالشراء
                $sale->save();
            }

            // الآن يتم إنشاء الصفقة الجديدة للمستخدم الحالي
            $sales = new SalesOrder();
            $sales->user_id = Auth::id();
            $sales->currency_rate = $market_price;
            $sales->enter_currency_rate = $market_price;
            $sales->selling_currency_rate = $data['selling_currency_rate'];
            $sales->currency_amount = $data['currency_amount'];
            $sales->save();

            // تحديث رأس المال وسعر السوق بعد إضافة الصفقة الجديدة
            $new_total_capital = $total_capital + $data['currency_amount'];
            $new_market_price = $new_total_capital / $currency_number;

            $public_setting->total_capital = $new_total_capital;
            $public_setting->market_price = $new_market_price;

            if (!$public_setting->save()) {
                DB::rollBack();
                return $this->error_message('فشل في تحديث سعر السوق.');
            }

            DB::commit();
            return $this->success_message('تم دخول الصفقة بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception_message($e);
        }
    }


}


