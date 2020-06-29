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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/add-client', 'HomeController@add_client');
// Route::post('/add-client', 'HomeController@add_client');
// Route::get('/client-list', 'HomeController@client_list');

///////////////////////  CLIENT'S SECTION  /////////////////////////
Route::get('/clients', 'ClientsController@clients');
Route::get('/update-client/{id}/{is_active}', 'ClientsController@update_client');
Route::post('/clients', 'ClientsController@clients');


///////////////////////  ITEM'S SECTION  /////////////////////////
Route::get('/items', 'ItemsController@items')->name('itemlist');
Route::post('/items', 'ItemsController@items')->name('itemsave');


///////////////////////  ORDER SECTION  /////////////////////////
Route::get('/order/{type}', 'OrderController@index');
Route::post('/order/{type}', 'OrderController@index');
Route::get('/order/{type}/{id}', 'OrderController@index');


///////////////////// ADD ORDER SECTION  //////////////////////
Route::get('/add-order/{type}', 'OrderController@add_order');
Route::post('/add-order/{type}', 'OrderController@add_order');
Route::get('/add-order/{type}/{id}', 'OrderController@add_order');
Route::get('/get-cart/{type}', 'OrderController@get_cart');


/////////////////////// ORDER PAYMENT SECTION  ////////////////////////
Route::post('/order-payment/{type}', 'PaymentController@order_payment');
Route::get('/get-cart/{type}', 'OrderController@get_cart');


/////////////////////// ORDER INVOICE SECTION  ////////////////////////
Route::get('/order-invoice/{id}', 'OrderController@order_invoice');
Route::get('/order-payment/{id}', 'OrderController@order_payment');


///////////////////////  PAYMENT SECTION  /////////////////////////
Route::get('/payment/{type}', 'PaymentController@index');
Route::post('/payment/{type}', 'PaymentController@index');
Route::get('/payment/{type}/{id}', 'PaymentController@index');


///////////////////// ADD PAYMENT SECTION  //////////////////////
Route::get('/add-payment/{type}', 'PaymentController@add_payment');
Route::post('/add-payment/{type}', 'PaymentController@add_payment');
Route::get('/add-payment/{type}/{id}', 'PaymentController@add_payment');
