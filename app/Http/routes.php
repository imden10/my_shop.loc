<?php

Route::pattern('id', '[0-9]+');
Route::pattern('page_type', '(main|other)');
Route::pattern('page_url', '[0-9a-zA-Z-_]+');

/*===================permissions route====BEGIN==========*/
Entrust::routeNeedsPermission('master/settings/*', 'navigate_settings',Redirect::to('/master'));
Entrust::routeNeedsPermission('master/pages/*', 'navigate_catalog',Redirect::to('/master'));
Entrust::routeNeedsPermission('master/users/*', 'navigate_users',Redirect::to('/master'));
/*===================permissions route====END============*/

Route::group(['prefix' => 'master', 'middleware' => 'auth'], function () {

    Route::get('/', 'Admin\AdminHomeController@index')->name('master');

    /*======Страницы BEGIN=======================*/
    Route::get('pages/{page_type}/create', 'Admin\AdminPageController@createPage');
    Route::get('pages/{page_type}/edit/{id}', 'Admin\AdminPageController@editPage');
    Route::post('pages/get-lang-pages', 'Admin\AdminPageController@get_lang_pages')->name('get-lang-pages');
    Route::post('pages/delete', 'Admin\AdminPageController@delete')->name('pages-delete');
    Route::post('pages/create', 'Admin\AdminPageController@createPagePost')->name('pages-create');
    Route::post('pages/update', 'Admin\AdminPageController@updatePagePost')->name('pages-update');
    Route::post('pages/get-lang-pages-edit', 'Admin\AdminPageController@get_lang_pages_edit')->name('get-lang-pages-edit');
    /*======Страницы END=======================*/

    /*======Категории BEGIN=======================*/
    Route::get('categories/create', 'Admin\AdminCategoriesController@createCategories');
    Route::get('categories/edit/{id}', 'Admin\AdminCategoriesController@editCategories');
    Route::post('categories/get-lang-categories', 'Admin\AdminCategoriesController@get_lang_categories')->name('get-lang-categories');
    Route::post('categories/delete', 'Admin\AdminCategoriesController@delete')->name('categories-delete');
    Route::post('categories/create', 'Admin\AdminCategoriesController@createCategoriesPost')->name('categories-create');
    Route::post('categories/update', 'Admin\AdminCategoriesController@updateCategoriesPost')->name('categories-update');
    Route::post('categories/get-lang-categories-edit', 'Admin\AdminCategoriesController@get_lang_categories_edit')->name('get-lang-categories-edit');
    /*======Категории END=======================*/

    /*======фильтры BEGIN=======================*/
    Route::get('features', 'Admin\AdminFeaturesController@index');
    Route::post('features/create', 'Admin\AdminFeaturesController@createFeature');
    Route::post('features/get-lang-features', 'Admin\AdminFeaturesController@get_lang_features')->name('get-lang-features');
    Route::post('features/delete', 'Admin\AdminFeaturesController@delete')->name('features-delete');
    Route::get('features/edit/{id}', 'Admin\AdminFeaturesController@edit');
    Route::post('features/update', 'Admin\AdminFeaturesController@updateFeaturePost')->name('features-update');
    Route::post('features/get-lang-feature-edit', 'Admin\AdminFeaturesController@get_lang_feature_edit')->name('get-lang-feature-edit');
    /*======фильтры END=======================*/

    /*======Настройки BEGIN=======================*/
    Route::get('settings/main', 'Admin\AdminSettingsController@main');
    Route::post('settings/main/update', 'Admin\AdminSettingsController@Update')->name('settings-main-update');
    Route::post('settings/main/get-lang', 'Admin\AdminSettingsController@get_lang_settings')->name('get-lang-settings');
    /*languages*/
    Route::get('settings/languages', 'Admin\AdminLanguagesController@getLanguages');
    Route::post('settings/languages/create', 'Admin\AdminLanguagesController@postCreate');
    Route::post('settings/languages/update', 'Admin\AdminLanguagesController@postUpdate');
    Route::post('settings/languages/destroy', 'Admin\AdminLanguagesController@postDestroy');
    /*======Настройки END=======================*/

    /*======Пользователи BEGIN=======================*/
    Route::resource('users/users', 'Admin\AdminUsersController');
    /*======Пользователи END=========================*/

    /*======Группы пользователей BEGIN=======================*/
    Route::resource('users/users-permissions', 'Admin\AdminUserPermissionsController');
    /*======Группы пользователей END=========================*/

    /*======Продукты BEGIN=======================*/
    Route::get('products', 'Admin\AdminProductsController@index')->name('products');
    Route::get('products/create', 'Admin\AdminProductsController@createProduct');
    Route::get('products/edit/{id}', 'Admin\AdminProductsController@editProduct');
    Route::post('products/delete', 'Admin\AdminProductsController@delete')->name('products-delete');
    Route::post('products/create', 'Admin\AdminProductsController@createProductsPost')->name('products-create');
    Route::post('products/update', 'Admin\AdminProductsController@updateProductsPost')->name('products-update');
    Route::post('products/get-lang-products-edit', 'Admin\AdminProductsController@get_lang_products_edit')->name('get-lang-products-edit');
    Route::post('products/get-features', 'Admin\AdminProductsController@getFeatures')->name('get-features');
    /*======Продукты END=======================*/

    Route::controllers([
        'pages/{page_type}' => 'Admin\AdminPageController',
        'categories' => 'Admin\AdminCategoriesController',
    ]);
});

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);


Route::group(['prefix' => 'user', 'middleware' => 'user'], function () {
    Route::get('/test', function (){
        dd("Ура! Ты пользователь");
    });
});

/*more contents ajax*/
Route::post('/get-product','Frontend\MoreContentController@getProduct');

Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{

    Route::get('/', 'Frontend\HomeController@index');
    Route::post('/catalog/setview','Frontend\CatalogController@setView');
    Route::any('/catalog/{page_url?}', 'Frontend\CatalogController@index');

    Route::get('/sitemap', 'Frontend\HomeController@createSiteMap');

    Route::get('/{page_url}', 'Frontend\PageController@index');
});



