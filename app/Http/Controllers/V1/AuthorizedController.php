<?php

namespace App\Http\Controllers\V1;

use App\Mail\UpdateUserDataAlertEmail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use BenSampo\Enum\Rules\EnumKey;
use App\Enums\UserType;
use Illuminate\Support\Facades\Queue;
use App\Jobs\AlertEmail;
use Illuminate\Support\Facades\Hash;

class AuthorizedController extends Controller
{
    /**
     * 1. GET api/v1/auth/login
     * нужно вернуть api_token из таблицы users
     * если комбинация email & пароля неправильная, вернуть: 401 - Unauthorized
     * сделать hash для тестов dd(Hash::make(123));
     * */
    public function emailPass(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->firstOrFail();
        if(!Hash::check($request->password, $user->password))
            abort(401, 'Unauthorized');
        return response()->json([
            "success" => true,
            "data" => [
                "token" =>  $user->api_token
            ]
        ]);
    }

    /**
     * 2. GET api/v1/auth/logout/{api}
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
        $userId = User::where('api_token', $api)->firstOrFail();
        $newApi = User::where('id', $userId->id)->firstOrFail();
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
        $users = User::paginate($perPage);
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
    public function updateInfoUsers($id, Request $request)
    {
        $admin = User::where('api_token', $request->api_token)->firstOrFail();
        $this->validate($request, [
            'name' => 'required|string',
            'role' => ['required', new EnumKey(UserType::class)],
            'banned' => 'required|boolean',
        ]);
        $oldDataUser = User::find($id);
        $user = User::find($id);
        $user->name = $request->get('name');
        $user->role = $request->get('role');
        $user->banned = $request->get('banned');
        $user->save();
        $updateDataUser = new UpdateUserDataAlertEmail($oldDataUser, $user, $admin);
        Queue::push(new AlertEmail($updateDataUser));
        return response()->json([
            "success" => true,
            "data" => [
                "user" => $user,
            ],
        ]);
    }
}
