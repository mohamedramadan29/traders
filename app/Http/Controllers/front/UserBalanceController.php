<?php

namespace App\Http\Controllers\front;

use Log;
use App\Models\front\User;
use Illuminate\Http\Request;
use App\Http\Traits\Message_Trait;
use App\Models\front\UserStatment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\ChargeBalance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Plisio\PlisioSdkLaravel\Payment;
use App\Models\front\PaymentTransaction;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class UserBalanceController extends Controller
{
    use Message_Trait;
    public function deposit(Request $request)
    {

        $plisio = new Payment(config('plisio.api_key'));
        $user = User::find(Auth::id());
        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'المستخدم غير موجود.']);
        }
        if ($request->deposit < 10) {
            return redirect()->back()->withErrors(['المبلغ المدخل يجب أن يكون على الأقل 10 دولار']);
        }
        $params = [
            'invoiceid' => uniqid(),
            'amount' => $request->deposit,
            'currency' => 'USD',
            'order_description' => ' شحن الرصيد الخاص بي في Binvest  ',
            'clientdetails' => [
                'email' => Auth::user()->email
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
        //   تسجيل الفاتورة في قاعدة البيانات
        PaymentTransaction::create([
            'user_id' => $user->id,
            'order_id' => $params['invoiceid'],
            'invoice_id' => $params['invoiceid'],
            'price_amount' => $request->deposit,
            'price_currency' => "USD",
            'email' => $params['clientdetails']['email']
        ]);
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
            $orderNumber = $callbackData['order_number'] ?? null;
            $amountPaid = $callbackData['amount'] ?? 0;
            $invoice = PaymentTransaction::where('invoice_id', $orderNumber)->first();
            if ($invoice && $invoice->status !== 'paid') {

                // البحث عن المستخدم وإضافة الرصيد
                $user = User::find($invoice->user_id);
                if ($user) {
                    $user->dollar_balance += $invoice->price_amount;
                    $user->save();
                    $invoice->status = 'paid';
                    $invoice->save();
                    // تسجيل العملية في كشف الحساب
                    UserStatment::create([
                        'user_id' => $user->id,
                        'transaction_type' => 'deposit',
                        'amount' => $invoice->price_amount,
                    ]);
                }
                return view('front.payment.success');
            }
            return response('Already Processed or Not Found', 200);
        } else {
            return response('Unauthorized', 403);
        }
    }
    // Cancel page
    public function paymentCancel()
    {
        return view('front.payment.cancel');
    }
    public function paymentSuccess(Request $request)
    {
        $orderNumber = $request->id;

        $invoice = PaymentTransaction::where('invoice_id', $orderNumber)->first();

        if ($invoice && $invoice->status !== 'paid') {
            // ⚠️ لا يوجد تحقق فعلي من Plisio هنا، فقط تحديث محلي

            $user = User::find($invoice->user_id);
            if ($user) {
                $user->dollar_balance += $invoice->price_amount;
                $user->save();

                $invoice->status = 'paid';
                $invoice->save();

                UserStatment::create([
                    'user_id' => $user->id,
                    'transaction_type' => 'deposit',
                    'amount' => $invoice->price_amount,
                ]);
            }
        }

        return view('front.payment.success2');
    }
}
