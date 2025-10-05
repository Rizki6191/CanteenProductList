<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CanteenProductController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [CanteenProductController::class, 'index'])->name('index');
Route::post('/create', [CanteenProductController::class, 'store'])->name('product.store');
Route::delete('/delete/{id}', [CanteenProductController::class, 'destroy'])->name('product.destroy');
Route::put('update/{id}', [CanteenProductController::class, 'update'])->name('product.update');