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

class userbalanceold extends Controller
{
    use Message_Trait;
    // protected $apiKey = 'ADCTNJS-XZ046AA-HDM04NW-BCATW23';
    protected $apiKey = "8B7S9MR-55DMS8B-NMS7H2R-6CE1N2C";
    //6ea152f8-52ee-4ede-beb8-5cf15fc63b44



    // public function deposit(Request $request)
    // {
    //     $user = User::find(Auth::id());
    //     if (!$user) {
    //         return redirect()->back()->withErrors(['error' => 'المستخدم غير موجود.']);
    //     }
    //     if ($request->deposit < 1) {
    //         return redirect()->back()->withErrors(['المبلغ المدخل يجب أن يكون على الأقل 10 دولار']);
    //     }

    //     $orderId = uniqid();
    //     $orderDescription = "Payment for order #" . $orderId;

    //     // إنشاء success_url مع معرف الفاتورة كـ placeholder {invoice_id}
    //     // $successUrl = url('user/payment/success') . '?invoice_id={invoice_id}';
    //     $successUrl = url('user/payment/success/' . $orderId);

    //     // إنشاء الفاتورة مع success_url مباشرة
    //     $data = [
    //         "price_amount" => $request->deposit,
    //         "price_currency" => "usd",
    //         "order_id" => $orderId,
    //         "order_description" => $orderDescription,
    //         "ipn_callback_url" => route('payment.callback'),
    //         "cancel_url" => url('user/payment/cancel'),
    //         "success_url" => $successUrl,
    //     ];

    //     // إرسال الطلب إلى API لإنشاء الفاتورة
    //     $response = Http::withHeaders([
    //         'x-api-key' => $this->apiKey,
    //     ])->post('https://api.nowpayments.io/v1/invoice', $data);

    //     $invoice = $response->json(); // استخراج بيانات الفاتورة
    //     dd($invoice);

    //     if ($response->successful() && isset($invoice['invoice_url']) && isset($invoice['id'])) {
    //         $invoiceId = $invoice['id'];

    //         // تسجيل الفاتورة في قاعدة البيانات
    //         PaymentTransaction::create([
    //             'user_id' => $user->id,
    //             'order_id' => $orderId,
    //             'invoice_id' => $invoiceId,
    //             'price_amount' => $data['price_amount'],
    //             'price_currency' => $data['price_currency'],
    //             'invoice_url' => $invoice['invoice_url'],
    //         ]);
    //         // توجيه العميل إلى صفحة الدفع
    //         return redirect($invoice['invoice_url']);
    //     } else {
    //         return back()->with('error', 'فشل إنشاء الفاتورة: ' . ($invoice['message'] ?? 'خطأ غير معروف'));
    //     }
    // }


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
            'price_amount' => $data['price_amount'],
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


    // Callback to handle payment response
    // public function handleCallback(Request $request)
    // {
    //     $data = $request->all();
    //     dd($data);
    //     // التحقق من البيانات الواردة
    //     $invoice = PaymentTransaction::where('order_id', $data['order_id'])->first();
    //     if (!$invoice) {
    //         return response()->json(['status' => 'error', 'message' => 'فاتورة غير موجودة']);
    //     }
    //     if ($data['payment_status'] === 'finished') {
    //         // تحديث حالة الفاتورة
    //         $invoice->status = 'paid';
    //         $invoice->save();

    //         // زيادة رصيد المستخدم
    //         $user = User::find($invoice->user_id);
    //         if ($user) {
    //             $user->dollar_balance += $invoice->price_amount;
    //             $user->save();

    //             // تسجيل العملية في السجل
    //             UserStatment::create([
    //                 'user_id' => $user->id,
    //                 'transaction_type' => 'deposit',
    //                 'amount' => $invoice->price_amount,
    //             ]);
    //             // توجيه العميل إلى صفحة النجاح
    //             return redirect()->route('payment.success');
    //             // return response()->json(['status' => 'success', 'message' => 'تم شحن الرصيد بنجاح.']);
    //         }
    //     }
    //     // في حالة الفشل أو حالة غير معروفة
    //     $invoice->status = 'failed';
    //     $invoice->save();
    //     return redirect()->route('payment.cancel')->with('error', 'فشل الدفع. يرجى المحاولة مرة أخرى.');
    // }

    // Success page
    // public function paymentSuccess($orderId)
    // {
    //     //$invoice_payment_id = $request->query('invoice_id'); // استلام ID الفاتورة من URL
    //     $invoice = PaymentTransaction::where('order_id', $orderId)->first();
    //     if (!$invoice) {
    //         abort(404);
    //     }
    //     $invoice_payment_id = $invoice->invoice_id;

    //     // البحث عن الفاتورة في قاعدة البيانات
    //     //$invoice = PaymentTransaction::where('invoice_id', $invoice_payment_id)->first();
    //     // dd($invoice);

    //     if (!$invoice || $invoice->status === 'paid') {
    //         return response()->json(['status' => 'paid']);
    //     }

    //     // بيانات تسجيل الدخول للحصول على الـ JWT Token
    //     $email = 'qout12ex@gmail.com';
    //     $password = 'Hussain.h1998';

    //     $authResponse = Http::withHeaders([
    //         'Content-Type' => 'application/json'
    //     ])->post('https://api.nowpayments.io/v1/auth', [
    //                 'email' => $email,
    //                 'password' => $password,
    //             ]);

    //     $tokenData = $authResponse->json();
    //     $jwtToken = $tokenData['token'] ?? null;

    //     if (!$jwtToken) {
    //         return response()->json(['status' => 'error', 'message' => 'فشل في الحصول على رمز المصادقة']);
    //     }

    //     // جلب بيانات الدفع
    //     $paymentResponse = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . $jwtToken,
    //         'x-api-key' => $this->apiKey,
    //     ])->get('https://api.nowpayments.io/v1/payment', [
    //                 'limit' => 100,
    //                 'page' => 0,
    //                 'sortBy' => 'created_at',
    //                 'orderBy' => 'asc',
    //                 'dateFrom' => '2025-01-01',
    //                 'dateTo' => '2026-01-01',
    //                 'invoiceId' => $invoice_payment_id,
    //             ]);

    //     $payments = $paymentResponse->json();

    //     if (empty($payments['data'])) {
    //         return response()->json(['status' => 'error', 'message' => 'لم يتم العثور على دفعة لهذه الفاتورة']);
    //     }

    //     $paymentData = $payments['data'][0]; // استخراج بيانات الدفع الأولى
    //     //dd($paymentData);
    //     // التحقق من حالة الدفع
    //     if ($paymentData['payment_status'] === 'finished') {
    //         // تحديث حالة الفاتورة إلى "مدفوعة"
    //         $invoice->status = 'paid';
    //         $invoice->save();
    //         // البحث عن المستخدم وإضافة الرصيد
    //         $user = User::find($invoice->user_id);
    //         if ($user) {
    //             $user->dollar_balance += $invoice->price_amount;
    //             $user->save();
    //             // تسجيل العملية في كشف الحساب
    //             UserStatment::create([
    //                 'user_id' => $user->id,
    //                 'transaction_type' => 'deposit',
    //                 'amount' => $invoice->price_amount,
    //             ]);
    //         }
    //         return view('front.payment.success');
    //     } else {
    //         return view('front.payment.failed');
    //     }

    //     //return response()->json(['status' => $paymentData['payment_status']]);
    // }

    // Cancel page
    public function paymentCancel()
    {
        return view('front.payment.cancel');
    }

    // public function checkPaymentStatus(Request $request, $id)
    // {
    //     // البحث عن الفاتورة في قاعدة البيانات
    //     $invoice = PaymentTransaction::where('invoice_id', $id)->first();


    //     if (!$invoice || $invoice->status === 'paid') {
    //         return response()->json(['status' => 'paid']);
    //     }

    //     // بيانات تسجيل الدخول للحصول على الـ JWT Token
    //     $email = 'mr319242@gmail.com';
    //     $password = 'Mohamedramadan2930#';

    //     $authResponse = Http::withHeaders([
    //         'Content-Type' => 'application/json'
    //     ])->post('https://api.nowpayments.io/v1/auth', [
    //                 'email' => $email,
    //                 'password' => $password,
    //             ]);

    //     $tokenData = $authResponse->json();
    //     $jwtToken = $tokenData['token'] ?? null;

    //     if (!$jwtToken) {
    //         return response()->json(['status' => 'error', 'message' => 'فشل في الحصول على رمز المصادقة']);
    //     }

    //     // جلب بيانات الدفع
    //     $paymentResponse = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . $jwtToken,
    //         'x-api-key' => $this->apiKey,
    //     ])->get('https://api.nowpayments.io/v1/payment', [
    //                 'limit' => 100,
    //                 'page' => 0,
    //                 'sortBy' => 'created_at',
    //                 'orderBy' => 'asc',
    //                 'dateFrom' => '2025-01-01',
    //                 'dateTo' => '2026-01-01',
    //                 'invoiceId' => $id,
    //             ]);

    //     $payments = $paymentResponse->json();
    //     dd($payments);

    //     if (empty($payments['data'])) {
    //         return response()->json(['status' => 'error', 'message' => 'لم يتم العثور على دفعة لهذه الفاتورة']);
    //     }

    //     $paymentData = $payments['data'][0]; // استخراج بيانات الدفع الأولى
    //     //dd($paymentData);
    //     // التحقق من حالة الدفع
    //     if ($paymentData['payment_status'] === 'finished') {
    //         // تحديث حالة الفاتورة إلى "مدفوعة"
    //         $invoice->status = 'paid';
    //         $invoice->save();

    //         // البحث عن المستخدم وإضافة الرصيد
    //         $user = User::find($invoice->user_id);
    //         if ($user) {
    //             $user->dollar_balance += $invoice->price_amount;
    //             $user->save();

    //             // تسجيل العملية في كشف الحساب
    //             UserStatment::create([
    //                 'user_id' => $user->id,
    //                 'transaction_type' => 'deposit',
    //                 'amount' => $invoice->price_amount,
    //             ]);
    //         }

    //         return response()->json(['status' => 'paid']);
    //     } else {
    //         return response()->json(['status' => 'error', 'message' => '']);
    //     }

    //     // return response()->json(['status' => $paymentData['payment_status']]);
    // }





}
