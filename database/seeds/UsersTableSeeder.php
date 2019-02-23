<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
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
}
