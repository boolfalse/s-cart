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
Auth::routes();
//============================

//--Auth
Route::group(['namespace' => 'Auth', 'prefix' => 'member'], function ($router) {
    $router->get('/login.html', 'LoginController@showLoginForm')->name('login');
    $router->post('/login.html', 'LoginController@login')->name('postLogin');
    $router->get('/register.html', 'LoginController@showLoginForm')->name('register');
    $router->post('/register.html', 'RegisterController@register')->name('postRegister');
    $router->redirect('/login', '/login.html', 301);
    $router->post('/logout', 'LoginController@logout')->name('logout');
    $router->post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $router->post('/password/reset', 'ResetPasswordController@reset');
    $router->get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    $router->get('/forgot.html', 'ForgotPasswordController@showLinkRequestForm')->name('forgot');
});
//End Auth
Route::get('/member/profile.html', [
    'middleware' => 'auth',
    'uses'       => 'ShopFront@profile',
])->name('profile');

//Language
Route::get('locale/{code}', function ($code) {
    $strQuery  = explode('?', url()->previous());
    $arrParams = [];
    if (!empty($strQuery[1])) {
        parse_str($strQuery[1], $arrParams);
        unset($arrParams['lang']);
    }
    if ($arrParams) {
        $url = $strQuery[0] . '?' . http_build_query($arrParams);
    } else {
        $url = $strQuery[0];
    }
    session(['locale' => $code]);
    return redirect($url);
});

//Currency
Route::get('currency/{code}', function ($code) {
    session(['currency' => $code]);
    return back();
});

//Cart
Route::get('/wishlist.html', 'ShopCart@wishlist')->name('wishlist');
Route::get('/compare.html', 'ShopCart@compare')->name('compare');
Route::get('/cart.html', 'ShopCart@getCart')->name('cart');
Route::post('/cart.html', 'ShopCart@postCart')->name('postCart');
Route::get('/checkout.html', 'ShopCart@getCheckout')->name('checkout');
Route::post('/checkout.html', 'ShopCart@processCart')->name('processCart');
Route::get('/removeItem/{id}', 'ShopCart@removeItem')->name('removeItem');
Route::get('/removeItemWishlist/{id}', 'ShopCart@removeItemWishlist')->name('removeItemWishlist');
Route::get('/removeItemCompare/{id}', 'ShopCart@removeItemCompare')->name('removeItemCompare');
Route::get('/clearCart', 'ShopCart@clearCart')->name('clearCart');
Route::post('/addToCart', 'ShopCart@addToCart')->name('addToCart');
Route::post('/updateToCart', 'ShopCart@updateToCart')->name('updateToCart');
Route::post('/storeOrder', 'ShopCart@storeOrder')->name('storeOrder');
//End cart

//Front
Route::get('/', 'ShopFront@index')->name('home');
Route::get('index.html', 'ShopFront@index');
Route::get('/shop/{name}_{id}.html', 'ShopFront@productToCategory')->name('category');
Route::get('/product/{name}_{id}.html', 'ShopFront@productDetail')->name('product');
Route::get('/brand/{name}_{id}/{category?}', 'ShopFront@productBrand')->name('brand');
Route::get('/products.html', 'ShopFront@allProducts')->name('products');
Route::get('/search.html', 'ShopFront@search')->name('search');
Route::get('/contact.html', 'ShopFront@getContact')->name('contact');
Route::post('/contact.html', 'ShopFront@postContact')->name('postContact');
Route::post('/subscribe', 'ShopFront@emailSubscribe')->name('subscribe');
//--Please keep 2 lines route (pages + pageNotFound) at the bottom
Route::get('/{key}.html', 'ShopFront@pages')->name('pages');
Route::fallback('ShopFront@pageNotFound')->name('pageNotFound');
//--end keep

//End Front
