<?php

use App\Http\Controllers\HolidayController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
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
//this routes are available after authentication
Route::middleware(['auth:sanctum'])->group(function () {

    //roles and permissions related paths
    Route::get('/roles',[RoleController::class,'index']);
    Route::get('/permission/{permissionName}', [PermissionController::class,'check']);

    //user related paths
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::middleware(['can:invite-users'])
        ->post('/dashboard',[UserController::class,'process_invitations'])->name('user.invite');
    Route::get('user/permissions',[UserController::class,'get_authPerms']);


    Route::get('/holiday', function () {
        $succes = Session::get('success');
        $message = Session::get('message');

        return Inertia::render('Holiday',['success'=>$succes,'message'=> $message]);
    })->name('holiday');
    //holiday management paths for administrators
    Route::middleware(['can:view-all-holidays'])->group(function (){
        Route::get('holidays',[HolidayController::class,'index']);
        Route::get('holiday/approve/{holiday}',[HolidayController::class,'approve'])->name('holiday.approve');
        Route::get('holiday/decline/{holiday}',[HolidayController::class,'decline'])->name('holiday.decline');

    });

    //holiday management paths for employees
    Route::middleware(['can:view-own-holidays','can:take-holiday'])->group(function(){
        Route::get('holidays/{user}',[HolidayController::class,'show']);
        Route::post('/holiday',[HolidayController::class,'process_holidays'])->name('holiday.request');

    });

    //route to show the calendar
    Route::get('/calendar', function () {
        return Inertia::render('Calendar');
    })->name('calendar');

});

//the registration must be outside the auth middleware
Route::get('/registration/{token}',function ($token){
    return Inertia::render('Auth/Register');
})->name('registration');

