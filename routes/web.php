<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackController;

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
    return view('initial');
});

Route::controller(BackController::class)->group(function () {

    Route::get('initial', 'index')->name('initial');

    Route::get("login", 'login')->name('login');

    Route::get('registration1', 'registration1')->name('registration1');
    Route::get('registration2', 'registration2')->name('registration2');

    Route::get('logout', 'logout')->name('logout');

    Route::post('validate_registration', 'validate_registration')->name('sample.validate_registration');

    Route::post('validate_registration2', 'validate_registration2')->name('sample.validate_registration2');

    Route::get("validate_initial", "validate_initial")->name("sample.validate_initial");

    Route::post('validate_login', 'validate_login')->name('sample.validate_login');

    Route::get('dashboard', 'dashboard')->name('dashboard');

    Route::get('validate_back', 'validate_back')->name('validate_back');

});
