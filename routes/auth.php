<?php

use App\Http\Controllers\User\Auth\AuthenticatedSessionController;
use App\Http\Controllers\User\Auth\ConfirmablePasswordController;
use App\Http\Controllers\User\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\User\Auth\EmailVerificationPromptController;
use App\Http\Controllers\User\Auth\NewPasswordController;
use App\Http\Controllers\User\Auth\PasswordController;
use App\Http\Controllers\User\Auth\PasswordResetLinkController;
use App\Http\Controllers\User\Auth\RegisteredUserController;
use App\Http\Controllers\User\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

        Route::prefix('shopify')->group(function(){
            Route::get('auth',[InstalationController::class,'startInstalation']);
            Route::get('auth/redirect',[InstalationController::class, 'handleRedirect'])->name('app_install_redirect');

        });


        Route::group(['middleware'=>['guest:web']  ] , function () {;

            Route::get('/', [RegisteredUserController::class, 'create'])
                        ->name('home');

            Route::post('register', [RegisteredUserController::class, 'store'])
                        ->name('register');

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

        Route::group(['middleware'=>['auth:web'] ] , function () {
            Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                        ->name('verification.notice');

            Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                        ->middleware(['signed', 'throttle:6,1'])
                        ->name('verification.verify');

            Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                        ->middleware('throttle:6,1')
                        ->name('verification.send');

            Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                        ->name('password.confirm');

            Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

            Route::put('password', [PasswordController::class, 'update'])->name('password.update');

            Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                        ->name('logout');
        });

});


