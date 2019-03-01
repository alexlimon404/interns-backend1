<?php

use Illuminate\Database\Seeder;

class UserApi extends Seeder
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
            DB::table('users')->update([
                'api_token' => str_random(30)
            ]);

        }
    }
}
