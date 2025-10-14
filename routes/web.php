<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    MainController,
    LocalizationController,
    UserController,
    RolController,
    PermissionController,
    DashboardController,
    ProvinceController,
    CityController,
    TestingController
};

use App\Http\Controllers\Auth\{
    AuthController, 
    PasswordResetController
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

// Ruta de fallback
Route::fallback(function () {
    return redirect('/admin');
});

/* PUBLIC */
Route::get('/',  [MainController::class, 'index'])->name('index');
Route::post('/register', [MainController::class, 'store'])->name('main.store');

/* TRANSLATE */
Route::get('lang/{locale}', [LocalizationController::class, 'index'])->name('translate.index');

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

Route::middleware(['auth:web', '2fa:web'])->prefix('admin')->group(function () {

    Route::resources([
        'users' => UserController::class,
        'roles'             => RolController::class,
        'permissions'     => PermissionController::class,
    ]);

    /* DASHBOARD */
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');
        
    /* AUTH */
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'profileStore'])->name('profileStore');
    Route::post('/profile/updatePassword', [AuthController::class, 'updatePassword'])->name('updatePassword');

    /* PROVINCES */
    Route::get('/provinces/country/{id}', [ProvinceController::class, 'provincesByCountryId'])->name('provinces.provincesByCountryId');

    /* CITIES */
    Route::get('/cities/province/{id}', [CityController::class, 'citiesByProvinceId'])->name('cities.citiesByProvinceId');

});

/* TESTING */
Route::get('/testing', [TestingController::class, 'emails'])->name('testing.emails');

// Localization
Route::get('/js/lang.js', function () {
    $lang = 'es'; 

    $files   = glob(resource_path('lang/' . $lang . '/js_common.php'));
    $strings = [];

    foreach ($files as $file) {
        $name           = basename($file, '.php');
        $strings[$name] = require $file;
    }

    header('Content-Type: text/javascript');
    echo('window.lang = ' . json_encode($strings) . ';');
    exit();
})->name('assets.lang');
