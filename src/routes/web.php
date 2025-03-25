<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Auth\LoginController;

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

// 店舗一覧ページ
Route::get('/', [ShopController::class, 'index'])->name('shops.index');
// 店舗詳細ページ
Route::get('/detail/{shop}', [ShopController::class, 'detail'])->name('shops.detail');
//thanks ページ用のルート
Route::view('/thanks', 'thanks')->name('thanks');

//マイページ
Route::get('/mypage', [UserController::class, 'mypage'])->middleware('auth')->name('mypage');


//会員登録
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/thanks', function () {
    return view('auth.thanks');
})->name('thanks');

//予約
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::view('/done', 'done')->name('done');

// 予約キャンセル
Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

// いいね機能（Ajax対応）
Route::middleware('auth')->group(function () {
    Route::post('/favorites/{shop}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{shop}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});

//検索
Route::get('/api/shops/search', [ShopController::class, 'search'])->name('shops.search');

//ログイン（バリデーション）
Route::post('/login', [LoginController::class, 'login'])->name('login');

//予約変更
Route::get('/reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
