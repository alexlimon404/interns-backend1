<?php
namespace App\Http\Controllers\Views;

use App\Http\Controllers\Controller;
use App\app\Models\User\UserProfile;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    function index()
    {
        $profiles = UserProfile::all();
        return view('pages.profiles')->with('profiles', $profiles);
    }

    function delete($id)
    {
        UserProfile::find($id)->delete();
        return redirect('/profiles');
    }

    public function addProfile(Request $request)
    {
        UserProfile::create(['name' => $request['profile']]);
        return redirect('/profiles');
    }
}