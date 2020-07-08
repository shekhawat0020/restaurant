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
	
	
	});
	
	
	

    
    Route::get('/setting', 'SettingController@index')->name('setting');
    Route::post('/setting/password/update', 'SettingController@updatePassword')->name('password-update');


    Route::get('/roles-list', 'RolePermissionController@roles')->name('roles-list');
    Route::get('/roles/create', 'RolePermissionController@create')->name('roles-create');
    Route::post('/roles/store', 'RolePermissionController@store')->name('roles-store');
    Route::get('/roles/edit/{id}', 'RolePermissionController@edit')->name('roles-edit');
    Route::post('/roles/update/{id}', 'RolePermissionController@update')->name('roles-update');
    Route::get('/ajax/roles/view/{id}', 'RolePermissionController@show')->name('roles-view');
	
	
	
	 Route::get('/qr', 'TableController@qr');


});

