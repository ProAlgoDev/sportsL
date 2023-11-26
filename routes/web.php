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
    Route::get('registration3', 'registration3')->name('registration3');
    Route::get('logout', 'logout')->name('logout');
    Route::post('validate_registration', 'validate_registration')->name('sample.validate_registration');
    Route::post('validate_registration2', 'validate_registration2')->name('sample.validate_registration2');
    Route::get("validate_initial", "validate_initial")->name("sample.validate_initial");
    Route::post('validate_login', 'validate_login')->name('sample.validate_login');
    Route::get('validate_back', 'validate_back')->name('validate_back');
    Route::get('dashboard', 'dashboard')->middleware('is_login_status')->middleware(['auth', 'is_verify_email'])->name('sample.dashboard');
    Route::get('account/verify/{token}', 'verifyAccount')->name('user.verify');
    Route::get('auth/google/callback', 'callback');
    Route::get('send-email', 'sendEmail');
    Route::get('resend-email', 'resendEmail');
    Route::post('validate_resend_email', 'validate_resend_email')->name('verify.validate_resend_email');
    Route::get("new_team_create1", 'new_team_create1')->middleware('is_login_status')->name('new_team_create1');
    Route::post('new_team_create2', 'new_team_create2')->middleware('is_login_status')->name('new_team_create2');
    Route::post('new_team_create3', 'new_team_create3')->middleware('is_login_status')->name('new_team_create3');
    Route::get("book_dashboard/{teamId}/{type}", 'book_dashboard')->middleware('is_login_status')->middleware('is_register_book_status')->name('book_dashboard');
    Route::post("validate_book_dashboard", 'validate_book_dashboard')->middleware('is_login_status')->middleware('is_register_book_status')->name('validate_book_dashboard');

    Route::get('upload_avatar', 'create_avatar_view');
    Route::get('back', 'back')->name('back');
    Route::post('upload_avatar', 'upload_avatar')->name('upload.avatar');

    Route::get("team_edit", 'team_edit')->middleware('is_login_status')->middleware('is_register_book_status')->name('team_edit');
    Route::get("team_edit_detail", 'team_edit_detail')->middleware('is_login_status')->middleware('is_register_book_status')->name('team_edit_detail');
    Route::get("team_edit_amount", 'team_edit_amount')->middleware('is_login_status')->middleware('is_register_book_status')->name('team_edit_amount');
    Route::get("amount_register", 'amount_register')->middleware('is_login_status')->middleware('is_register_book_status')->name('amount_register');
});
