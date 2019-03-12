<?php
namespace App\Http\Controllers\Views;

use App\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\app\Models\User\UserProfile;
use App\UserGroup;

class GroupController extends Controller
{
    public function index()
    {
        $groups = UserGroup::all();
        return view('pages.all_group')
            ->with('groups', $groups);
    }

    public function groupsUser(User $user)
    {
        $groups = $user->groups()->get();
        return view('pages.group')
            ->with('groups', $groups)
            ->with('user', $user);
    }

    public function delete($id)
    {
        UserGroup::find($id)->delete();
        return redirect('/groups');
    }

    public function addGroup(Request $request)
    {
        UserGroup::create(['name' => $request['name']]);
        return redirect('/groups');
    }
}