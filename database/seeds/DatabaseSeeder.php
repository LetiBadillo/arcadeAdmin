<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SubjectBranchesTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
