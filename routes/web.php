<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\TransactionController;


// Route::domain('localhost')->group(function () {
//     Route::get('/', function () {
//         return view('welcome');
//     });

//     Route::get('/home', [HomeController::class, 'index'])->name('home');
// });

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('car', CarController::class);

// Route::get('/user', [UserController::class, 'Index'])->name('user');

// Route login utama
// Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('login', [LoginController::class, 'login'])->name('login');
// Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('register', [RegisterController::class, 'register']);


// Route::middleware(['auth.web'])->group(function(){
//     Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
//     Route::post('/user/rent/{id}', [UserController::class, 'rental'])->name('user.rental');
// });

// Route::middleware(['auth.admin'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
// });

//Users Routes

// User domain routes
// Route::domain('user.localhost')->group(function () {

// Route::middleware(['auth', 'user-access:user'])->group(function () {
//     Route::get('/user', [UserController::class, 'Index'])->name('user');

//     // Rental routes
//     Route::get('/rental/order/{carId}', [RentalController::class, 'order'])->name('rental.order');
//     Route::post('/rental/store', [RentalController::class, 'store'])->name('rental.store');

//     // Payment routes
//     Route::get('/rental/payment/{rentalId}', [TransactionController::class, 'showPaymentForm'])->name('user.payment.form');
//     Route::post('/rental/payment/{rentalId}', [TransactionController::class, 'processPayment'])->name('user.payment.process');
// });

Route::middleware(['auth', 'user-access:user'])->group(function () {
    // User Dashboard
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/history', [UserController::class, 'history'])->name('history');

    // Rental Management
    Route::prefix('rental')->name('rental.')->group(function () {
        // Rental Order Routes
        Route::get('/order/{carId}', [RentalController::class, 'order'])->name('order');
        Route::post('/store', [RentalController::class, 'store'])->name('store');

        Route::get('/success/{rentalId}', [TransactionController::class, 'rentalSuccess'])->name('success');
        Route::get('/receipt/{rentalId}', [TransactionController::class, 'printReceipt'])->name('receipt');

        Route::get('/return/{carId}', [TransactionController::class, 'returnForm'])->name('returnForm');
        Route::post('/return/{carId}', [TransactionController::class, 'processReturn'])->name('processReturn');

        // Payment Management Routes
        Route::prefix('payment')->name('payment.')->group(function () {
            Route::get('/{rentalId}', [TransactionController::class, 'showPaymentForm'])->name('form');
            Route::post('/{rentalId}', [TransactionController::class, 'processPayment'])->name('process');
        });
    });
});



// admin Routes

// Route::domain('admin.localhost')->group(function () {
Route::middleware(['auth', 'auth.admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/history', [AdminController::class,'index'])->name('admin.history');
});
// });

