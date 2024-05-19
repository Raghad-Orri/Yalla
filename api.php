<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/registration', [App\Http\Controllers\StudentsController::class, 'registration'])-> name('registration');
Route::post('/attendance', [App\Http\Controllers\AttendanceController::class, 'attendance'])-> name('attendance');
Route::get('/show', [App\Http\Controllers\AttendanceController::class, 'show'])-> name('show');

Route::post('/change', [App\Http\Controllers\StudentsController::class, 'change'])-> name('change');

Route::post('/applogin', [App\Http\Controllers\StudentsController::class, 'applogin'])-> name('applogin');

Route::post('/payment', [App\Http\Controllers\StudentsController::class, 'payment'])-> name('payment');

Route::post('/students', [App\Http\Controllers\StudentsController::class, 'students'])-> name('students');

Route::post('/pickUp', [App\Http\Controllers\StudentsController::class, 'pickUp'])-> name('pickUp');

Route::post('/stuid', [App\Http\Controllers\StudentsController::class, 'stuid'])-> name('stuid');

Route::post('/Charge', [App\Http\Controllers\StudentsController::class, 'Charge'])-> name('Charge');

Route::get('/studentCall', [App\Http\Controllers\AttendanceController::class, 'studentCall'])-> name('studentCall');

Route::get('/studentCallpage', [App\Http\Controllers\AttendanceController::class, 'studentCallpage'])-> name('studentCallpage');


Route::post('/signup', [App\Http\Controllers\TeachersController::class, 'signup'])-> name('signup');

Route::post('/changeT', [App\Http\Controllers\TeachersController::class, 'change'])-> name('changeT');

Route::post('/apploginT', [App\Http\Controllers\TeachersController::class, 'applogin'])-> name('apploginT');

Route::get('/studentCallApp', [App\Http\Controllers\AttendanceController::class, 'studentCallApp'])-> name('studentCallApp');

Route::get('/studentCallApp1', [App\Http\Controllers\AttendanceController::class, 'studentCallApp1'])-> name('studentCallApp1');

Route::post('/autho', [App\Http\Controllers\AuthorizedController::class, 'store'])-> name('autho');

Route::post('/reg', [App\Http\Controllers\AuthorizedController::class, 'signup'])-> name('reg');

Route::post('/authch', [App\Http\Controllers\AuthorizedController::class, 'change'])-> name('authch');

Route::post('/authstudents', [App\Http\Controllers\AuthorizedController::class, 'students'])-> name('authstudents');

Route::post('/authlog', [App\Http\Controllers\AuthorizedController::class, 'applogin'])-> name('authlog');

Route::post('/message', [App\Http\Controllers\MessagesController::class, 'index'])-> name('message');

Route::post('/vibration', [App\Http\Controllers\AttendanceController::class, 'vibration'])-> name('vibration');







Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
