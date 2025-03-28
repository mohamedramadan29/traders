<?php

namespace App\Http\Controllers\front;

use App\Models\front\User;
use Illuminate\Http\Request;
use Faker\Provider\ar_EG\Payment;
use App\Http\Traits\Message_Trait;
use App\Models\front\UserStatment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\ChargeBalance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\front\PaymentTransaction;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class UserBalanceController extends Controller
{
    use Message_Trait;
    protected $apiKey = 'ADCTNJS-XZ046AA-HDM04NW-BCATW23';
    public function deposit(Request $request)
    {
        $user = User::find(Auth::id());
        if (!$user) {
            return Redirect()->back()->withErrors('error', 'المستخدم غير موجود.');
        }
        if($request->deposit < 10){
            return Redirect()->back()->withErrors([ 'المبلغ المدخل يجب ان يكون على الاقل 10 دولار']);
        }

        $endpoint = 'https://api.nowpayments.io/v1/invoice';
        $data = [
            "price_amount" => $request->deposit, // المبلغ المدخل من العميل
            "price_currency" => "usd",
            "order_id" => uniqid(),
            "order_description" => "Payment for order #" . uniqid(),
            "ipn_callback_url" => route('payment.callback'),
            "success_url" => url('/payment/success'),
            "cancel_url" => url('/payment/cancel'),
        ];

        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
        ])->post($endpoint, $data);

        $invoice = $response->json();

        if ($response->successful() && isset($invoice['invoice_url'])) {
            // تسجيل الفاتورة في قاعدة البيانات
            PaymentTransaction::create([
                'user_id' => $user->id,
                'order_id' => $data['order_id'],
                'price_amount' => $data['price_amount'],
                'price_currency' => $data['price_currency'],
                'invoice_url' => $invoice['invoice_url'],
            ]);

            // توجيه العميل لبوابة الدفع
            return redirect($invoice['invoice_url']);
        } else {
            return back()->with('error', 'فشل إنشاء الفاتورة: ' . ($invoice['message'] ?? 'خطأ غير معروف'));
        }
    }


    // Callback to handle payment response
    public function handleCallback(Request $request)
    {
        $data = $request->all();
        // التحقق من البيانات الواردة
        $invoice = PaymentTransaction::where('order_id', $data['order_id'])->first();
        if (!$invoice) {
            return response()->json(['status' => 'error', 'message' => 'فاتورة غير موجودة']);
        }

        if ($data['payment_status'] === 'finished') {
            // تحديث حالة الفاتورة
            $invoice->status = 'paid';
            $invoice->save();

            // زيادة رصيد المستخدم
            $user = User::find($invoice->user_id);
            if ($user) {
                $user->dollar_balance += $invoice->price_amount;
                $user->save();

                // تسجيل العملية في السجل
                UserStatment::create([
                    'user_id' => $user->id,
                    'transaction_type' => 'deposit',
                    'amount' => $invoice->price_amount,
                ]);
                // توجيه العميل إلى صفحة النجاح
                return redirect()->route('payment.success');
                // return response()->json(['status' => 'success', 'message' => 'تم شحن الرصيد بنجاح.']);
            }
        }
        // في حالة الفشل أو حالة غير معروفة
        $invoice->status = 'failed';
        $invoice->save();
        return redirect()->route('payment.cancel')->with('error', 'فشل الدفع. يرجى المحاولة مرة أخرى.');
    }

    // Success page
    public function paymentSuccess()
    {
        return view('front.payment.success');
    }

    // Cancel page
    public function paymentCancel()
    {
        return view('front.payment.cancel');
    }

}
