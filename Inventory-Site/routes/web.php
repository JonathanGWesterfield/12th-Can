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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/new_items', 'PagesController@newItems');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route for interacting with items in the database
Route::resource('items', 'ItemsController');

// Route for interacting with order transactions
Route::resource('transactions', 'TransactionsController');
