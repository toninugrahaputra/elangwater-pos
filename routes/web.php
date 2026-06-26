<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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

// Authentication Routes (Guest only)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Protected Routes (Authenticated only)
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        $user = auth()->user();

        // Load roles and permissions for the user
        if ($user) {
            $user->load(['roles', 'permissions']);
        }

        return view('welcome', ['user' => $user]);
    });
});

// Redirect root to login if not authenticated (handled by middleware groups above)
// Redirect home/dashboard to root if authenticated
Route::redirect('/home', '/');