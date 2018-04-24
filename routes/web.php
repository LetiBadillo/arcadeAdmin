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

Auth::routes();
Route::get('/', function () {
    return view('welcome.welcome');
})->middleware('guest');
Route::get('/dashboard', function (){
    return view('welcome.dashboard');
})->middleware('auth');

Route::resource('subjects', 'SubjectsController');
Route::resource('users', 'SubjectsController');


