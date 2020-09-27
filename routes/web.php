<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterListController;
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
        Route::get('/users-type',[UsersController::class,'users_type_data'])->name('users.type');

            /* USERS TYPE ACTION */
            Route::post('/users-type',[UsersController::class,'users_type_add'])->name('users.type.add');

            Route::delete('/users-type',[UsersController::class,'users_type_delete'])->name('users.type.delete');

            Route::put('/users-type',[UsersController::class,'users_type_edit'])->name('users.type.edit');

            Route::put('/users-type-access',[UsersController::class,'users_type_access_edit'])->name('users.type.access');

        /* USERS */
        Route::get('/users-list',[UsersController::class,'users_list_data'])->name('users.list');

            /* USERS ACTION */
            Route::put('/users-list',[UsersController::class,'users_list_edit'])->name('users.list.edit');

            Route::post('/users-list',[UsersController::class,'users_list_add'])->name('users.list.add');

            Route::delete('/users-list',[UsersController::class,'users_list_delete'])->name('users.list.delete');

            Route::put('/users-list-lock',[UsersController::class,'users_list_lock'])->name('users.list.lock');

            Route::put('/users-list-unlock',[UsersController::class,'users_list_unlock'])->name('users.list.unlock');

            Route::put('/users-list-reset',[UsersController::class,'users_list_reset'])->name('users.list.reset');

            Route::put('/users-list-access',[UsersController::class,'users_list_access_edit'])->name('users.list.access');


    /* MASTER LIST */
    Route::get('/master',[MasterListController::class,'index'])->name('master.index');



});
