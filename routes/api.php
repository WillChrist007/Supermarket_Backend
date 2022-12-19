<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('product', 'Api\ProductController@index');
    Route::get('product/{id}', 'Api\ProductController@show');
    Route::post('product', 'Api\ProductController@store');
    Route::put('product/{id}', 'Api\ProductController@update');
    Route::delete('product/{id}', 'Api\ProductController@destroy');

    Route::get('transaksi', 'Api\TransaksiController@index');
    Route::get('transaksi/{id}', 'Api\TransaksiController@show');
    Route::get('transaksiByIdUser/{id}', 'Api\TransaksiController@showAllByIdUser');
    Route::post('transaksi', 'Api\TransaksiController@store');
    Route::put('transaksi/{id}', 'Api\TransaksiController@update');
    Route::delete('transaksi/{id}', 'Api\TransaksiController@destroy');
    Route::put('transaksiConfirm/{id}', 'Api\TransaksiController@confirm');

    Route::get('ulasan', 'Api\UlasanController@index');
    Route::get('ulasan/{id}', 'Api\UlasanController@show');
    Route::get('ulasanByIdUser/{id}', 'Api\UlasanController@showAllByIdUser');
    Route::post('ulasan', 'Api\UlasanController@store');
    Route::put('ulasan/{id}', 'Api\UlasanController@update');
    Route::delete('ulasan/{id}', 'Api\UlasanController@destroy');
    Route::put('ulasanConfirm/{id}', 'Api\UlasanController@confirm');

    Route::get('user', 'Api\UserController@index');
    Route::get('user/{id}', 'Api\UserController@show');
    Route::post('user', 'Api\UserController@store');
    Route::put('user/{id}', 'Api\UserController@update');
    Route::delete('user/{id}', 'Api\UserController@destroy');

    Route::post('logout', 'Api\AuthController@logout');
});