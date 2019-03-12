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

Route::get('/home', function () {
    return view('home');
});
Route::get('groups', 'Views\GroupController@index');
Route::get('groups/{user}', 'Views\GroupController@groupsUser');
Route::delete('group/{id}', 'Views\GroupController@delete');
Route::post('group', 'Views\GroupController@addGroup');

Route::get('profiles', 'Views\ProfilesController@index');
Route::delete('profile/{id}', 'Views\ProfilesController@delete');
Route::post('profile', 'Views\ProfilesController@addProfile');

Route::get('task1/hello_world', 'Task1\Task1Controller@helloWorld');
Route::get('task1/uuid', 'Task1\Task1Controller@uuid');
Route::get('task1/data_from_config', 'Task1\Task1Controller@dataFromConfig');
//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
