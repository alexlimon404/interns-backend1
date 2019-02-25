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

//1. роут GET api/v0/users/profile/{id}
Route::get('v0/users/profile/{id}', 'V0\UserProfilesController@profileId');
//2. роут GET api/v0/user/{userId}/profiles
Route::get('v0/users/{userId}/profile', 'V0\UserProfilesController@userId');

/*3. возвращает все профили пользователя
 *   ..Параметры: 1. page обязательно >=1
 */
Route::get('v0/users/profile', 'V0\UserProfilesController@index');

/*
 * 4. роут PATCH api/v0/users/profile/{id}
 * Параметры: 1. name - обновляет имя профиля
 * */
Route::patch('v0/users/profile/{id}', 'V0\UserProfilesController@changeName');
/*
 * 5. роут DELETE api/v0/users/profile/{id}
 * удаляет профиль
 * */
Route::delete('v0/users/profile/{id}', 'V0\UserProfilesController@delProfile');

//6.роут GET api/v0/db/users/profile/{id}
Route::get('v0/db/users/profile/{id}', 'V0\UserProfilesController@profileIdDB');

//7.роут GET api/v0/db/user/{userId}/profiles
Route::get('v0/db/user/{userId}/profiles', 'V0\UserProfilesController@userIdDB');

//8.роут GET api/v0/db/users/profiles
Route::Get('v0/db/users/profiles', 'V0\UserProfilesController@indexDB');

//9.роут PATCH api/v0/db/users/profile/{id}
Route::patch('v0/db/users/profile/{id}', 'V0\UserProfilesController@changeNameDB');

//10.роут DELETE api/v0/db/users/profile/{id}
Route::delete('v0/db/users/profile/{id}', 'V0\UserProfilesController@delProfileDB');