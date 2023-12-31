<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    MainController,
    LocalizationController
};
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


Route::get('/',  [MainController::class, 'index'])->name('index');
Route::post('/register', [MainController::class, 'store'])->name('main.store');


 /* TRANSLATE */
 Route::get('lang/{locale}', [LocalizationController::class, 'index'])->name('translate.index');
