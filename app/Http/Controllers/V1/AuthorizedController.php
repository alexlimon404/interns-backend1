<?php

namespace App\Http\Controllers\V1;

use App\User;
use App\app\Models\User\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorizedController extends Controller
{

    /*
     *
     * */
    public function emailPass($email, $pass)
    {
        if (!User::where('email', $email)->where('password', $pass)->firstOrFail()) {
            abort(401, "проафиль с id -  не найдена");
        }
        $api = User::where('email', $email)->where('password', $pass)->get();
        return response()->json([
            "success" => true,
            "data" => [
                "token" =>  $api[0]['api_token']
            ]
        ]);
    }
    /*
     *
     *
     * */

    public function newApi(Request $request)
    {

    }



}
