<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/', function(){
    return redirect()->route('employee.index');
});

Route::group(['as' => 'employee.', 'prefix' => 'employee'], function (){
    Route::get('/', [EmployeeController::class, 'index'])->name('index');
    Route::get('/show/{id}', [EmployeeController::class, 'show'])->name('show');
    Route::post('/store', [EmployeeController::class, 'store'])->name('store');
    Route::post('/update/{id}', [EmployeeController::class, 'update'])->name('update');
    Route::post('/delete/{id}', [EmployeeController::class, 'destroy'])->name('delete');
});