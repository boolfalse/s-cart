<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('banner', BannerController::class);
    $router->resource('layout', LayoutController::class);
    $router->resource('language', LanguageController::class);
    $router->resource('currencies', CurrencyController::class);
//Config
    $router->resource('config_info', ConfigInfoController::class);
    $router->resource('config_global', ConfigGlobalController::class);
    $router->any('/config_updateConfigField', 'ConfigInfoController@updateConfigField')
        ->name('updateConfigField');
    $router->get('/ckfinder', function () {
        return view('admin.ckfinder');
    });

//Shop
    $router->resource('shop_customer', ShopCustomerController::class);
    $router->resource('shop_order', ShopOrderController::class);
    $router->resource('shop_product', ShopProductController::class);
    $router->resource('shop_category', ShopCategoryController::class);
    $router->resource('shop_brand', ShopBrandController::class);
    $router->resource('shop_vendor', ShopVendorController::class);
    $router->resource('shop_order_status', ShopOrderStatusController::class);
    $router->resource('shop_payment_status', ShopPaymentStatusController::class);
    $router->resource('shop_shipping_status', ShopShipingStatusController::class);
    $router->resource('shop_special_price', ShopSpecialPriceController::class);
    $router->resource('shop_attribute_group', ShopAttributeGroupController::class);
    $router->resource('shop_page', ShopPageController::class);

//Get info
    $router->group(['prefix' => 'get_info'], function ($router) {
        $router->get('productInfo', 'ShopOrderController@getInfoProduct')->name('getInfoProduct');
        $router->get('userInfo', 'ShopOrderController@getInfoUser')->name('getInfoUser');
        $router->get('itemInfo', 'ShopOrderController@getInfoItem')->name('getInfoItem');
    });
//

    $router->group(['prefix' => 'shop_order_edit'], function ($router) {
        $router->get('/{id}', 'ShopOrderController@detailOrder')->name('order_edit_get');
        $router->post('/order_add_item', 'ShopOrderController@postAddItem')->name('order_add_item');
        $router->post('/order_edit_item', 'ShopOrderController@postEditItem')->name('order_edit_item');
        $router->post('/order_delete_item', 'ShopOrderController@postDeleteItem')->name('order_delete_item');
        $router->put('/shop_order_update', 'ShopOrderController@postOrderUpdate')->name('order_update');
    });
//Modules
    $router->group(['prefix' => 'modules'], function ($router) {
        $router->get('/{modulesGroup}', 'ModulesController@index')->name('modulesGroup');
        $router->post('/installModule', 'ModulesController@installModule')->name('installModule');
        $router->post('/uninstallModule', 'ModulesController@uninstallModule')->name('uninstallModule');
        $router->post('/enableModule', 'ModulesController@enableModule')->name('enableModule');
        $router->post('/disableModule', 'ModulesController@disableModule')->name('disableModule');
        $router->match(['put', 'post'], '/processModule/{moduleGroup}/{module}', 'ModulesController@processModule')->name('processModule');
    });
    $router->group(['prefix' => 'modules', 'namespace' => 'Modules'], function ($router) {
        $router->resource('cms/cms_category', Cms\CmsCategoryController::class);
        $router->resource('cms/cms_content', Cms\CmsContentController::class);
        $router->resource('cms/cms_news', Cms\CmsNewsController::class)->names('news');
        $router->resource('api/shop_api', Api\ShopApiController::class);
    });
//End module

//Extensions
    $router->group(['prefix' => 'extensions'], function ($router) {
        $router->get('/{extensionGroup}', 'ExtensionsController@index')->name('extensionGroup');
        $router->post('/installExtension', 'ExtensionsController@installExtension')->name('installExtension');
        $router->post('/uninstallExtension', 'ExtensionsController@uninstallExtension')->name('uninstallExtension');
        $router->post('/enableExtension', 'ExtensionsController@enableExtension')->name('enableExtension');
        $router->post('/disableExtension', 'ExtensionsController@disableExtension')->name('disableExtension');
        $router->match(['put', 'post'], '/processExtension/{extensionGroup}/{extension}', 'ExtensionsController@processExtension')->name('processExtension');
    });
    $router->resource('shop_discount', Extensions\Total\DiscountController::class)->names('configDiscount');
//end extensions

//Language
    $router->post('locale/{code}', function ($code) {
        \App\Models\ConfigGlobal::first()->update(['locale' => $code]);
        return back();
    });
//

//Process Simpe
    $router->prefix('process')->group(function ($router) {
        $router->any('/productImport', 'ProcessController@importProduct')->name('productImport');
    });
    $router->get('/report/{key}', 'ReportController@index');
});
