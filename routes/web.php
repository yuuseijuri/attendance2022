<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.register');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', [AttendanceController::class, 'index'])->name('home');
    
    Route::post('/home/jobIN', [AttendanceController::class, 'jobIn'])->name('home/jobIn');
    Route::post('/home/jobOut', [AttendanceController::class, 'jobOut'])->name('home/jobOut');

    Route::post('/home/restIn', [AttendanceController::class, 'restIn'])->name('home/restIn');
    Route::post('/home/restOut', [AttendanceController::class, 'restOut'])->name('home/restOut');

    Route::post('/date', [AttendanceController::class, 'store'])->name('date');

    Route::get('/date/{date}', [AttendanceController::class, 'show'])->name('date');

    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy']);
});

require __DIR__.'/auth.php';
