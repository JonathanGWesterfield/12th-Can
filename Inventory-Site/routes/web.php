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

use App\Http\Controllers\ItemsController;

Route::get('/', 'DashboardController@index')->middleware('auth');

Route::get('/new_items', 'PagesController@newItems')->middleware('auth');
Route::get('/modify_items', 'PagesController@modifyItems')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard', 'DashboardController@index')->middleware('auth');

// Route for interacting with items in the database
Route::resource('items', 'ItemsController')->middleware('auth');

// Route for interacting with order transactions
Route::resource('transactions', 'TransactionsController')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('admin', 'AdminController')->middleware('auth');
