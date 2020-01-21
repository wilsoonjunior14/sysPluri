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

//Route::get('/','HomeController@index');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

//Route::get('/logout', 'HomeController@logout');


// ROTAS DO ALUNO
Route::get('/aluno', 'alunoController@index');
Route::get('/aluno/{id}', 'alunoController@get');
Route::post('/aluno', 'alunoController@add');
Route::put('/aluno', 'alunoController@edit');
Route::delete('/aluno', 'alunoController@delete');

// Rotas do curso
Route::get('/curso', 'cursoController@index');
Route::get('/curso/{id}', 'cursoController@get');
Route::post('/curso', 'cursoController@add');
Route::put('/curso', 'cursoController@edit');
Route::delete('/curso', 'cursoController@delete');