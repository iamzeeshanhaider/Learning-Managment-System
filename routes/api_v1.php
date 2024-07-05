<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return ('API Endpoint - Method not allowed');
});

Route::group(['prefix' => '/auth', 'as' => 'auth.'], function () {
    Route::post('/login', 'Auth\AuthController@login');
});

Route::group(['middleware' => ['auth.jwt']], function () {
    Route::post('/refresh', 'Auth\AuthController@refresh');
    Route::post('/logout', 'Auth\AuthController@logout');

    Route::get('/profile', 'ProfileController@show');
    Route::post('/profile', 'ProfileController@update');
    Route::post('/profile/photo', [UserProfileController::class, 'storePhoto']);
    Route::post('/profile/password', [UserProfileController::class, 'updatePassword']);

    Route::group(['prefix' => '/student'], function () {
        Route::get('/batches', 'BatchController@index');
        Route::group(['prefix' => '/batch/{batch}'], function () {
            Route::get('/courses', 'CourseController@student_courses');

            Route::group(['prefix' => '/course/{course}'], function () {
                Route::get('/quiz', 'QuizController@index');
                Route::get('/quiz/{quiz}', 'QuizController@show');
            });
        });
    });

    Route::get('/ticket-categories', 'TicketCategoryController@index');
    Route::apiResource('/ticket', 'TicketController')->except('store');
    Route::post('/ticket/{ticket}/comment', 'TicketController@comment');

    Route::post('/ticket/create', [TicketsController::class, 'store']);

    // general
    Route::get('/list/gender', 'GeneralController@getGender');
    Route::get('/list/ethnicity', 'GeneralController@getEthnicity');
    Route::get('/list/uk-status', 'GeneralController@getUKStatus');
});
