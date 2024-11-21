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

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::resource('car', CarController::class);

// Route::get('/user', [UserController::class, 'Index'])->name('user');

// Route login utama
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Route logout



// Route::middleware(['auth.web'])->group(function(){
//     Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
//     Route::post('/user/rent/{id}', [UserController::class, 'rental'])->name('user.rental');
// });

// Route::middleware(['auth.admin'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
// });

//Users Routes

// Subdomain untuk user
Route::domain('user.localhost')->group(function () {
    Route::middleware(['user-access:user'])->group(function () {
        Route::get('/user', [UserController::class, 'Index'])->name('user');
        Route::post('/user/rent/{id}', [UserController::class, 'rental'])->name('user.rental');
        Route::get('/rental/order/{carId}', [RentalController::class, 'order'])->name('rental.order');
        Route::post('/rental/store', [RentalController::class, 'store'])->name('rental.store');
        // Route to show the payment form
        Route::get('/rental/{rentalId}/payment', [TransactionController::class, 'showPaymentForm'])->name('user.payment.form');
        // Route to process the payment and finalize the rental
        Route::post('/rental/payment', [RentalController::class, 'processRental'])->name('user.payment.process');
    });

    // Tambahkan route user lainnya
});

// admin Routes

Route::domain('admin.localhost')->group(function () {
    Route::middleware(['auth.admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });

    // Tambahkan route admin lainnya
});

