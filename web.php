<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/t', function () {
    return view('test');
}) ->name('te');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/Studentsreg', [App\Http\Controllers\StudentsController::class, 'index'])->name('Studentsreg');

Route::post('/Studentregs', [App\Http\Controllers\StudentsController::class, 'store'])-> name('Studentregs');

Route::get('/attendanceview/{StudentID}', [App\Http\Controllers\AttendanceController::class, 'attendanceview'])-> name('attendanceview');

Route::get('/deletestudent/{id}', [App\Http\Controllers\StudentsController::class, 'deletestudent'])-> name('deletestudent');

Route::post('/search', [App\Http\Controllers\HomeController::class, 'search'])-> name('search');

Route::get('/searchg/{query}', [App\Http\Controllers\HomeController::class, 'searchg'])-> name('searchg');

Route::get('/studentCall', [App\Http\Controllers\AttendanceController::class, 'studentCall'])-> name('studentCall');

Route::get('/studentCallpage', [App\Http\Controllers\AttendanceController::class, 'studentCallpage'])-> name('studentCallpage');

Route::get('/teachereg', [App\Http\Controllers\TeachersController::class, 'index'])-> name('teachereg');

Route::post('/teacheregs', [App\Http\Controllers\TeachersController::class, 'store'])-> name('teacheregs');

Route::get('/page', [App\Http\Controllers\MessagesController::class, 'page'])-> name('page');

Route::get('/pagedata', [App\Http\Controllers\MessagesController::class, 'pagedata'])-> name('pagedata');

Route::get('/pagedata1', [App\Http\Controllers\MessagesController::class, 'pagedata1'])-> name('pagedata1');

Route::post('/message', [App\Http\Controllers\MessagesController::class, 'index'])-> name('message');




