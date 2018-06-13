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
    Route::get('/profile/{id}', ['as' => 'user.profile', 'uses' => 'Frontend\UserController@show']);
    Route::get('editProfile/{id}', ['as' => 'user.editProfile', 'uses' => 'Frontend\UserController@edit']);
    Route::post('editProfile/{id}', ['as' => 'user.postEditProfile', 'uses' => 'Frontend\UserController@postEditProfile']);
    Route::get('checkout', ['as' => 'user.checkout', 'uses' => 'Frontend\OrderController@index']);
    Route::get('createOrder', ['as' => 'user.createOrder', 'uses' => 'Frontend\OrderController@create']);

    Route::get('myOrders', ['as' => 'user.myOrders', 'uses' => 'Frontend\OrderController@showMyOrders']);

    Route::get('orderDetail/{id}', ['as' => 'user.orderDetail', 'uses' => 'Frontend\OrderController@showById']);
    Route::get('cancelOrder/{id}', ['as' => 'user.cancelOrder', 'uses' => 'Frontend\OrderController@cancel']);
});

/**
 * ADMIN ROLE
 */
Route::group(['middleware' => 'admin'], function () {
    Route::get('admin', ['as' => 'admin', 'uses' => 'Backend\AdminController@index']);
});

/**
 * CART
 */
Route::get('product', ['as' => 'product', 'uses' => 'Frontend\ProductController@index'], ['only' => ['index', 'show']]);
Route::get('showProduct/{slug}', ['as' => 'productDetail', 'uses' => 'Frontend\ProductController@show']);

Route::get('showCart', ['as' => 'myCart', 'uses' => 'CartController@index']);

Route::resource('shop', 'Frontend\ProductController', ['only' => ['index', 'show']]);
Route::resource('cart', 'CartController');
Route::post('cart/{id}', ['as' => 'cartUpdate', 'uses' =>  'CartController@updateCart']);
Route::delete('emptyCart', 'CartController@emptyCart');
Route::post('switchToWishlist/{id}', 'CartController@switchToWishlist');

Route::resource('wishlist', 'WishlistController');
Route::delete('emptyWishlist', 'WishlistController@emptyWishlist');
Route::post('switchToCart/{id}', 'WishlistController@switchToCart');


/**
 * CATEGORY
 */
Route::get('showPrdByCatId/{id}', ['as' => 'prdByCategory', 'uses' => 'Frontend\ProductController@showPrdByCatId']);

/**
 * COUPON
 */
Route::get('checkCoupon', ['as' => 'checkCoupon', 'uses' => 'Frontend\CouponProgramController@check']);

/**
 * Search
 */
Route::get('search', ['as' => 'search', 'uses' => 'Frontend\ProductController@search']);

/**
 * ADMIN ROLE
 */
Route::group(['middleware' => 'admin'], function () {
    Route::get('admin', ['as' => 'admin', 'uses' => 'Backend\AdminController@index']);

    // Product
    Route::get('adminProducts', ['as' => 'admin.products', 'uses' => 'Backend\ProductController@index']);

    Route::get('/editProduct/{id}', ['as' => 'admin.editProduct', 'uses' => 'Backend\ProductController@edit']);
    Route::post('/edittingProduct/{id}', ['as' => 'admin.edittingProduct', 'uses' => 'Backend\ProductController@editting']);
    Route::get('/addProduct', ['as' => 'admin.addProduct', 'uses' => 'Backend\ProductController@add']);
    Route::post('/addingProduct', ['as' => 'admin.addingProduct', 'uses' => 'Backend\ProductController@adding']);


    // end product

    // Category
    Route::get('/addCategory', ['as' => 'admin.addCategory', 'uses' => 'Backend\CategoryController@add']);
    Route::post('/addingCategory', ['as' => 'admin.addingCategory', 'uses' => 'Backend\CategoryController@adding']);

    Route::get('/editCategory/{id}', ['as' => 'admin.editCategory', 'uses' => 'Backend\CategoryController@edit']);
    Route::post('/edittingCategory/{id}', ['as' => 'admin.edittingCategory', 'uses' => 'Backend\CategoryController@editting']);
    Route::get('/deleteCategory/{id}', ['as' => 'admin.deleteCategory', 'uses' => 'Backend\CategoryController@delete']);
    Route::get('/restoreCategory/{id}', ['as' => 'admin.restoreCategory', 'uses' => 'Backend\CategoryController@restore']);
   Route::get('/showCategory/{id}', ['as' => 'admin.showCategory', 'uses' => 'Backend\CategoryController@show']);
    // end Category

    Route::get('adminUsers', ['as' => 'admin.users', 'uses' => 'Backend\UserController@index']);
    Route::get('adminCategories', ['as' => 'admin.categories', 'uses' => 'Backend\CategoryController@index']);
    Route::get('adminColors', ['as' => 'admin.colors', 'uses' => 'Backend\ColorController@index']);

    Route::get('adminImages', ['as' => 'admin.images', 'uses' => 'Backend\ImageController@index']);
    Route::get('searchAll', ['as' => 'admin.searchAll', 'uses' => 'Backend\ProductController@searchAll']);
    Route::get('editProduct/{id}', ['as' => 'admin.editProduct', 'uses' => 'Backend\ProductController@edit']);

    // COUPON
    Route::get('adminCoupons', ['as' => 'admin.coupons', 'uses' => 'Backend\CouponController@index']);
    Route::get('/addCoupon', ['as' => 'admin.addCoupon', 'uses' => 'Backend\CouponController@add']);
    Route::post('/addingCoupon', ['as' => 'admin.addingCoupon', 'uses' => 'Backend\CouponController@adding']);

    Route::get('/editCoupon/{id}', ['as' => 'admin.editCoupon', 'uses' => 'Backend\CouponController@edit']);
    Route::post('/edittingCoupon/{id}', ['as' => 'admin.edittingCoupon','uses' => 'Backend\CouponController@editting']);

    Route::get('/deleteCoupon/{id}', ['as' => 'admin.deleteCoupon', 'uses' => 'Backend\CouponController@delete']);
    Route::get('/restoreCoupon/{id}', ['as' => 'admin.restoreCoupon', 'uses' => 'Backend\CouponController@restore']);

    Route::get('/showCoupon/{id}', ['as' => 'admin.showCoupon', 'uses' => 'Backend\CouponController@show']);

    //END COUPON

    //ORDER

    Route::get('adminOrders', ['as' => 'admin.orders', 'uses' => 'Backend\OrderController@index']);
    Route::get('/addOrder', ['as' => 'admin.addOrder', 'uses' => 'Backend\OrderController@add']);
    Route::post('/addingOrder', ['as' => 'admin.addingOrder', 'uses' => 'Backend\OrderController@adding']);

    Route::get('/editOrder/{id}', ['as' => 'admin.editOrder', 'uses' => 'Backend\OrderController@edit']);
    Route::post('/edittingOrder/{id}', ['as' => 'admin.edittingOrder','uses' => 'Backend\OrderController@editting']);

    Route::get('/deleteOrder/{id}', ['as' => 'admin.deleteOrder', 'uses' => 'Backend\OrderController@delete']);
    Route::get('/restoreOrder/{id}', ['as' => 'admin.restoreOrder', 'uses' => 'Backend\OrderController@restore']);

    Route::get('/showOrder/{id}', ['as' => 'admin.showOrder', 'uses' => 'Backend\OrderController@show']);

    //END ORDER
});

