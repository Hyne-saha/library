<?php
use App\Http\Controllers\UserController;
// use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use \App\Http\Middleware\VerifyCsrfToken;

use Illuminate\Support\Facades\Route;


Route::post('/register_user', [UserController::class, 'register_user'])->name('register_user');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/getAllBooks', [AdminController::class, 'getAllBooks']);
    Route::post('/addBook', [AdminController::class, 'addBook']);
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/getAllUsers', [AdminController::class, 'getAllUsers'])->name('getAllUsers');
    // Other admin routes
});

Route::prefix('user')->name('user.')->group(function () {
    Route::post('/getBooks', [BookController::class, 'getBooks']);
    
});

?>