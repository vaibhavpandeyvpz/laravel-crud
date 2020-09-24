<?php

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

Route::view('/', 'home');

Auth::routes();

Route::middleware(['auth', 'can:access-backend'])->namespace('Backend')->prefix('backend')->group(function () {

    Route::view('/', 'backend.dashboard')->name('backend.dashboard');

    Route::resource('users', 'UserController', ['as' => 'backend']);
});
