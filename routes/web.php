<?php

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Single landing page
Route::get('/', function () { return view('welcome'); });

// Routes for login, register your supplier and recover password
Route::get('/login', function() { return view('login'); })->name('login');
Route::post('/login', [Controller::class, 'postLogin']);

Route::get('/register', function() { return view('register'); })->name('register');
Route::post('/register', [Controller::class, 'postRegister']);

Route::get('/recovery-password', function() { return view('recovery-password'); })->name('recovery-password');
Route::post('/recovery-password', [Controller::class, 'postRecoveryPassword']);

Route::get('/reset-password/{token}', function($token) { return view('reset-password')->with('token', $token); })->name('reset-password');
Route::post('/reset-password', [Controller::class, 'postResetPassword']);

// Main Menu actions covered by Auth middleware
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', function () { return view('dashboard'); });
    Route::get('/my-profile', function() { return view('my-profile')->with('user', User::find(Auth::id())); })->name('profile');
    Route::post('/my-profile', [Controller::class, 'postProfile']);
    Route::get('/logout', function() { Auth::logout(); return redirect('/login'); })->name('logout');
});
