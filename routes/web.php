<?php

use App\Http\Controllers\EcanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::middleware([App\Http\Middleware\IsUser::class])->group(function () {
    Route::get('/user/dashboard', [EcanController::class, 'index'])->name('user.dashboard');
    Route::post('/user/rating/{makananId}', [EcanController::class, 'beriRating'])->name('user.rating');
    Route::post('/user/komentar/{makananId}', [EcanController::class, 'tambahKomentar'])->name('user.komentar');
    Route::get('/user/stores', [EcanController::class, 'showStores'])->name('user.stores');
    Route::get('/user/store/{storeId}/makanan', [EcanController::class, 'showMakananByStore'])->name('user.makanan.by.store');
    Route::get('/user/cart', [EcanController::class, 'showCart'])->name('user.cart');
    Route::post('/user/cart/add/{makananId}', [EcanController::class, 'addToBag'])->name('user.cart.add');
    Route::delete('/remove-from-cart/{makananId}', [EcanController::class, 'removeFromCart'])->name('user.removeFromCart');
    Route::post('/user/checkout', [EcanController::class, 'checkout'])->name('user.checkout');
    Route::get('/review-order', [EcanController::class, 'reviewOrder'])->name('user.reviewOrder');
});

Route::middleware([App\Http\Middleware\IsAdmin::class])->group(function () {
    Route::get('/admin/dashboard', [EcanController::class, 'admin'])->name('admin.dashboard');
    Route::get('/admin/makanan', [EcanController::class, 'makanan'])->name('admin.makanan');
    Route::get('/admin/makanan/tambah', [EcanController::class, 'tambahMakananForm'])->name('admin.makanan.tambah');
    Route::post('/admin/makanan/tambah', [EcanController::class, 'tambahMakanan'])->name('admin.makanan.tambah');
    Route::get('/admin/activity-log', [EcanController::class, 'showActivityLog'])->name('admin.activity_log');
    Route::get('/admin/tambah-toko', [EcanController::class, 'tambahTokoForm'])->name('admin.tambahTokoForm');
    Route::post('/admin/tambah-toko', [EcanController::class, 'tambahToko'])->name('admin.tambahToko');
    Route::get('admin/tambah-user', [EcanController::class, 'addUserForm'])->name('admin.tambahUserForm');
    Route::post('admin/tambah-user', [EcanController::class, 'addUser'])->name('admin.tambahUser');
    Route::get('admin/edit-user/{userId}', [EcanController::class, 'editUserForm'])->name('admin.editUserForm');
    Route::post('admin/edit-user/{userId}', [EcanController::class, 'editUser'])->name('admin.editUser');
    Route::delete('admin/hapus-user/{userId}', [EcanController::class, 'hapusUser'])->name('admin.hapusUser');
    Route::delete('admin/hapus-makanan/{makananId}', [EcanController::class, 'deleteMakanan'])->name('admin.hapusMakanan');
});
