<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionHeaderController;
use App\Http\Controllers\TransactionDetailController;
use App\Http\Controllers\MeetingController;
use App\Models\Setting;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/auth', [UserController::class, 'auth']);

Route::get('/dashboard', function () {
    $setting = Setting::first();
    return view('admindashboard', compact('setting'));
})->middleware('auth')->name('admin-dashboard');

Route::resource('transaction-headers', TransactionHeaderController::class)->middleware('auth');

Route::resource('transaction-details', TransactionDetailController::class)->middleware('auth');

Route::get('/admin/transactions', [TransactionHeaderController::class, 'admin'])->middleware('auth')->name('admin.transactions');

Route::resource('meetings', MeetingController::class)->middleware('auth');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/parents/register', [UserController::class, 'openParentRegisterForm'])->name('parents.register.form');
Route::post('/parents/register', [UserController::class, 'openParentRegister'])->name('parents.register');
Route::get('/parents/register-children', [UserController::class, 'parentRegisterChildrenForm'])->name('parents.register.children.form');
Route::post('/parents/register-children', [UserController::class, 'parentRegisterChildren'])->name('parents.register.children');

Route::get('/profile-picture', [UserController::class, 'editProfilePictureForm'])->name('users.profile.edit');
Route::post('/profile-picture', [UserController::class, 'updateProfilePicture'])->name('users.profile.update');
