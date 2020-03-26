<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');


Route::middleware(['jwt.verify'])->group(function(){
    //user
    Route::get('user', "UserController@getAll");
	Route::post('user/{limit}/{offset}', "UserController@find");
	Route::delete('user/delete/{id}', "UserController@delete");
	Route::post('user/ubah', "UserController@ubah");
	Route::get('user/data', "UserController@index");


    //pelanggan
    Route::post('pelanggan/tambah', "PelangganController@getAll");
    Route::get('pelanggan', "PelangganController@getAll");
	Route::delete('pelanggan/delete/{id}', "PelangganController@delete");
	Route::post('pelanggan/ubah', "UserController@update");
	Route::get('pelanggan/data', "UserController@index");
});