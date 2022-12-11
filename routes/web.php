<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmployeeController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'=>'role', 'middleware'=>['auth']], function () {
    Route::get('/', [RoleController::class, 'index'])->name('role.index');
    Route::get('/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/store', [RoleController::class, 'store'])->name('role.store');

    Route::get('/edit/{role}', [RoleController::class, 'edit'])->name('role.edit');
    Route::post('/update/{role}', [RoleController::class, 'update'])->name('role.update');
    Route::get('/delete/{role}', [RoleController::class, 'destroy'])->name('role.delete');
});

Route::group(['prefix'=>'employee'], function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('emp.index');
    Route::get('/create', [EmployeeController::class, 'create'])->name('emp.create');
    Route::post('/store', [EmployeeController::class, 'store'])->name('emp.store');

    Route::get('/edit/{employee}', [EmployeeController::class, 'edit'])->name('emp.edit');
    Route::post('/update/{employee}', [EmployeeController::class, 'update'])->name('emp.update');
    Route::get('/delete/{employee}', [EmployeeController::class, 'destroy'])->name('emp.delete');
});
