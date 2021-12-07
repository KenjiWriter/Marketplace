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
Route::group(['middleware'=>['authCheck']], function(){
    Route::get('/auth', [mainController::class, 'auth'])->name('auth');
    Route::get('/post/add', [mainController::class, 'add'])->name('post.add');
    Route::get('/user/post/{id}', [mainController::class, 'show'])->name('post.show');
    Route::post('/auth/logout', [mainController::class, 'delete'])->name('auth.logout');
});
