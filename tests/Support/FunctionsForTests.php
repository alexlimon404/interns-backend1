<?php

namespace Tests\Support;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class FunctionsForTests
{
    public static function createUsers($amount = null)
    {
        $amount = $amount ? : 1;
        for ($i = 1; $i <= $amount; $i++)
        {
            DB::table('users')->insert([
                'name' => 'Random name ' . $i . ' - ' . str_random(3),
                'email' => str_random(10).'@gmail.com',
                'password' => bcrypt('secret'),
            ]);

            DB::table('user_profiles')->insert([
                'name' => 'Profile ' . $i,
                'user_id' => $i,
            ]);
        }
    }

    public static function createGroups ($amount = null)
    {
        for ($i = 1; $i <= $amount; $i++)
        {
            DB::table('user_group')->insert([
                'name' => 'UserGroup ' . $i . ' - ' . str_random(1)
            ]);
        }
    }

    public static function createGroupsForUsers($amount = null)
    {
        for ($i = 1; $i <= $amount; $i++)
        {
            DB::table('user_groups')->insert([
                'user_id' => $i,
                'group_id' => $i
            ]);
        }
    }

    public static function createOneUsers ($role = null, $name = null, $email = null, $api_token = null)
    {
        $role = $role ? : 'User';
        $name = $name ? : 'Valera';
        $email = $email ? : 'email@email.com';
        $api_token = $api_token ? : 1234;

        $password = Hash::make(123);
        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->api_token = $api_token;
        $user->role = $role;
        $user->save();
        return $user;
    }

    public static function delUser ($name = null)
    {
        $name = $name ? : 'Valera';
        $user = User::where('name', $name);
        $user->delete();
    }


}