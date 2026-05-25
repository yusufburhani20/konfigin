<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KurikulumController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\EserviceController;
use App\Http\Controllers\Admin\KeunggulanController;
use App\Http\Controllers\Admin\KontakController;
use App\Http\Controllers\Admin\SettingsController;

// ===== PUBLIC ROUTES =====
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');
Route::get('/category/{slug}', [App\Http\Controllers\BlogController::class, 'category'])->name('blog.category');

// ===== ADMIN ROUTES =====
Route::prefix('admin')->name('admin.')->group(function () {

    // Auth (no middleware)
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware('admin.auth')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Kurikulum
        Route::get('/kurikulum',              [KurikulumController::class, 'index'])->name('kurikulum.index');
        Route::post('/kurikulum',             [KurikulumController::class, 'store'])->name('kurikulum.store');
        Route::put('/kurikulum/{kurikulum}',  [KurikulumController::class, 'update'])->name('kurikulum.update');
        Route::delete('/kurikulum/{kurikulum}', [KurikulumController::class, 'destroy'])->name('kurikulum.destroy');

        // Galeri
        Route::get('/galeri',             [GaleriController::class, 'index'])->name('galeri.index');
        Route::post('/galeri',            [GaleriController::class, 'store'])->name('galeri.store');
        Route::put('/galeri/{galeri}',    [GaleriController::class, 'update'])->name('galeri.update');
        Route::delete('/galeri/{galeri}', [GaleriController::class, 'destroy'])->name('galeri.destroy');

        // E-Service
        Route::get('/eservice',               [EserviceController::class, 'index'])->name('eservice.index');
        Route::post('/eservice',              [EserviceController::class, 'store'])->name('eservice.store');
        Route::put('/eservice/{eservice}',    [EserviceController::class, 'update'])->name('eservice.update');
        Route::delete('/eservice/{eservice}', [EserviceController::class, 'destroy'])->name('eservice.destroy');

        // Keunggulan
        Route::get('/keunggulan',                 [KeunggulanController::class, 'index'])->name('keunggulan.index');
        Route::post('/keunggulan',                [KeunggulanController::class, 'store'])->name('keunggulan.store');
        Route::put('/keunggulan/{keunggulan}',    [KeunggulanController::class, 'update'])->name('keunggulan.update');
        Route::delete('/keunggulan/{keunggulan}', [KeunggulanController::class, 'destroy'])->name('keunggulan.destroy');

        // Kontak
        Route::get('/kontak',  [KontakController::class, 'edit'])->name('kontak.edit');
        Route::put('/kontak',  [KontakController::class, 'update'])->name('kontak.update');

        // Settings
        Route::get('/settings',  [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings',  [SettingsController::class, 'update'])->name('settings.update');

        // Users
        Route::get('/users',                 [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::post('/users',                [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}',          [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}',       [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

        // Categories
        Route::get('/categories',                 [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories',                [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}',      [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}',   [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

        // Posts
        Route::resource('posts', App\Http\Controllers\Admin\PostController::class)->except(['show']);

        // Pages
        Route::resource('pages', App\Http\Controllers\Admin\PageController::class)->except(['show']);

        // Media Upload for TinyMCE
        Route::post('/media/upload', [App\Http\Controllers\Admin\MediaController::class, 'upload'])->name('media.upload');
    });
});

// Catcher route for dynamic pages
Route::get('/{slug}', [App\Http\Controllers\PageController::class, 'show'])->name('page.show');
