<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'namespace' => 'Api','middleware' => 'throttle:5'], function () {
    Route::post('verificationCodes', 'VerificationCodesController@store')->name('api.verificationCodes.store');
    Route::post('users', 'UsersController@store')->name('api.users.store');
    Route::post('captchas', 'CaptchasController@store')->name('api.captchas.store');
});
