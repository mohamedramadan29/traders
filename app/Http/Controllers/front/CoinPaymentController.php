<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Hexters\CoinPayment\CoinPayment;

class CoinPaymentController extends Controller
{
    public function createTransaction()
    {
        $transaction = [];

        $transaction['order_id'] = uniqid(); // رقم الفاتورة
        $transaction['amountTotal'] = 50.00;
        $transaction['note'] = 'اشتراك Premium';
        $transaction['buyer_name'] = 'Mohamed Ali';
        $transaction['buyer_email'] = 'client@example.com';

        $transaction['redirect_url'] = url('user/payment-success'); // عند النجاح
        $transaction['cancel_url'] = url('user/payment-cancel');    // عند الإلغاء

        $transaction['items'][] = [
            'itemDescription' => 'اشتراك باقة Premium',
            'itemPrice' => 50.00,
            'itemQty' => 1,
            'itemSubtotalAmount' => 50.00
        ];

        $transaction['payload'] = [
            'user_id' => auth()->id() ?? 1
        ];

        //  return CoinPayment::generatelink($transaction); // يرجع الرابط

        $link = CoinPayment::generatelink($transaction);

        // لو عايز تعمل Redirect مباشر:
        return redirect($link);
    }
}
