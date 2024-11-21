<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('car', CarController::class);

Route::get('user', [UserController::class, 'Index'])->name('user.index');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::resource('user', UserController::class);

Route::middleware(['auth.web'])->group(function(){
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::post('/user/rent/{id}', [UserController::class, 'rental'])->name('user.rental');
});

Route::middleware(['auth.admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});


// Users Routes

// Route::middleware(['auth', 'user-access:user'])->group(function () {
  
//     Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
// });

// // admin Routes

// Route::middleware(['auth', 'user-access:admin'])->group(function () {
  
//     Route::get('/admin/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
// });  