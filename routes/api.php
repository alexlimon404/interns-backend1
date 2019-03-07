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
Route::get('v0/user/{userId}/profiles', 'V0\UserProfilesController@userId');

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

//TODO:test

//task 3
/* 1. добавляем группу
 * name - string
 * */
Route::post('v0/users/group', 'V0\UserProfilesController@addGroup');
/*
 * 2. получаем группы пользователя
 * */

Route::get('v0/user/{userId}/groups', 'V0\UserProfilesController@getUserGroups');
/*
 * 3. удаляет группу
 * */
Route::delete('v0/users/groups/{groupId}', 'V0\UserProfilesController@delGroup');
/*
 * 4. добавляет пользователя к группе
 * */
Route::post('v0/user/{userId}/group/{groupId}', 'V0\UserProfilesController@addUserInGroup');
/*
 * 5. убирает пользователя из группы
 * */
Route::get('v0/user/{userId}/group/{groupId}', 'V0\UserProfilesController@delUserInGroup');


/*
 * Api v1
 * */

Route::group(['prefix' => 'v1', 'as' => 'api.v1.'], function ()
{
    Route::get('auth/login/{email}/{pass}', 'V1\AuthorizedController@emailPass');
    Route::get('auth/logout/{api}', 'V1\AuthorizedController@takeNewApi');

    Route::group(['middleware' => ['auth:api', 'admin_only', 'stop_banned']], function () {
        Route::get('users', 'V1\AuthorizedController@users');
        Route::patch('user/{userId}', 'V1\AuthorizedController@updateInfoUsers');
    });

    /*task5
     * */
    Route::get('github/{userName}/{repositoryName}/issues', 'V1\GitHubController@issues');
    Route::get('github/{userName}/repositories', 'V1\GitHubController@userNameRepositories');



});