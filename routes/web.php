<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;

Route::get('/', [UserController::class, 'showLoginForm'])->name(name: 'out');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Routes that require user authentication
Route::middleware('userauth')->group(function () {
    Route::get('/login/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::get('/login/history', [TransactionController::class, 'showHistory'])->name('history');
        Route::get('/login/transaction', [TransactionController::class, 'showFormTransaction'])->name('transaction');
    Route::post('/login/transaction/create', [TransactionController::class, 'store'])->name('transactions.store');
    Route::post('/login/category/create', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/login/transferMoney/create', [TransactionController::class, 'transferMoney'])->name('transaction.money');
    Route::get('/transactions/monthly', [TransactionController::class, 'showMonthlyHistory'])->name('transactions.monthly');
});

