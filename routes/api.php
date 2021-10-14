<?php



use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\User\AuthController;
use App\Http\Controllers\Api\V1\User\WorkspaceController;
use App\Http\Controllers\Api\V1\User\ActivityController;
use App\Http\Controllers\Api\V1\User\ResetPasswordController;
use App\Http\Controllers\Api\V1\User\UserActivationController;
use App\Http\Controllers\Api\V1\User\OrderController;
use App\Http\Controllers\Api\V1\User\PaymentController;


use App\Http\Controllers\Api\V1\Admin\FeatureController;

Route::group(['prefix'=>'user'],function ()
{
    Route::post('register',[AuthController::class,'register'])->name('register');
    Route::post('login',[AuthController::class,'login'])->name('login');

    Route::get('activation/{user}',[UserActivationController::class,'requestCode'])->name('activation.request');
    Route::get('activation/verify/{token}',[UserActivationController::class,'activation'])->name('activation.account');

    Route::post('password/request',[ResetPasswordController::class,'requestCode'])->name('passwords.request');
    Route::post('password/reset',[ResetPasswordController::class,'reset'])->name('passwords.reset');

    Route::post('payment/callback',[PaymentController::class,'callback'])->name('payment.callback');

    Route::group(['middleware'=>['auth:api','verify']],function (){
        Route::post('logout',[AuthController::class,'logout'])->name('logout');
        Route::post('change-password',[AuthController::class,'change'])->name('change.password');
        Route::resource('order',OrderController::class);

        Route::group(['prefix'=>'payment'],function (){
            Route::get('/send-to-gate/{order}',[PaymentController::class,'sendToGate'])->name('payment.gate');
        });

        Route::resource('workspace',WorkspaceController::class)->except(['create','edit']);
        Route::resource('activity',ActivityController::class)->except(['create','edit']);
    });
});

Route::group(['prefix'=>'admin'],function ()
{
//    admin login
    Route::group(['middleware'=>['auth:api']],function ()
    {
        Route::resource('feature',FeatureController::class)->except(['create','edit']);
        Route::get('/feature/enable/{feature}',[FeatureController::class,'enable'])->name('feature.enable');
    });
});
