<?php

namespace Tests\Support;

use Illuminate\Support\Facades\DB;

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



}