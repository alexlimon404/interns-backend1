<?php

use Illuminate\Database\Seeder;

class DatabaseSeederUserGroup extends Seeder
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
            DB::table('user_group')->insert([
                'name' => 'UserGroup ' . $i . ' - ' . str_random(1)
            ]);

        }
    }
}
