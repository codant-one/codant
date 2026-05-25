<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Testing\TestingController;

use App\Http\Controllers\Auth\{
    AuthController, 
    PasswordResetController
};

use App\Http\Controllers\Admin\{
    DashboardController,
    UserController,
    RolController,
    PermissionController,
    ProvinceController,
    CityController
};

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


 // Ruta de fallback
Route::fallback(function () {
    return redirect('/admin');
});
    
Route::group(['namespace' => 'Auth', 'as'=>'password.'], function () {
    Route::get('password/find/{token}', [PasswordResetController::class, 'find'])->name("admin.find");
    Route::get('/admin/forgot-password', [PasswordResetController::class, 'forgot_password'])->name('admin.forgot.password');
    Route::post('/admin/reset-confirm', [PasswordResetController::class, 'email_confirmation'])->name('admin.confirm');
    Route::get('/admin/reset-password', [PasswordResetController::class, 'reset_password'])->name('admin.reset.password');
    Route::post('/admin/change', [PasswordResetController::class, 'change'])->name("admin.change");
});

Route::name('auth.')->group(function () {
    Route::get('/admin', [AuthController::class, 'login'])->name('login');
    Route::get('/admin/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/admin/login', [AuthController::class, 'authenticate'])->name('authenticate');
});

Route::name('auth.')->middleware(['auth:web'])->group(function () {
    Route::get('/admin/2fa', [AuthController::class, 'double_factor_auth'])->name('2fa');
    Route::get('/admin/2fa/generar', [AuthController::class, 'generate_double_factor_auth'])->name('2fa.generate');
    Route::post('/admin/2fa/validate', [AuthController::class, 'validate_double_factor_auth'])->name('2fa.validate');
});

Route::middleware(['auth:web', '2fa:web', 'check.session'])->prefix('admin')->group(function () {

    /* RESOURCES */
    Route::resources([
        'users' => UserController::class,
        'roles'             => RolController::class,
        'permissions'     => PermissionController::class,
        'genders' => GenderController::class
    ]);

    /* DASHBOARD */
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');
        
    /* AUTH */
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'profileStore'])->name('profileStore');
    Route::post('/profile/updatePassword', [AuthController::class, 'updatePassword'])->name('updatePassword');
    Route::post('/profile/updateAvatar', [AuthController::class, 'updateAvatar'])->name('updateAvatar');
    Route::post('/profile/logout-session/{sessionId}', [AuthController::class, 'logoutSession'])->name('logoutSession');
    Route::post('/profile/logout-all-sessions', [AuthController::class, 'logoutAllSessions'])->name('logoutAllSessions');
    Route::post('/profile/delete', [AuthController::class, 'deleteAccount'])->name('deleteAccount');
    
    /* PROVINCES */
    Route::get('/provinces/country/{id}', [ProvinceController::class, 'provincesByCountryId'])->name('provinces.provincesByCountryId');

    /* CITIES */
    Route::get('/cities/province/{id}', [CityController::class, 'citiesByProvinceId'])->name('cities.citiesByProvinceId');
});

Route::get('emails', [TestingController::class , 'emails'])->name('emails');

Route::get('assets/json/{filename}', function ($filename) {
    $path = public_path('build/json/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
});

Route::get('assets/images/{path}', function ($path) {
    $path = public_path('build/images/' . $path);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
})->where('path', '.*');

Route::get('assets/js/pages/plugins/json/{filename}', function ($filename) {
    $path = public_path('build/js/pages/plugins/json/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
});

/*
|--------------------------------------------------------------------------
| TEMPLATE Routes
|--------------------------------------------------------------------------
|
*/

//solo para el template de demostración
Route::prefix('template')->group(function () {
    Auth::routes();
});

Route::get('/landing-template', function () {
    return view('welcome');
});
