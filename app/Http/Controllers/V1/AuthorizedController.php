<?php

namespace App\Http\Controllers\V1;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use BenSampo\Enum\Rules\EnumKey;
use App\Enums\UserType;

class AuthorizedController extends Controller
{
    /**
     * 1. GET api/v1/auth/login
     * нужно вернуть api_token из таблицы users
     * если комбинация email & пароля неправильная, вернуть: 401 - Unauthorized
     * */
    public function emailPass($email, $pass)
    {
        if (!User::where('email', $email)->where('password', $pass)->firstOrFail()) {
            abort(401, "Unauthorized");
        }
        $api = User::where('email', $email)->where('password', $pass)->get();
        return response()->json([
            "success" => true,
            "data" => [
                "token" =>  $api[0]['api_token']
            ]
        ]);
    }
    /**
     * 2. GET api/v1/auth/logout
     * нужно найти юзера по токену (если не найден вернуть 404)
     * затем обновить этот токен через str_random и вернуть true
     * @return JSON
     *
     * */

    public function takeNewApi($api)
    {
        if (!User::where('api_token', $api)->firstOrFail()) {
            abort(404, "токен не найден");
        }
        $userId = User::where('api_token', $api)->get();
        $newApi = User::find($userId[0]['id']);
        $newApi->api_token = str_random(30);
        $newApi->save();
        return response()->json([
            "success" => true,
        ]);
    }
    /**
     * 3. GET api/v1/users?=API
     *
     * @return JSON
     * */

    public function users ()
    {
        $perPage = 5;
        $users = User::paginate($perPage)->except([]);
        return response()->json([
            "success" => true,
            "data" => [
                "users" => $users
            ],
        ]);
    }

    /**
     * 4. PATCH api/v1/user/{userId}
     * @return JSON
     * */
    public function updateInfoUsers(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'role' => ['required', new EnumKey(UserType::class)],
            'banned' => 'required|boolean',
        ]);
        $user->name = $request->get('name');
        $user->role = $request->get('role');
        $user->banned = $request->get('banned');
        $user->save();
        return response()->json([
            "success" => true,
            "data" => [
                "user" => $user,
            ],
        ]);
    }
}
