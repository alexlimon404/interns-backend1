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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('v0/users/profile/{id}', 'V0\UserProfilesController@profileId');
Route::get('v0/users/{userId}/profile', 'V0\UserProfilesController@userId');

//3. возвращает все профили пользователя
//..Параметры: 1. page обязательно >=
Route::get('v0/users/profile', 'V0\UserProfilesController@index');

//4. роут PATCH api/v0/users/profile/{id}
//1. name - обновляет имя профиля

//5. роут DELETE api/v0/users/profile/{id}
//удаляет профиль

//6роут GET api/v0/db/users/profile/{id}

//7роут GET api/v0/db/user/{userId}/profiles

//8роут GET api/v0/db/users/profiles

//9роут PATCH api/v0/db/users/profile/{id}

//10роут DELETE api/v0/db/users/profile/{id}
