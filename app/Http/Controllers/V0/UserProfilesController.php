<?php

namespace App\Http\Controllers\V0;

use Illuminate\Database\Eloquent\Model;
use App\app\Models\User\UserProfile;

class UserProfilesController extends Model
{

    public function profileId($id)
    {
        return UserProfile::find($id);
    }

    public function userId($user_id)
    {
        return UserProfile::find($user_id);
    }

    public function index()
    {
        return UserProfile::all();
        //return 'Hello world';
    }
}