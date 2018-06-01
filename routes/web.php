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

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::get('/contact', function () {
    return view('contact');
});

/**
 * CLIENT
 */
// register member
Route::get('register', ['as' => 'register', 'uses' => 'User\RegisterController@ShowRegistrationForm']);
Route::post('register', ['as' => 'postRegister', 'uses' => 'User\RegisterController@postRegister']);
// active account
Route::get('activate/{email}/{activationCode}', ['as' => 'activate', 'uses' => 'User\ActivationController@activate']);
//login
Route::get('login', ['as' => 'login', 'uses' => 'User\LoginController@getLogin']);
Route::post('login', ['as' => 'postLogin', 'uses' => 'User\LoginController@postLogin']);
//forgot password
Route::get('forgotPassword', ['as' => 'forgotPassword', 'uses' => 'User\ForgotPasswordController@forgotPassword']);
Route::post('forgotPassword', ['as' => 'postForgotPassword', 'uses' => 'User\ForgotPasswordController@postForgotPassword']);
//reset password
Route::get('reset/{email}/{code}', ['as' => 'resetPassword', 'uses' => 'User\ResetPasswordController@resetPassword']);
Route::post('reset/{email}/{code}', ['as' => 'postResetPassword', 'uses' => 'User\ResetPasswordController@postResetPassword']);
//logout
Route::get('logout', ['as' => 'logout', 'uses' => 'User\LoginController@logout']);

/**
 * PRODUCT
 */
Route::get('products', ['as' => 'products', 'uses' => 'Frontend\ProductController@index']);

/**
 * USER ROLE
 */
Route::group(['middleware' => 'user'], function () {
    Route::get('/profile/{id}',['as' => 'user.profile', 'uses' => 'Frontend\UserController@show']);
    Route::get('editProfile/{id}',['as' => 'user.editProfile', 'uses' => 'Frontend\UserController@edit']);
    Route::post('editProfile/{id}',['as' => 'user.postEditProfile', 'uses' => 'Frontend\UserController@postEditProfile']);
});

/**
 * ADMIN ROLE
 */
Route::group(['middleware' => 'admin'], function () {
    Route::get('admin',['as' => 'admin', 'uses' => 'Backend\AdminController@index']);
});
