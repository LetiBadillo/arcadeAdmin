<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = ['name' => 'Super', 
                'last_name' => 'User', 
                'email' => 'admin@admin.com', 
                'password' => Hash::make('123456'), 
                'enabled'=> 1, 
                'user_type' => '1'
            ];
        DB::table('users')->insert($admin);
        
        }
}
