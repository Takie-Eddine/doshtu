<?php

use App\Http\Controllers\Supplier\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Supplier\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Supplier\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Supplier\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Supplier\Auth\NewPasswordController;
use App\Http\Controllers\Supplier\Auth\PasswordController;
use App\Http\Controllers\Supplier\Auth\PasswordResetLinkController;
use App\Http\Controllers\Supplier\Auth\RegisteredUserController;
use App\Http\Controllers\Supplier\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

        Route::group(['middleware'=>['guest:supplier'] , 'prefix'=>'supplier' , 'as'=>'supplier.'] , function () {
            // Route::get('register', [RegisteredUserController::class, 'create'])
            //             ->name('register');

            // Route::post('register', [RegisteredUserController::class, 'store']);

            Route::get('login', [AuthenticatedSessionController::class, 'create'])
                        ->name('login');

            Route::post('login', [AuthenticatedSessionController::class, 'store']);

            Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                        ->name('password.request');

            Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                        ->name('password.email');

            Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                        ->name('password.reset');

            Route::post('reset-password', [NewPasswordController::class, 'store'])
                        ->name('password.store');
        });

        Route::group(['middleware'=>['auth:supplier'] , 'prefix'=>'supplier' , 'as'=>'supplier.'] , function () {
            Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                        ->name('verification.notice');

            Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                        ->middleware(['signed', 'throttle:6,1'])
                        ->name('verification.verify');

            Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                        ->middleware('throttle:6,1')
                        ->name('verification.send');

            Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                        ->name('supplier.password.confirm');

            Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

            Route::put('password', [PasswordController::class, 'update'])->name('password.update');

            Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                        ->name('logout');
        });

});


