<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\OperatorDashboardController;
use App\Http\Controllers\OperatorRequestBoostController;
use App\Http\Controllers\OperatorRequestPostController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\RequestBoostingController;
use App\Http\Controllers\RequestPostingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/', function () {
    return view('auth.login');
})->name('auth.login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    // Dashboard Routes
    Route::get('/system/dashboard', [DashboardController::class, 'index'])->name('system.dashboard.index');

    // User Management Routes
    Route::prefix('system/users')->name('system.users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/list', [UserController::class, 'list'])->name('list');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{a}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{a}/update', [UserController::class, 'update'])->name('update');
        Route::delete('/{a}/destroy', [UserController::class, 'destroy'])->name('destroy');
    });

    // Platform Management Routes
    Route::prefix('system/platforms')->name('system.platforms.')->group(function () {
        Route::get('/', [PlatformController::class, 'index'])->name('index');
        Route::get('/list', [PlatformController::class, 'list'])->name('list');
        Route::post('/store', [PlatformController::class, 'store'])->name('store');
        Route::get('/{a}/edit', [PlatformController::class, 'edit'])->name('edit');
        Route::post('/{a}/update', [PlatformController::class, 'update'])->name('update');
        Route::delete('/{a}/destroy', [PlatformController::class, 'destroy'])->name('destroy');
    });

    // Request Posting Routes
    Route::prefix('system/request/posts')->name('system.request.posts.')->group(function () {
        Route::get('/', [RequestPostingController::class, 'index'])->name('index');
        Route::get('/list', [RequestPostingController::class, 'list'])->name('list');
        Route::get('/create', [RequestPostingController::class, 'create'])->name('create');
        Route::post('/store', [RequestPostingController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [RequestPostingController::class, 'edit'])->name('edit');
        Route::put('/{id}', [RequestPostingController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [RequestPostingController::class, 'destroy'])->name('destroy');
    });

    // Media Routes
    Route::delete('/media/{id}', [MediaController::class, 'destroy'])->name('media.destroy');

    // Request Boosting Routes
    Route::prefix('system/request/boosts')->name('system.request.boosts.')->group(function () {
        Route::get('/', [RequestBoostingController::class, 'index'])->name('index');
        Route::get('/list', [RequestBoostingController::class, 'list'])->name('list');
        Route::get('/create', [RequestBoostingController::class, 'create'])->name('create');
        Route::post('/store', [RequestBoostingController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [RequestBoostingController::class, 'edit'])->name('edit');
        Route::put('/{id}', [RequestBoostingController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [RequestBoostingController::class, 'destroy'])->name('destroy');
    });

    // Boost Limits Route
    Route::get('/get-boost-limits/{platformId}', [RequestBoostingController::class, 'getBoostLimits']);

    Route::get('/system/operator/dashboard', [OperatorDashboardController::class, 'index']);

    Route::get('/system/operator/request/posts', [OperatorRequestPostController::class, 'index'])->name('system.operator.request.posts');
    Route::get('/system/operator/request/posts/list', [OperatorRequestPostController::class, 'list'])->name('system.operator.request.posts.list');
    Route::get('/system/request/operator/posts/{a}/detail', [OperatorRequestPostController::class, 'detail'])->name('system.operator.request.posts.detail');
    Route::get('/system/request/operator/posts/{a}/detail', [OperatorRequestPostController::class, 'detail'])->name('system.operator.request.posts.detail');
    Route::get('/system/request/operator/posts/{a}/report', [OperatorRequestPostController::class, 'report'])->name('system.operator.request.posts.report');
    Route::post('/system/request/operator/posts/report/store', [OperatorRequestPostController::class, 'storeReport'])->name('system.operator.request.posts.store');
    Route::put('/system/request/operator/posts/report/update/{id}', [OperatorRequestPostController::class, 'updateReport'])->name('system.operator.request.posts.update');
    
    Route::get('/system/operator/request/boosts', [OperatorRequestBoostController::class, 'index'])->name('system.operator.request.boosts');
    Route::get('/system/operator/request/boosts/list', [OperatorRequestBoostController::class, 'list'])->name('system.operator.request.boosts.list');
    Route::get('/system/request/operator/boosts/{a}/detail', [OperatorRequestBoostController::class, 'detail'])->name('system.operator.request.boosts.detail');
    Route::get('/system/request/operator/boosts/{a}/detail', [OperatorRequestBoostController::class, 'detail'])->name('system.operator.request.boosts.detail');
    Route::get('/system/request/operator/boosts/{a}/report', [OperatorRequestBoostController::class, 'report'])->name('system.operator.request.boosts.report');
    Route::post('/system/request/operator/boosts/report/store', [OperatorRequestBoostController::class, 'storeReport'])->name('system.operator.request.boosts.store');
    Route::put('/system/request/operator/boosts/report/update/{id}', [OperatorRequestBoostController::class, 'updateReport'])->name('system.operator.request.boosts.update');
});
