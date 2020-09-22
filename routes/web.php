<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StartupController;
use App\Http\Controllers\UsersController;
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

// DELELETE THIS ROUTE
Route::get('/sess',[LoginController::class,'view_session']);




Route::get('/login',[LoginController::class,'index'])->name('login.index');

Route::post('/login',[LoginController::class,'login'])->name('login.login');

Route::get('/logout',[LoginController::class,'logout'])->name('login.logout');

Route::group(['middleware' => 'islogged'], function () {


    /* MASTER */
    Route::get("/",[StartupController::class,'index'])->name('startup.index');

    /* DASHBOARD */
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard.index');

    /* USERS CONTROLLER */
    Route::get('/users',[UsersController::class,'index'])->name('users.index');

        /* USERS TYPE */
        Route::get('/users-type',[UsersController::class,'data_user_type'])->name('users.type');

        Route::post('/users-type',[UsersController::class,'users_type_add'])->name('users.type.add');

        Route::delete('/users-type',[UsersController::class,'users_type_delete'])->name('users.type.delete');

        /* USERS */
        Route::get('/users-list',[UsersController::class,'data_user_list'])->name('users.list');

        Route::post('/users-list-add',[UsersController::class,'users_list_add'])->name('users.list.add');

});
