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

Route::get('/', function () {
    return view('home');
});

// register member
Route::get('register', 'User\RegisterController@ShowRegistrationForm');
Route::post('register', ['as' => 'postRegister', 'uses' => 'User\RegisterController@postRegister']);
// active account
Route::get('activate/{email}/{activationCode}', ['as' => 'activate', 'uses' => 'User\ActivationController@activate']);
//login
Route::get('login', function () {
    return view('frontend/user/login');
});
