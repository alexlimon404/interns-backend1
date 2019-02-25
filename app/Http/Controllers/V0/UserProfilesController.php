<?php

namespace App\Http\Controllers\V0;

use Illuminate\Database\Eloquent\Model;
use App\app\Models\User\UserProfile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserProfilesController extends Model
{
/**
 * 1. роут GET api/v0/users/profile/{id}
 * */
    public function profileId($id)
    {
        if (!UserProfile::find($id)) {
            abort(404, "проафиль с id - $id не найдена");
        }
        return response()->json([
            "success" => true,
            "data" => [
                "profile" => UserProfile::find($id)
            ]
        ]);
    }
/**
 * 2. роут GET api/v0/user/{userId}/profiles
 * возвращает все профили пользователя
 * */
    public function userId($userId)
    {
        $user = User::find($userId);
        if(!$user){
            abort(404, "Пользователь с id = $userId не найден");
        }
        $userProfiles = UserProfile::where('user_id', $userId)->get();
        //var_dump($userProfiles);
        return response()->json([
            'success' => true,
            'data' => [
                'profiles' =>$userProfiles
            ]
        ]);
    }
/**
 * 3. роут GET api/v0/users/profiles
 * возвращает все профили пользователя
 *  ..Параметры: 1. page обязательно >=1
 * */
    public function index(Request $request)
    {
        $numPage = $request->get('page');
        if ($numPage < 1) {
            abort(404, "Неправильный номер страницы $numPage");
        }
        $perPage = 5;
        $userProfiles = UserProfile::paginate($perPage)->items();
        return response()->json([
            "success" => true,
            "data" => [
                "profile" => $userProfiles
            ]
        ]);
    }
/**
 * 4. роут PATCH api/v0/users/profile/{id}
 * Параметры: 1. name - обновляет имя профиля
 * */
    public function changeName($id, Request $request)
    {
        $name = $request->get('name');
        $userProfiles = UserProfile::find($id);
        if (!$userProfiles){
            abort(404, "Профиль с id = $id не найден");
        }
        if (!$name){
            abort(400, "Имя не было передано!");
        }
        $userProfiles->name = $name->save();
        return response()->json([
            "success" => true,
            "data"    => [
                'profile' => $userProfiles
            ]
        ]);
    }
/**
 * 5. роут DELETE api/v0/users/profile/{id}
 * удаляет профиль
 * */
    public function delProfile($id)
    {
        if (!UserProfile::find($id)) {
            abort(404, "Профиль с id = $id не найден");
        }
        UserProfile::find($id)->delete();
        return response()->json(['success' => true]);
    }
/**
 * 6.роут GET api/v0/db/users/profile/{id}
 * */

    public function profileIdDB($id)
    {
        $userProfiles = DB::table('user_profiles')->where('id', $id)->first();
        //var_dump($userProfiles);
        if (!$userProfiles) {
            abort(404, "Профиль с id = $id не найден");
        }
        return response()->json([
            "success" => true,
            "data" => [
                "profile" => $userProfiles
            ]
        ]);
    }
/**
 * 7.роут GET api/v0/db/user/{userId}/profiles
 * */
    public function userIdDB($usersId)
    {
        $userProfiles = DB::table('user_profiles')->where('users_id', $usersId)->first();
        //var_dump($userProfiles);
        if (!$userProfiles) {
            abort(404, "user id - $usersId не найдена");
        }
        return response()->json([
            "success" => true,
            "data" => [
                "profile" => $userProfiles
            ]
        ]);
    }

/**
 * 8. роут GET api/v0/db/users/profiles
 * Параметры: 1. page обязательно >=1
 * */
    public function indexDB(Request $request)
    {
        $numPage = $request->get('page');
        if ($numPage < 1) {
            abort(400);
        }
        $perPage = 5;
        $userProfiles = DB::table('user_profiles')->paginate($perPage)->items();
        return response()->json([
            'success' => true,
            'data' => [
                'profiles' =>$userProfiles
            ]
        ]);
    }
/**
 * 9. роут PATCH api/v0/db/users/profile/{id}
 * */
    public function changeNameDB($id, Request $request)
    {
        $name = $request->get('name');
        $userProfiles = DB::table('user_profiles')->where('id', $id)->first();
        if (!$userProfiles){
            abort(404, "Профиль с id = $id не найден");
        }
        if (!$name){
            abort(400, "Имя не передано");
        }
        DB::table('user_profiles')
            ->where('id', $id)
            ->update(['name' => $name]);
        $updatedUserProfile = DB::table('user_profiles')->where('id', $id)->first();
        return response()->json([
            "success" => true,
            "data" => [
                "profile" => $updatedUserProfile,
            ]
        ]);
    }
/**
 * 10. роут DELETE api/v0/db/users/profile/{id}
 * */
    public function delProfileDB($id)
    {
        $userProfiles = DB::table('user_profiles')->where('id', $id)->first();
        if (!$userProfiles){
            abort(404, "Профиль с id = $id не найден");
        }
        DB::table('user_profiles')->where('id', $id)->delete();
        return response()->json(['success' => true]);
    }
}