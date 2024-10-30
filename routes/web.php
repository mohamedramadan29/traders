<?php

use App\Http\Controllers\front\UserController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\front\PlanController;
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
Route::get('/',[\App\Http\Controllers\front\FrontController::class,'index'])->name('index');
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
        /////// Forget Password
        ///
        Route::match(['post', 'get'], 'forget-password', 'forget_password');
        Route::match(['post', 'get'], '/change-forget-password/{code}', 'change_forget_password');
        Route::post('/update_forget_password', 'update_forget_password');
        // User  Dashboard
        Route::group(['middleware' => 'auth'], function () {
            Route::get('dashboard', 'index');
            // update User  password
            Route::match(['post', 'get'], 'update_user_password', 'update_user_password');
            // check User  Password
            Route::post('check_user_password', 'check_user_password');
            // Update User  Details
            Route::match(['post', 'get'], 'update_user_details', 'update_user_details');
            Route::get('logout', 'logout')->name('user_logout');
            Route::post('update-trader-id','update_trader_id');
        });
    });
    Route::group(['middleware' => 'auth'], function () {
       ///////// Start Plans
        Route::controller(PlanController::class)->group(function (){
            Route::get('plans','index');
            Route::get('user_plans','user_plans')->name('user_plans');
           // Route::post('invoice_create','invoice_create');
            Route::match(['post','get'],'invoice_create','invoice_create');
            Route::match(['post','get'],'invoice_withdraw','invoice_withdraw');
            Route::get('plans/{plan_id}', 'platformPlans')->name('user.plans.details');
        });

        /////////////// Start WithDraws ///////////////
        ///
        Route::controller(WithDrawController::class)->group(function () {
            Route::get('withdraws', 'index');
            Route::post('withdraw/add', 'store');
            Route::post('withdraw/update/{id}', 'update');
            Route::post('withdraw/delete/{id}', 'delete');
        });
        ///////////////// Start BootController ////////////////
        ///
        Route::controller(BootController::class)->group(function () {
            Route::get('boots', 'index');
            Route::match(['post', 'get'], 'boot/add', 'store');
            Route::match(['post', 'get'], 'boot/update/{id}', 'update');
            Route::post('boot/delete/{id}', 'delete');

        });

        //////////////////// Start Message Support ////////////
        ///
        Route::controller(SupportController::class)->group(function () {
            Route::get('messages', 'index');
            Route::match(['post', 'get'], 'message/add', 'store');
            Route::match(['post', 'get'], 'message/update/{id}', 'update');
            Route::post('message/delete/{id}', 'delete');
        });

        //////////////////// Start Faqs //////////////
        ///
        Route::controller(FaqController::class)->group(function () {
            Route::get('faqs', 'index');
            Route::match(['post', 'get'], 'faq/add', 'store');
            Route::match(['post', 'get'], 'faq/update/{id}', 'update');
            Route::post('faq/delete/{id}', 'delete');
        });
        ///////////////////  Start Traders ////////////
        ///
        Route::controller(TraderIdController::class)->group(function (){
            Route::get('traderIds','index');
            Route::post('trader-id/add','store');
            Route::post('trader-id/update/{id}','update');
            Route::post('trader-id/delete/{id}','delete');
        });


        //////////// Message Replay
        ///
        Route::controller(MessageReplay::class)->group(function (){
            Route::get('messages_replay/{id}','index');
            Route::match(['post','get'],'message_replay/add/{id}','store');
        });
        Route::view('link','front.links.index');

        ////////////// Start Referal
        ///
        Route::controller(ReferalController::class)->group(function (){
            Route::get('referrals','index');
        });
        ///////////// Start show Levels
        ///
        Route::controller(LevelController::class)->group(function (){
            Route::get('levels','index');
        });
    });
});





include 'admin.php';
