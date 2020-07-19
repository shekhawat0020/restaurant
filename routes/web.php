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

Route::get('/test', function () {
    return view('auth.login');
});

Auth::routes();



Route::group(['middleware' => ['auth'], 'namespace' => 'Backend'], function() {

    //['middleware' => ['permission:publish articles|edit articles']], function
//->middleware(['permission:User View|User Edit']);

	Route::get('/', 'DashboardController@index')->name('dashboard');
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard');


    //User Master
    Route::group(['middleware' => ['permission:User Master']], function() {
        Route::get('/users', 'UserController@index')->name('user-list')->middleware(['permission:User List']);
        Route::get('/users/create', 'UserController@create')->name('user-create')->middleware(['permission:User Create']);
        Route::post('/users/store', 'UserController@store')->name('user-save')->middleware(['permission:User Create']);
        Route::get('/users/edit/{id}', 'UserController@edit')->name('user-edit')->middleware(['permission:User Edit']);
        Route::post('/users/update/{id}', 'UserController@update')->name('user-update')->middleware(['permission:User Edit']);
        Route::get('/ajax/users/view/{id}', 'UserController@show')->name('user-view')->middleware(['permission:User View']);
    });
	
	// Master
    Route::group(['middleware' => ['permission:Restaurant']], function() {
        Route::get('/restaurant/profile', 'RestaurantController@index')->name('restaurant-profile')->middleware(['permission:Restaurant']);
        Route::post('/restaurant/profile/update', 'RestaurantController@update')->name('restaurant-update')->middleware(['permission:Restaurant']);
    
		//category
        Route::get('/restaurant/category', 'CategoryController@index')->name('category-list')->middleware(['permission:Restaurant']);
        Route::get('/restaurant/category/create', 'CategoryController@create')->name('category-create')->middleware(['permission:Restaurant']);
		
        Route::post('/restaurant/category/store', 'CategoryController@store')->name('category-save')->middleware(['permission:Restaurant']);
        Route::get('/restaurant/category/edit/{id}', 'CategoryController@edit')->name('category-edit')->middleware(['permission:Restaurant']);
        Route::post('/restaurant/category/update/{id}', 'CategoryController@update')->name('category-update')->middleware(['permission:Restaurant']);
	
		//menu
        Route::get('/restaurant/menu', 'MenuController@index')->name('menu-list')->middleware(['permission:Restaurant']);
        Route::get('/restaurant/menu/create', 'MenuController@create')->name('menu-create')->middleware(['permission:Restaurant']);
		
        Route::post('/restaurant/menu/store', 'MenuController@store')->name('menu-save')->middleware(['permission:Restaurant']);
        Route::get('/restaurant/menu/edit/{id}', 'MenuController@edit')->name('menu-edit')->middleware(['permission:Restaurant']);
        Route::post('/restaurant/menu/update/{id}', 'MenuController@update')->name('menu-update')->middleware(['permission:Restaurant']);
		
		
		//menu
        Route::get('/restaurant/table', 'TableController@index')->name('table-list')->middleware(['permission:Restaurant']);
        Route::get('/restaurant/table/create', 'TableController@create')->name('table-create')->middleware(['permission:Restaurant']);
		
        Route::post('/restaurant/table/store', 'TableController@store')->name('table-save')->middleware(['permission:Restaurant']);
        Route::get('/restaurant/table/edit/{id}', 'TableController@edit')->name('table-edit')->middleware(['permission:Restaurant']);
        Route::post('/restaurant/table/update/{id}', 'TableController@update')->name('table-update')->middleware(['permission:Restaurant']);
        Route::get('/qr/{id}', 'TableController@QR')->name('table-qr')->middleware(['permission:Restaurant']);
	
		//orders
		 Route::get('/restaurant/order', 'OrderController@index')->name('order-list')->middleware(['permission:Restaurant']);
         Route::get('/restaurant/order/edit/{table_id}', 'OrderController@tableOrder')->name('order-edit')->middleware(['permission:Restaurant']);
         Route::get('/restaurant/order/update-item-status/{item_id}/{status}', 'OrderController@updateOrderItemStatus')->name('update-order-item-status')->middleware(['permission:Restaurant']);
         Route::get('/restaurant/order/complete/{order_id}', 'OrderController@completeOrder')->name('complete-order')->middleware(['permission:Restaurant']);
	});
	
	
	

    
    Route::get('/setting', 'SettingController@index')->name('setting');
    Route::post('/setting/password/update', 'SettingController@updatePassword')->name('password-update');


    Route::get('/roles-list', 'RolePermissionController@roles')->name('roles-list');
    Route::get('/roles/create', 'RolePermissionController@create')->name('roles-create');
    Route::post('/roles/store', 'RolePermissionController@store')->name('roles-store');
    Route::get('/roles/edit/{id}', 'RolePermissionController@edit')->name('roles-edit');
    Route::post('/roles/update/{id}', 'RolePermissionController@update')->name('roles-update');
    Route::get('/ajax/roles/view/{id}', 'RolePermissionController@show')->name('roles-view');
	
	
	
	


});

 Route::get('/open-restaurant/{table_id}', 'HomeController@index');
 Route::get('/ajax/get-cart-form/{table_id}/{menu_id}', 'HomeController@cartForm')->name('cart-form');
 Route::get('/ajax/my-cart/{table_id}', 'HomeController@myCart')->name('my-cart');
 Route::get('/ajax/my-order/{table_id}', 'HomeController@myorder')->name('my-order');
 Route::get('/ajax/remove-cart-item/{cart_item_id}', 'HomeController@removeCartItem')->name('remove-cart-item');
 Route::post('/add-to-cart', 'HomeController@addToCart')->name('add-to-cart');
 Route::post('/cart-order-place', 'HomeController@cartOrder')->name('cart-order');

