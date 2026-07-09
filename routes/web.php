<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\inventoriController;
use App\Http\Controllers\asetController;
use App\Http\Controllers\proyekController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DoController;

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


Route::get('/signin', function () {
    return view('account-pages.signin');
})->name('signin');

Route::get('/sign-in', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('sign-in');

Route::post('/sign-in', [LoginController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [LoginController::class, 'destroy'])

    ->name('logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'store'])
    ->middleware('guest');

Route::get('/laravel-examples/user-profile', [ProfileController::class, 'index'])->name('users.profile');
Route::put('/laravel-examples/user-profile/update', [ProfileController::class, 'update'])->name('users.update');
Route::get('/laravel-examples/users-management', [UserController::class, 'index'])->name('users-management');



//invetori mtt//
Route::middleware(['auth'])->group(function () {


    Route::get('/', function () {
        return redirect('/dashboard');
    });

    Route::get('/dashboard', [App\Http\Controllers\dashboardController::class, 'index'])->name('dashboard');

    // ===============================
    // USER MANAGEMENT & REGISTER (hanya superadmin)
    // ===============================
    Route::middleware(['role:superadmin'])->group(function () {
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::get('/users/register', [UserManagementController::class, 'create'])->name('users.register');
        Route::post('/users/register', [UserManagementController::class, 'store'])->name('users.register.store');
        Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    });

    route::get('/inventori', [inventoriController::class, 'ws'])->name('view-ws');
    route::post('/inventori/add', [inventoriController::class, 'store'])->middleware('role:admin,superadmin')->name('ws-store');
    route::put('/inventori/{id}', [inventoriController::class, 'update'])->middleware('role:admin,superadmin')->name('ws.update');
    route::delete('/inventori/{id}', [inventoriController::class, 'destroy'])->middleware('role:superadmin')->name('ws.hapus');
    Route::post('/inventori/import', [inventoriController::class, 'import'])->middleware('role:admin,superadmin')->name('inventori.import');
    Route::get('/inventori/export', [inventoriController::class, 'export'])->name('inventori.export');
    Route::get('/inventori/filter', [inventoriController::class, 'filter'])->name('ws.filter');
    Route::get('/inventori/get-detail', [inventoriController::class, 'getDetail'])->name('ws.getDetail');

    //aset jual
    Route::get('/inventory-aset-jual/search', [asetController::class, 'search'])->name('asetjual.search');
    route::get('/inventory-aset-jual', [asetController::class, 'aset'])->name('view-aset');
    route::post('/inventory-aset-jual/add', [asetController::class, 'store'])->middleware('role:admin,superadmin')->name('aset-store');
    route::put('/inventory-aset-jual/{id}', [asetController::class, 'update'])->middleware('role:admin,superadmin')->name('aset.update');
    route::delete('/inventory-aset-jual/{id}', [asetController::class, 'destroy'])->middleware('role:superadmin')->name('aset.hapus');
    Route::post('/inventory-aset-jual/import', [asetController::class, 'import'])->middleware('role:admin,superadmin')->name('asetjual.import');
    Route::get('/inventory-aset-jual/export', [asetController::class, 'export'])->name('asetjual.export');
    Route::get('/inventory-aset/filter', [AsetController::class, 'filter'])->name('aset.filter');
    Route::get('/inventory-aset/get-detail', [AsetController::class, 'getDetail'])->name('aset.getDetail');

    //project
    route::get('/inventory-projek', [proyekController::class, 'projek'])->name('view-projek');
    route::post('/inventory-projek/add', [proyekController::class, 'store'])->middleware('role:admin,superadmin')->name('projek-store');
    route::put('/inventory-projek/{id}', [proyekController::class, 'update'])->middleware('role:admin,superadmin')->name('projek.update');
    route::delete('/inventory-projek/{id}', [proyekController::class, 'destroy'])->middleware('role:superadmin')->name('projek.hapus');
    Route::post('/inventory-projekt/import', [proyekController::class, 'import'])->middleware('role:admin,superadmin')->name('projeks.import');
    Route::get('/inventory-projek/export', [proyekController::class, 'export'])->name('projeks.export');
    route::get('/inventoty-projek/filter', [proyekController::class, 'filter'])->name('projek.filter');
    Route::get('/inventory-projek/get-detail', [proyekController::class, 'getDetail'])->name('projek.getDetail');

    // ===============================
// DO MANAGEMENT (YEAR BASED)
// ===============================

    Route::get('/inventory-do/{year}', [DoController::class, 'index'])
        ->name('view-do');

    Route::post('/inventory-do/{year}/add', [DoController::class, 'store'])
        ->middleware('role:admin,superadmin')
        ->name('do.store');

    Route::put('/inventory-do/{id}', [DoController::class, 'update'])
        ->middleware('role:admin,superadmin')
        ->name('do.update');

    Route::delete('/inventory-do/{id}', [DoController::class, 'destroy'])
        ->middleware('role:superadmin')
        ->name('do.destroy');

    Route::post('/inventory-do/{id}/upload', [DoController::class, 'uploadFile'])
        ->middleware('role:admin,superadmin')
        ->name('inventory-do.upload');

    Route::post('/inventory-do/upload/{id}', [DoController::class, 'uploadFile'])
        ->middleware('role:admin,superadmin')
        ->name('upload-do-file');

    Route::post('/inventory-do/reorder', [DoController::class, 'reorder'])
        ->middleware('role:admin,superadmin')
        ->name('inventory-do.reorder');

    Route::delete('/inventory-do/file/{id}', [DoController::class, 'deleteFile'])
        ->middleware('role:superadmin')
        ->name('inventory-do.file.delete');

});
