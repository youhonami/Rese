<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\StoreManagerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Representative\ReservationController as RepresentativeReservationController;
use App\Http\Controllers\Representative\ShopController as RepresentativeShopController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LogoutController;

// 店舗一覧ページ
Route::get('/', [ShopController::class, 'index'])->name('shops.index');
// 店舗詳細ページ
Route::get('/detail/{shop}', [ShopController::class, 'detail'])->name('shops.detail');
//thanks ページ用のルート
Route::view('/thanks', 'auth.thanks')->name('thanks');

//マイページ
Route::get('/mypage', [UserController::class, 'mypage'])->middleware('auth')->name('mypage');

//予約
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::view('/done', 'done')->name('done');

// 予約キャンセル
Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

// いいね機能
Route::middleware('auth')->group(function () {
    Route::post('/favorites/{shop}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{shop}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});

//検索
Route::get('/api/shops/search', [ShopController::class, 'search'])->name('shops.search');

//予約変更
Route::get('/reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');

Route::get('/reservations/{id}/qrcode', [ReservationController::class, 'showQrCode'])
    ->name('reservations.qrcode')
    ->middleware(['auth']);

Route::get('/reviews/{reservation}', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/reviews/{reservation}', [ReviewController::class, 'store'])->name('reviews.store');

//管理者関連
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/representatives/create', [AdminController::class, 'createRepresentative'])->name('representatives.create');
    Route::post('/representatives/store', [AdminController::class, 'store'])->name('representatives.store');
});

//店舗代表者関連
Route::middleware(['auth', 'representative'])->prefix('representative')->name('representative.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\RepresentativeController::class, 'dashboard'])->name('dashboard');
    Route::get('/reservations', [RepresentativeReservationController::class, 'index'])->name('reservations.index');
    Route::get('/shops/form', [RepresentativeShopController::class, 'form'])->name('shops.form');
    Route::post('/shops/store', [RepresentativeShopController::class, 'store'])->name('shops.store');
    Route::put('/shops/update/{shop}', [RepresentativeShopController::class, 'update'])->name('shops.update');
});
Route::middleware(['auth', 'can:isRepresentative'])->prefix('representative')->name('representative.')->group(function () {
    Route::get('/shop', [App\Http\Controllers\Representative\ShopController::class, 'edit'])->name('shop.edit');
    Route::post('/shop', [App\Http\Controllers\Representative\ShopController::class, 'store'])->name('shop.store');
    Route::put('/shop', [App\Http\Controllers\Representative\ShopController::class, 'update'])->name('shop.update');
});

// ログアウト
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
