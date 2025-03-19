<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\UserController;
use \App\Http\Controllers\admin\AdminController;
use \App\Http\Controllers\admin\PlansController;
use App\Http\Controllers\admin\WithDrawController;
use \App\Http\Controllers\admin\PlatformController;
use App\Http\Controllers\admin\StoragePlanController;
use App\Http\Controllers\admin\CurrencyPlansController;
use App\Http\Controllers\admin\StorageInvestmentController;
use \App\Http\Controllers\admin\PlatFormInvestmentController;
Route::group(['prefix' => 'admin'], function () {
    // Admin Login
    Route::controller(AdminController::class)->group(function () {
        Route::match(['post', 'get'], '/', 'login')->name('admin_login');
        Route::match(['post', 'get'], 'login', 'login')->name('admin_login');
        Route::match(['post', 'get'], 'sign-up', 'signup');
        Route::match(['post', 'get'], 'forget-password', 'forget_password');
        // Admin Dashboard
        Route::group(['middleware' => 'admin'], function () {
            Route::get('dashboard', 'dashboard');
            // update admin password
            Route::match(['post', 'get'], 'update_admin_password', 'update_admin_password');
            // check Admin Password
            Route::post('check_admin_password', 'check_admin_password');
            // Update Admin Details
            Route::match(['post', 'get'], 'update_admin_details', 'update_admin_details');
            Route::get('logout', 'logout')->name('logout');
        });
    });

    Route::group(['middleware' => 'admin'], function () {
        Route::controller(PlatformController::class)->group(function () {
            Route::get('platforms', 'index');
            Route::match(['post', 'get'], 'platform/store', 'store');
            Route::match(['post', 'get'], 'platform/update/{id}', 'update');
            Route::post('platform/delete/{id}', 'delete');
        });
        Route::controller(PlansController::class)->group(function () {
            Route::get('plans', 'index');
            Route::match(['post', 'get'], 'plan/store', 'store');
            Route::match(['post', 'get'], 'plan/update/{id}', 'update');
            Route::post('plan/delete/{id}', 'delete');
            Route::post('plan/lock/{id}', 'lock');
            Route::get('plan_report/{id}', 'report');
        });

        Route::controller(PlatFormInvestmentController::class)->group(function () {
            Route::get('investments/{id}', 'index');
            Route::match(['post', 'get'], 'investment/store/{id}', 'store');
        });

        Route::controller(UserController::class)->group(function () {
            Route::get('users', 'index');
            Route::get('user_report/{id}', 'report');
        });
        /////////////// Start WithDraws ///////////////
        ///
        Route::controller(WithDrawController::class)->group(function () {
            Route::get('withdraws', 'index');
            Route::post('withdraw/add', 'store');
            Route::post('withdraw/update/{id}', 'update');
            Route::post('withdraw/delete/{id}', 'delete');
        });
        #################### Start Storage InvestMent Controller ##############
        Route::controller(StorageInvestmentController::class)->group(function () {
            Route::get('storages', 'index');
        });
        ##################### End Storage InvestMent Controller ##############
        ################## Start StoragePlan Daily Investment ################
        Route::controller(StoragePlanController::class)->group(function(){
            Route::get('storage/plans','index');
            Route::match(['post','get'],'storage_return/{id}','StorageDailyReturn');

        });
        ##################### End Storage Plan Daily Investment ##############

        ############## Start Currency Plans Controller ##################

        Route::controller(CurrencyPlansController::class)->group(function () {
            Route::get('currency_plans', 'index');
            Route::match(['post','get'],'currency_plan/store','store');
            Route::match(['post','get'],'currency_plan/update/{id}','update');
            Route::post('currency_plan/delete/{id}', 'delete');
        });
        ################# End Currency Plans Controller #################
    });
});
