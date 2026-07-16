<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentDataController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Models\Setting;
use App\Http\Controllers\Controller;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/auth', [UserController::class, 'auth']);

Route::post('/logout', function( Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->middleware('auth')->name('logout');

Route::get('/dashboard', function () {
    $setting = Controller::getVerse();
    return view('admin.dashboard', compact('setting'));
})->middleware('auth')->name('admin.dashboard');

Route::resource('meetings', MeetingController::class)->middleware('auth');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::get('/users/{user}/changepass', [UserController::class, 'changepassword'])->name('users.changepassword');
Route::put('/users/{user}/updatepass', [UserController::class, 'updatepassword'])->name('users.updatepassword');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/courses', [CourseController::class, 'index'])->middleware('auth')->name('course.index');
Route::get('/courses/create', [CourseController::class, 'create'])->middleware('auth')->name('course.create');
Route::post('/courses', [CourseController::class, 'store'])->name('course.store');
Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('course.edit');
Route::put('/courses/{course}', [CourseController::class, 'update'])->name('course.update');
Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('course.destroy');

Route::get('/package', [TermController::class, 'index'])->middleware('auth')->name('term.index');
Route::get('/package/create', [TermController::class, 'create'])->middleware('auth')->name('term.create');
Route::post('/package', [TermController::class, 'store'])->name('term.store');
Route::get('/package/{term}/edit', [TermController::class, 'edit'])->name('term.edit');
Route::put('/package/{term}', [TermController::class, 'update'])->name('term.update');
Route::delete('/package/{term}', [TermController::class, 'destroy'])->name('term.destroy');

Route::get('/student', [StudentDataController::class, 'index'])->middleware('auth')->name('student-data.index');
Route::get('/student/{student}/edit', [StudentDataController::class, 'edit'])->name('student-data.edit');
Route::put('/student/{student}', [StudentDataController::class, 'update'])->name('student-data.update');
Route::delete('/student/{student}', [StudentDataController::class, 'destroy'])->name('student-data.destroy');

Route::get('/transaction', [TransactionController::class, 'index'])->middleware('auth')->name('transaction.index');
Route::get('/transaction/create', [TransactionController::class, 'create'])->middleware('auth')->name('transaction.create');
Route::post('/transaction', [TransactionController::class, 'store'])->middleware('auth')->name('transaction.store');
Route::get('/transaction/{transaction}/edit', [TransactionController::class, 'edit'])->middleware('auth')->name('transaction.edit');
Route::put('/transaction/{transaction}/update', [TransactionController::class, 'update'])->middleware('auth')->name('transaction.update');
Route::delete('/transaction/{transaction}', [TransactionController::class, 'destroy'])->middleware('auth')->name('transaction.destroy');


// Parent Dashboard
Route::get('/parents', [ParentController::class, 'index'])->name('parent.index');

Route::get('/parents/child', [ParentController::class, 'childindex'])->name('parent.child.index');
Route::get('/parents/child/create', [ParentController::class, 'childcreate'])->name('parent.child.create');
Route::post('/parents/child', [ParentController::class, 'childstore'])->name('parent.child.store');
Route::get('/parents/child/{child}/edit', [ParentController::class, 'childedit'])->name('parent.child.edit');
Route::put('/parent/child/{child}', [ParentController::class, 'childupdate'])->name('parent.child.update');
Route::delete('/parent/child/{child}', [ParentController::class, 'childdestroy'])->name('parent.child.destroy');
Route::delete('/parent/child/{child}/changepass', [ParentController::class, 'childchangepassword'])->name('parent.child.changepassword');
Route::delete('/parent/child/{child}/updatepass', [ParentController::class, 'childupdatepassword'])->name('parent.child.updatepassword');

Route::get('/parents/transaction', [ParentController::class, 'enrollindex'])->name('parent.transaction.index');
Route::get('/parents/transaction/create', [ParentController::class, 'enrollcreate'])->name('parent.transaction.create');
Route::post('/parents/transaction', [ParentController::class, 'enrollstore'])->name('parent.transaction.store');

Route::get('/parents/schedule', [ParentScheduleController::class, 'index'])->name('parent.schedule.index');
Route::get('/parents/report', [ParentReportController::class, 'index'])->name('parent.report.index');

// Student Dashboard
Route::get('/students', [StudentController::class, 'index'])->name('student.index');


// Teacher Dashboard
Route::get('/teachers', [TeacherController::class, 'index'])->name('teacher.index');

//API
Route::get('/parents/{parent}/students', [ParentController::class, 'students'])->name('parent.students');

// Misc
Route::get('/profile-picture', [UserController::class, 'editProfilePictureForm'])->name('users.profile.edit');
Route::post('/profile-picture', [UserController::class, 'updateProfilePicture'])->name('users.profile.update');
