<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\VerificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


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

//==========================================================================================
//after ma very mapupunta sa home
Auth::routes(['verify' => true]);
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('verified');
//==========================================================================================


//==========================================================================================
//admin dashboard
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard']);
    Route::get('/mark-notification-read/{id}', [NotificationController::class, 'markNotificationAsRead'])
    ->name('markNotificationRead');

});
//==========================================================================================



//==========================================================================================
//pagtapos ma verify sa maitrap ma vevverify na sya sa navbar ng admin dashboard
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // This will mark the email as verified

    return redirect('/home'); // Redirect the user after verification
})->middleware(['auth', 'signed'])->name('verification.verify');

//==========================================================================================
