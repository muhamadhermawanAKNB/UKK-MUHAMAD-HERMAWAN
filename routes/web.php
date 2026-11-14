<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\SubscriptionController;

Route::get('/', [CompanyProfileController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');
    Route::get('/admin', [AdminController::class, 'index'])->middleware('admin')->name('admin.index');
    Route::post('/admin/services', [AdminController::class, 'storeService'])->middleware('admin')->name('admin.services.store');
    Route::put('/admin/services/{service}', [AdminController::class, 'updateService'])->middleware('admin')->name('admin.services.update');
    Route::delete('/admin/services/{service}', [AdminController::class, 'destroyService'])->middleware('admin')->name('admin.services.destroy');
    Route::post('/admin/gallery', [AdminController::class, 'storeGalleryImage'])->middleware('admin')->name('admin.gallery.store');
    Route::put('/admin/gallery/{galleryImage}', [AdminController::class, 'updateGalleryImage'])->middleware('admin')->name('admin.gallery.update');
    Route::delete('/admin/gallery/{galleryImage}', [AdminController::class, 'destroyGalleryImage'])->middleware('admin')->name('admin.gallery.destroy');
});
