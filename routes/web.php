<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('auth.register');
})->name('auth.register');

Route::get('/login', function () {
    return view('auth.login');
})->name('auth.login');

Route::post('/register_user', [UserController::class, 'register_user'])->name('register_user');
Route::post('/login_user', [UserController::class, 'login_user'])->name('login_user');



Route::post('/admin_login', [AdminController::class, 'admin_login'])->name('admin_login');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/adminlogin', function () {
        return view('admin.adminlogin');
    })->name('adminlogin');
    Route::get('/addbooks', [AdminController::class, 'addbooks'])->name('addbooks');
    Route::get('/getAllBooks', [AdminController::class, 'getAllBooks'])->name('getAllBooks');
    Route::post('/addBook', [AdminController::class, 'addBook']);
    Route::post('/deleteBook', [AdminController::class, 'deleteBook']);
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/getAllUsers', [AdminController::class, 'getAllUsers'])->name('getAllUsers');
    Route::post('/deleteUser', [AdminController::class, 'deleteUser']);
    Route::get('/bookDetails', [AdminController::class, 'bookDetails'])->name('bookDetails');
    Route::get('/book_details', [AdminController::class, 'book_details'])->name('book_details');
    // Other admin routes
});
// Route::get('/addbooks', [AdminController::class, 'addbooks'])->name('addbooks');


Route::prefix('user')->name('user.')->group(function () {
    Route::get('/books', [BookController::class, 'books'])->name('books');
    Route::post('/getBooks', [BookController::class, 'getBooks']);
    Route::post('/borrowBook', [BookController::class, 'borrowBook']);
    Route::post('/returnBook', [BookController::class, 'returnBook']);
});