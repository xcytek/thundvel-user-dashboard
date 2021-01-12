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

Route::domain('{supplier}.' . env('APP_DOMAIN'))->group(function() {

    // Routes for login, register your supplier and recover password
    Route::get('/login', function($supplier) { return view('login')->with('supplier', $supplier); })->name('login');
    Route::post('/login', [Controller::class, 'postLogin']);

    Route::get('/register', function($supplier) { return view('register')->with('supplier', $supplier); })->name('register');
    Route::post('/register', [Controller::class, 'postRegister']);

    Route::get('/recovery-password', function($supplier) { return view('recovery-password')->with('supplier', $supplier); })->name('recovery-password');
    Route::post('/recovery-password', [Controller::class, 'postRecoveryPassword']);

    Route::get('/reset-password/{token}', function($supplier, $token) { return view('reset-password')->with('supplier', $supplier)->with('token', $token); })->name('reset-password');
    Route::post('/reset-password', [Controller::class, 'postResetPassword']);

    // Main Menu actions covered by Auth middleware
    Route::middleware(['auth'])->group(function() {
        Route::get('/dashboard', function ($supplier) { return view('dashboard')->with('supplier', $supplier); });
        Route::get('/my-profile', function($supplier) { return view('my-profile')->with('supplier', $supplier)->with('user', User::find(Auth::id())); })->name('profile');
        Route::post('/my-profile', [Controller::class, 'postProfile']);
        Route::get('/logout', function() { Auth::logout(); return redirect('/login'); })->name('logout');
        Route::get('/verify-account', [Controller::class, 'getVerifyAccount'])->name('verify-account');
        Route::post('/verify-account', [Controller::class, 'postVerifyAccount']);
    });
});

// Single landing page
Route::get('/', function () { return view('welcome'); });