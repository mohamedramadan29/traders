<?php


use App\Http\Controllers\front\UserController;
use App\Http\Controllers\front\WithDrawController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\front\PlanController;
use \App\Http\Controllers\front\ExchangeController;
use \App\Http\Controllers\front\SalesOrderController;
use \App\Http\Controllers\front\UserBalanceController;
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
            Route::get('/plans/report/{platformId}/{period}','getPlanReport');
        });

        /////////////// Start WithDraws ///////////////
        ///
        Route::controller(WithDrawController::class)->group(function () {
            Route::get('withdraws', 'index');
            Route::post('withdraw/add', 'store');
            Route::post('withdraw/update/{id}', 'update');
            Route::post('withdraw/delete/{id}', 'delete');
        });
        ///////////////// Start Exchange Controller  ////////////////
        ///
         Route::controller(ExchangeController::class)->group(function (){
             Route::get('exchange','index');
         });

         ///////////////////// Start Currency Sales Orders /////////

        Route::controller(SalesOrderController::class)->group(function (){
            Route::post('sales/create','create');
        });

        //////////////////////////////// Start User Make Deposit And WithDraw //////////
        Route::controller(UserBalanceController::class)->group(function (){
            Route::match(['post','get'],'deposit','deposit');
        });
    });
});





include 'admin.php';
