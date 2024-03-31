<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\customer\customerprof;
use App\Http\Controllers\customer\ShopController;
use App\Http\Controllers\IndivProductController;
use App\Http\Controllers\OrderController;
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
//admin dashboard (Admin side)
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard']);
    Route::get('/mark-notification-read/{id}', [NotificationController::class, 'markNotificationAsRead'])
    ->name('markNotificationRead');
    Route::get('product', [ProductController::class, 'product']);
    Route::post('admin/products', [ProductController::class, 'store'])->name('products.store');
});

Route::prefix('/brands')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/index', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/store', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/{brand}/update', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');
});

Route::prefix('/products')->group(function () {
    Route::get('/{product}', [IndivProductController::class, 'index'])->name('products.info');
    Route::get('/{product}/order', [OrderController::class, 'create'])->name('products.order');
    Route::POST('/store', [OrderController::class, 'store'])->name('orders.store');
});

Route::prefix('/carts')->group(function () {
    Route::GET('/{id}/add', [CartController::class, 'add_cart'])->name('cart.add');
});
//pagtapos ma verify sa maitrap ma vevverify na sya sa navbar ng admin dashboard
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // This will mark the email as verified

    return redirect('/home'); // Redirect the user after verification
})->middleware(['auth', 'signed'])->name('verification.verify');

//==========================================================================================



//==========================================================================================
//(Customer side)
Route::get('customer/cusmanage', [customerprof::class, 'customerprof']);
//customer profile
Route::put('customer/profile/update', [customerprof::class, 'update'])->name('customer.profile.update');
Route::get('customer/shop', [ShopController::class, 'shop']);
//==========================================================================================
