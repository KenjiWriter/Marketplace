<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mainController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    Route::get('/', [mainController::class, 'index'])->name('index');
    Route::get('/user/profile/{id}', [mainController::class, 'profile'])->name('profile');
    Route::get('/announcement/{product_id}', [mainController::class, 'product_page'])->name('product_page');

    Route::group(['middleware'=>['authCheck']], function(){ //To access these pages, the user must be logged in
        //Auth
        Route::get('/auth', [mainController::class, 'auth'])->name('auth');
        Route::post('/auth/logout', [mainController::class, 'logout'])->name('auth.logout');
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
