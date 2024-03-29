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
    // Route::middleware('httpbasic.auth')->group(function () {

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
    Route::get("book_dashboard/{teamId}/{type}", 'book_dashboard')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('approve_status')->name('book_dashboard');
    Route::post("validate_book_dashboard", 'validate_book_dashboard')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('approve_status')->name('validate_book_dashboard');

    Route::get('back/{url}/{teamId}', 'back')->name('back');
    Route::post('validate_team_edit/{teamId}', 'validate_team_edit')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('validate_team_edit');

    Route::get("team_edit/{teamId}", 'team_edit')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('team_edit');

    Route::get("team_edit_detail/{teamId}", 'team_edit_detail')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('team_edit_detail');

    Route::get("team_edit_amount/{teamId}", 'team_edit_amount')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('team_edit_amount');

    Route::get("accounting_category_register/{teamId}", 'accounting_category_register')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('accounting_category_register');

    Route::get("accounting_register/{teamId}", 'accounting_register')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('accounting_register');

    Route::get("player_register/{teamId}", 'player_register')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('player_register');

    Route::get("invite_team/{teamId}", 'invite_team')->middleware('is_login_status')->middleware('is_register_book_status')->name('invite_team');

    Route::get("ownership_transfer/{teamId}", 'ownership_transfer')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('ownership_transfer');

    Route::get("account_setting", 'account_setting')->middleware('is_login_status')->middleware('is_register_book_status')->name('account_setting');

    Route::post('validate_initial_amount/{teamId}', 'validate_initial_amount')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('validate_initial_amount');

    Route::post('validate_default_category_register/{teamId}', 'validate_default_category_register')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('validate_default_category_register');

    Route::post('validate_category_register/{teamId}', 'validate_category_register')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('validate_category_register');

    Route::post('validate_category_name_edit/{teamId}', 'validate_category_name_edit')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('validate_category_name_edit');

    Route::post('validate_accounting_register/{teamId}', 'validate_accounting_register')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('validate_accounting_register');

    Route::get('monthly_report/{teamId}', 'monthly_report')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('monthly_report');

    Route::post('monthly_report_search/{teamId}', 'monthly_report_search')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('monthly_report_search');

    Route::post('accounting_edit/{teamId}', 'accounting_edit')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('accounting_edit');
    Route::post('validate_accounting_edit/{teamId}', 'validate_accounting_edit')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('validate_accounting_edit');

    Route::post('validate_player_register/{teamId}', 'validate_player_register')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('validate_player_register');

    Route::post('validate_player_register_edit/{teamId}', 'validate_player_register_edit')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('validate_player_register_edit');

    Route::post('validate_invite_team/{teamId}', 'validate_invite_team')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('validate_invite_team');

    Route::get('validate_invite_mail/{token}', 'validate_invite_mail')->name('validate_invite_mail');

    Route::post('validate_invite_register', 'validate_invite_register')->name('validate_invite_register');

    Route::get('member_approve/{teamId}', 'member_approve')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('member_approve');

    Route::post('validate_approve_member/{teamId}', 'validate_approve_member')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('validate_approve_member');

    Route::get('search_team', 'search_team')->middleware('is_login_status')->name('search_team');

    Route::post('validate_search_team', 'validate_search_team')->middleware('is_login_status')->name('validate_search_team');

    Route::post('search_team2', 'search_team2')->middleware('is_login_status')->name('search_team2');

    Route::post('validate_team_enter', 'validate_team_enter')->middleware('is_login_status')->name('validate_team_enter');

    Route::post('validate_account_edit', 'validate_account_edit')->middleware('is_login_status')->middleware('is_register_book_status')->name('validate_account_edit');
    Route::get('account_remove', 'account_remove')->middleware('is_login_status')->middleware('is_register_book_status')->name('account_remove');

    Route::post('validate_ownership_transfer/{teamId}', 'validate_ownership_transfer')->middleware('is_login_status')->middleware('is_register_book_status')->middleware('owner_check')->name('validate_ownership_transfer');

    Route::get('verify_owner_transfer/{token}', 'verify_owner_transfer')->middleware('is_login_status')->middleware('is_register_book_status')->name('verify_owner_transfer');

    Route::get('password_reset', 'password_reset')->name('password_reset');
    Route::post('validate_password_reset', 'validate_password_reset')->name('validate_password_reset');
    Route::get('verify_password_reset/{token}', 'verify_password_reset')->name('verify_password_reset');
    Route::post('post_reset_password', 'post_reset_password')->name('post_reset_password');
    // });

});
