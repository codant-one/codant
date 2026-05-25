<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Template Routes
|--------------------------------------------------------------------------
|
| Estas rutas son para el template de demostración.
| Todas estarán prefijadas con /template/
|
*/

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang'])->name('template.lang');

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('template.root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('template.updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('template.updatePassword');

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('template.index')->where('any', '.*');
