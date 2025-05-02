<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Plisio\PlisioSdkLaravel\Payment;

class PlisoPaymentController extends Controller
{
    public function createInvoice(Request $request)
    {
        $plisio = new Payment(config('plisio.api_key'));
        $params = [
            'invoiceid' => uniqid(),
            'amount' => 5.00,
            'currency' => 'USD',
            'order_description' => 'شراء منتج X',
            'clientdetails' => [
                'email' => 'customer@example.com'
            ]
        ];

        $data = [
            'order_name' => 'Order #' . $params['invoiceid'],
            'order_number' => $params['invoiceid'],
            'description' => $params['order_description'],
            'source_amount' => number_format($params['amount'], 8, '.', ''),
            'source_currency' => $params['currency'],
            'cancel_url' => route('pliso.payment.failed', ['id' => $params['invoiceid']]),
            'callback_url' => route('pliso.payment.callback'),
            'success_url' => route('pliso.payment.success', ['id' => $params['invoiceid']]),
            'email' => $params['clientdetails']['email'],
            'plugin' => 'laravelSdk',
            'version' => '1.0.0'
        ];

        $response = $plisio->createTransaction($data);

        if ($response && $response['status'] !== 'error' && !empty($response['data'])) {
            return redirect($response['data']['invoice_url']);
        } else {
            return redirect()->back()->with('error', 'فشل إنشاء الفاتورة: ' . json_encode($response['data']['message']));
        }
    }

    public function handleCallback(Request $request)
    {
        $plisio = new Payment(config('plisio.api_key'));

        $callbackData = $request->all();

        if ($plisio->verifyCallbackData($callbackData)) {
            // تحقق ناجح، تحديث حالة الطلب في قاعدة البيانات مثلاً
           // Log::info('تم الدفع بنجاح!', $callbackData);
            dd($callbackData);
            return response('OK', 200);
        } else {
            Log::warning('بيانات الدفع غير صحيحة.', $callbackData);
            return response('Unauthorized', 403);
        }
    }
}
