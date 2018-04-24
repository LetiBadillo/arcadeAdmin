<?php

use Illuminate\Database\Seeder;

class SubjectBranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $branches = [
            ['branch_name' => 'Electrónica'],
            ['branch_name' => 'Literatura'],
            ['branch_name' => 'Electricidad'],
            ['branch_name' => 'Negocios'],
            ['branch_name' => 'Ciudadanía'],
        ];

        DB::table('subject_branches')->insert($branches);
    }
}
