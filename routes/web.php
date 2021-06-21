<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkspacesController;
use App\Models\DataSource;
use App\Models\Plan;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Workspace;
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

    Route::get('/', function() { return redirect()->to('/login'); });

    // Routes for login, register your supplier and recover password
    Route::get('/login', function($subdomain) { return view('login')->with('subdomain', $subdomain); })->name('login');
    Route::post('/login', [Controller::class, 'postLogin']);

    Route::get('/register', function($subdomain) { return view('register')->with('subdomain', $subdomain); })->name('register');
    Route::post('/register', [Controller::class, 'postRegister']);

    Route::get('/recovery-password', function($subdomain) { return view('recovery-password')->with('subdomain', $subdomain); })->name('recovery-password');
    Route::post('/recovery-password', [Controller::class, 'postRecoveryPassword']);

    Route::get('/reset-password/{token}', function($subdomain, $token) { return view('reset-password')->with('subdomain', $subdomain)->with('token', $token); })->name('reset-password');
    Route::post('/reset-password', [Controller::class, 'postResetPassword']);

    Route::middleware('super')->prefix('admin')->group(function() {
        Route::get('/dashboard', function ($subdomain) { return view('dashboard')->with('subdomain', $subdomain); });
        Route::get('/my-profile', function($subdomain) { return view('my-profile')->with('subdomain', $subdomain)->with('user', User::find(Auth::id())); })->name('profile');
        Route::post('/my-profile', [Controller::class, 'postProfile']);
        Route::get('/logout', function() { Auth::logout(); return redirect('/login'); })->name('logout');
        Route::get('/verify-account', [Controller::class, 'getVerifyAccount'])->name('verify-account');
        Route::post('/verify-account', [Controller::class, 'postVerifyAccount']);
        Route::get('/users', function($subdomain) { return view('super.users.list')->with('subdomain', $subdomain)->with('users', User::all()); });
        Route::get('/user', function($subdomain) { return view('super.users.new')->with('subdomain', $subdomain)->with('roles', Role::all()); });
        Route::get('/user/{id}/{action}', [UserController::class, 'changeStatus']);
        Route::post('/user', [UserController::class, 'create']);
        Route::get('/suppliers', function($subdomain) { return view('super.suppliers.list')->with('subdomain', $subdomain)->with('suppliers', Supplier::all()); });
        Route::get('/supplier', function($subdomain) { return view('super.suppliers.new')->with('subdomain', $subdomain); });
        Route::get('/supplier/{id}', function($subdomain, $supplierId) { return view('super.suppliers.edit')->with('subdomain', $subdomain)->with('plans', Plan::all())->with('supplier', Supplier::find($supplierId)); });
        Route::get('/supplier/{id}/{action}', [SupplierController::class, 'changeStatus']);
        Route::post('/supplier', [SupplierController::class, 'save']);
        Route::get('/settings', function($subdomain) { return view('super.settings.get')->with('subdomain', $subdomain); });
    });

    // Main Menu actions covered by Auth middleware
    Route::middleware(['auth'])->group(function() {
        Route::get('/dashboard', function ($subdomain) { return view('dashboard')->with('subdomain', $subdomain); });
        Route::get('/my-profile', function($subdomain) { return view('my-profile')->with('subdomain', $subdomain)->with('user', User::find(Auth::id())); })->name('profile');
        Route::post('/my-profile', [Controller::class, 'postProfile']);
        Route::get('/logout', function() { Auth::logout(); return redirect('/login'); })->name('logout');
        Route::get('/verify-account', [Controller::class, 'getVerifyAccount'])->name('verify-account');
        Route::post('/verify-account', [Controller::class, 'postVerifyAccount']);

        Route::middleware('scope')->group(function () {
            Route::get('/users', function($subdomain) { return view('users.list')->with('subdomain', $subdomain)->with('users', User::findBySubdomain($subdomain)); });
            Route::get('/user', function($subdomain) { return view('users.new')->with('subdomain', $subdomain)->with('roles', Role::all()); });
            Route::get('/user/{id}/{action}', [UserController::class, 'changeStatus']);
            Route::post('/user', [UserController::class, 'create']);
        });

        // Settings routes
        Route::get('/settings', function($subdomain) { return view('settings.get')->with('subdomain', $subdomain); });

        // Workspaces routes
        Route::get('/workspaces', function ($subdomain) { return view('workspaces.list')->with('subdomain', $subdomain)->with('workspaces', Workspace::getBySubdomain($subdomain)); });
        Route::get('/workspaces/{id}', [WorkspacesController::class, 'getWorkspace']);
        Route::get('/workspace', function ($subdomain) { return view('workspaces.new')->with('subdomain', $subdomain)->with('data_sources', DataSource::all()); });
        Route::post('/workspace', [WorkspacesController::class, 'create']);

    });
});

// Single landing page
Route::get('/', function () { return view('welcome'); });
Route::get('/signup', function () { return view('signup')->with('plans', Plan::all()); });
Route::post('/signup', [Controller::class, 'signup']);
