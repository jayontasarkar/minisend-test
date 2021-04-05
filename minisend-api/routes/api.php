<?php

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmailController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\RecipientController;

Route::prefix('v1')->group(function() {
    // auth routes
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');

    // accepts transactional emails
    Route::post('emails', [EmailController::class, 'store'])
            ->middleware('token.verify')
            ->name('emails.store');

    // protected routes
    Route::middleware('auth:api')->group(function() {
        // list email activities
        Route::get('activities', ActivityController::class)->name('activities.index');

        // list emails by recipient
        Route::get('recipients/{email}', RecipientController::class)->name('recipient.emails.index');

        // show a single email
        Route::get('emails/{email}', [EmailController::class, 'show'])->name('emails.show');

         // download attachments
        Route::get('download/attachments/{attachment}', function($attachment) {
            $attachment = Attachment::findOrFail($attachment);
            return Storage::download($attachment->path);
        });

        // get authenticated user & logout
        Route::get('/me', [AuthController::class, 'me'])->name('auth.user');
        Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

        // external api access tokens
        Route::resource('tokens', TokenController::class)->only(['index', 'store', 'destroy']);
    });
});
