<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\front\OksContoller;
use App\Http\Controllers\front\UserController;
use \App\Http\Controllers\front\PlanController;
use App\Http\Controllers\front\ChartController;
use App\Http\Controllers\front\TermsController;
use App\Http\Controllers\front\WalletController;
use \App\Http\Controllers\front\StorageInvestment;
use App\Http\Controllers\front\WithDrawController;
use \App\Http\Controllers\front\ExchangeController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\front\CurrencyInvestmentController;
use \App\Http\Controllers\front\SalesOrderController;
use \App\Http\Controllers\front\UserBalanceController;
use App\Http\Controllers\front\NotificationController;
use \App\Http\Controllers\front\StorageInvestmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [\App\Http\Controllers\front\FrontController::class, 'index'])->name('index');
//Route::get('/', function () {
//    return view('front.index');
//})->name('index');
Route::get('/login', function () {
    return view('front.login');
})->name('login');

Route::group(['prefix' => 'user'], function () {
    // user Login
    Route::controller(UserController::class)->group(function () {
        Route::match(['post', 'get'], '/', 'login')->name('user_login');
        Route::match(['post', 'get'], '/register', 'register')->name('user_register');
        Route::get('/confirm/{code}', 'UserConfirm');
        Route::post('send_confirm_email', 'send_confirm_email');
        /////// Forget Password
        ///
        Route::match(['post', 'get'], 'forget-password', 'forget_password');
        Route::match(['post', 'get'], '/change-forget-password/{code}', 'change_forget_password');
        Route::post('/update_forget_password', 'update_forget_password');
        // User  Dashboard
        Route::group(['middleware' => 'auth'], function () {
            Route::get('dashboard', 'index')->name('dashboard');
            // update User  password
            Route::match(['post', 'get'], 'update_user_password', 'update_user_password');
            Route::match(['post', 'get'], 'update_profile_image', 'updateProfileImage');
            // check User  Password
            Route::post('check_user_password', 'check_user_password');
            Route::get('profile', 'profile')->name('profile');
            // Update User  Details
            Route::post('update_user_details', 'update_user_details');
            Route::get('logout', 'logout')->name('user_logout');
            Route::post('update-trader-id', 'update_trader_id');
        });
    });
    Route::group(['middleware' => 'auth'], function () {
        ///////// Start Plans
        Route::controller(PlanController::class)->group(function () {
            Route::get('plans', 'index');
            Route::get('user_plans', 'user_plans')->name('user_plans');
            // Route::post('invoice_create','invoice_create');
            Route::match(['post', 'get'], 'invoice_create', 'invoice_create');
            Route::post('invoice_withdraw', 'invoice_withdraw');
            Route::get('plans/{plan_id}', 'platformPlans')->name('user.plans.details');
            Route::get('/plans/report/{platformId}/{period}', 'getPlanReport');
        });

        /////////////// Start WithDraws ///////////////
        ///
        Route::controller(WithDrawController::class)->group(function () {
            //  Route::get('wallet', 'index');
            Route::post('withdraw/add', 'store');
            Route::post('withdraw/update/{id}', 'update');
            Route::post('withdraw/delete/{id}', 'delete');
        });

        ####################### Start Wallet Controller ############
        Route::controller(WalletController::class)->group(function () {
            Route::get('wallet', 'index');
        });
        ####################### End Wallet Controller ##############
        ///////////////// Start Exchange Controller  ////////////////
        ///
        Route::controller(ExchangeController::class)->group(function () {
            Route::get('exchange', 'index');
        });

        ///////////////////// Start Currency Sales Orders /////////

        Route::controller(SalesOrderController::class)->group(function () {
            Route::post('sales/create', 'create');
        });
        //////////////////////////////// Start User Make Deposit And WithDraw //////////
        Route::controller(UserBalanceController::class)->group(function () {
            Route::match(['post', 'get'], 'deposit', 'deposit');
            Route::post('/payment/callback', 'handleCallback')->name('payment.callback');
            Route::get('/payment/success', 'paymentSuccess')->name('payment.success');
            Route::get('/payment/cancel', 'paymentCancel')->name('payment.cancel');
        });

        ///////////////////////// Storage InvestMent ///// تخزين الغملات
        ///
        Route::controller(StorageInvestmentController::class)->group(function () {
            Route::get('storage', 'index');
            Route::post('storage/add', 'store');
        });
        #################### Start Chart Controller  ##########
        Route::controller(ChartController::class)->group(function () {
            Route::get('charts', 'index');
        });
        ################# End Chart Controller ############

        ############# Start Oks Controller ############
        Route::controller(OksContoller::class)->group(function () {
            Route::get('oks', 'index');
            Route::post('OksInvestment', 'OksInvestment');
        });
        ############# End Oks Controller ##############

        ########### Start Currency Investments ############
        Route::controller(CurrencyInvestmentController::class)->group(function () {
            Route::post('investment', 'investment')->name('currency_investment');
        });
        ############## End Currency Investments ##########
    });
});

Route::controller(TermsController::class)->group(function () {
    Route::get('terms', 'terms');
});
Route::get('auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])->name('auth.google.redirect');
Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback'])->name('auth.google.callback');


Route::get('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])
    ->name('notifications.markAllAsRead');
include 'admin.php';
