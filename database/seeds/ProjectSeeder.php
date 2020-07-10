<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projectArr = [];
        for($i=1;$i<=7;$i++)
        {
            $projectArr[] = [
                'name' => "Test_Project_{$i}",'user_id' => $i
            ];
        }
        DB::table('projects')->insert($projectArr);
    }
}
