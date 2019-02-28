<?php

use Illuminate\Database\Seeder;

class DatabaseSeederUserGroups extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 16; $i++)
        {
            DB::table('user_groups')->insert([
                'user_id' => $i,
                'group_id' => $i
            ]);
        }
        for ($i = 1; $i < 10; $i++)
        {
            DB::table('user_groups')->insert([
                'user_id' => $i,
                'group_id' => $i + 3
            ]);
        }
    }
}
