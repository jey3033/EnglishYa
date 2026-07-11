<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TransactionHeaderController;
use App\Http\Controllers\TransactionDetailController;
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
    return view('admindashboard', compact('setting'));
})->middleware('auth')->name('admin-dashboard');

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

Route::get('/transaction', [TransactionHeaderController::class, 'index'])->middleware('auth')->name('transaction.index');

Route::get('/parents', [ParentController::class, 'index'])->name('parent.index');

Route::get('/parents/child', [ParentController::class, 'childindex'])->name('parent.child.index');
Route::get('/parents/child/create', [ParentController::class, 'childcreate'])->name('parent.child.create');
Route::post('/parents/child', [ParentController::class, 'childstore'])->name('parent.child.store');
Route::get('/parents/child/{child}/edit', [ParentController::class, 'childedit'])->name('parent.child.edit');
Route::put('/parent/child/{child}', [ParentController::class, 'childupdate'])->name('parent.child.update');
Route::delete('/parent/child/{child}', [ParentController::class, 'childdestroy'])->name('parent.child.destroy');
Route::delete('/parent/child/{child}/changepass', [ParentController::class, 'childchangepassword'])->name('parent.child.changepassword');
Route::delete('/parent/child/{child}/updatepass', [ParentController::class, 'childupdatepassword'])->name('parent.child.updatepassword');

Route::get('/parents/course', [ParentCourseController::class, 'index'])->name('parent.course.index');
Route::get('/parents/transaction', [ParentTransactionController::class, 'index'])->name('parent.transaction.index');
Route::get('/parents/schedule', [ParentScheduleController::class, 'index'])->name('parent.schedule.index');
Route::get('/parents/report', [ParentReportController::class, 'index'])->name('parent.report.index');

Route::get('/students', [StudentController::class, 'index'])->name('student.index');

Route::get('/teachers', [TeacherController::class, 'index'])->name('teacher.index');

Route::get('/profile-picture', [UserController::class, 'editProfilePictureForm'])->name('users.profile.edit');
Route::post('/profile-picture', [UserController::class, 'updateProfilePicture'])->name('users.profile.update');
