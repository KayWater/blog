<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // seeder administrator
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => '793500318@qq.com',
            'email_verified_at' => date("Y-m-d H:i:s"),
            'password' => bcrypt('111111'),
            'is_admin' => 1,
        ]);
    }
}
