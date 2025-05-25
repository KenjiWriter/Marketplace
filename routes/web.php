<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\mainController;
use App\Http\Controllers\LanguageController;
Route::middleware(['web'])->group(function () {
Route::get('/', [mainController::class, 'index'])->name('index');
Route::get('/user/profile/{id}', [mainController::class, 'profile'])->name('profile');
Route::get('/announcement/{product_id}', [mainController::class, 'product_page'])->name('product_page');

//Facebook login
Route::get('/auth/facebook', [authController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [authController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');

//Google login
Route::get('/auth/google', [authController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [authController::class, 'handleGoogleCallback'])->name('auth.google.callback');

//Password reset
Route::get('/auth/reset', [authController::class, 'passwordReset'])->name('auth.reset');
Route::post('/auth/reset/send', [authController::class, 'passwordReset_send'])->name('auth.reset.send');
Route::get('/auth/reset/{email}/{code}', [authController::class, 'passwordReset_verify'])->name('auth.reset.verify');
Route::post('/auth/reset/{email}/{code}', [authController::class, 'passwordReset_change'])->name('auth.reset.change');

Route::group(['middleware' => ['authCheck']], function () { //To access these pages, the user must be logged in
    //Auth
    Route::get('/auth', [authController::class, 'auth'])->name('auth');

    //Logout
    Route::post('/auth/logout', [authController::class, 'logout'])->name('auth.logout');

    //Email verification
    Route::get('/email/verify', [authController::class, 'show'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [authController::class, 'verify'])->name('verification.verify')->middleware(['signed']);
    Route::post('/email/resend', [authController::class, 'email_resend'])->name('verification.resend');

    //User
    Route::get('/post/add', [mainController::class, 'add'])->name('post.add');
    Route::get('/post/edit/{id}', [mainController::class, 'post_edit_get'])->name('post.edit');
    Route::post('/post/edit', [mainController::class, 'post_edit_post'])->name('post.edit2');
    Route::get('/user/post/{id}', [mainController::class, 'show'])->name('post.show');
    Route::post('/post/delete', [mainController::class, 'post_delete'])->name('post.delete');
    Route::get('/add_balance', [mainController::class, 'balance'])->name('balance');
    Route::post('/balance/add', [mainController::class, 'balance_add'])->name('balance.add');
    Route::get('/promote/{id}', [mainController::class, 'promote'])->name('promote');
    Route::post('/promote/add', [mainController::class, 'promote_add'])->name('promote.add');
    Route::get('/messages', [mainController::class, 'messages'])->name('messages');
    Route::get('/messages/roomId/{roomId}', [mainController::class, 'chat'])->name('chat');
});
Route::get('language/{lang}', [LanguageController::class, 'switchLang'])->name('language.switch');
});
