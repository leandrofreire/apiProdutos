<?php

use Illuminate\Http\Request;

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

Route::post('/cadastro','UserController@registrar');

Route::group(['middleware'=>['auth:api']], function(){

  Route::get('/cartoes', 'CartaoController@index')->middleware('scope:administrador,usuario');
  Route::get('/cartoes/{id}', 'CartaoController@show')->middleware('scope:administrador,usuario');
  Route::get('/cartoes?page{page}&qtd{qtd}', 'CartaoController@index')->middleware('scope:administrador,usuario');
  Route::post('/cartoes', 'CartaoController@store')->middleware('scope:administrador,usuario');
  Route::put('/cartoes/{id}', 'CartaoController@update')->middleware('scope:administrador,usuario');
  Route::delete('/cartoes/{id}', 'CartaoController@destroy')->middleware('scope:administrador,usuario');
});
