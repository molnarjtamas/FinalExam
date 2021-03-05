<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
      //  'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/holiday', function () {
    return Inertia::render('Holiday');
})->name('holiday');

Route::get('holidays',[\App\Http\Controllers\HolidayController::class,'index']);

Route::get('holidays/{user}',[\App\Http\Controllers\HolidayController::class,'show']);

Route::get('/registration/{token}',function ($token){
    return Inertia::render('Auth/Register');
})->name('registration');
Route::post('/dashboard',[\App\Http\Controllers\UserController::class,'process_invitations'])->name('user.invite');
Route::get('/roles',[\App\Http\Controllers\RoleController::class,'index']);
Route::get('/permission/{permissionName}', [\App\Http\Controllers\PermissionController::class,'check']);

//Route::POST('/registration', 'Auth\RegisterController@register')->name('accept');

