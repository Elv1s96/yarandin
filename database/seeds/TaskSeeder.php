<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projectArr = [];
        for($i=1;$i<=21;$i++)
        {
            $projectArr[] = [
                'name' => "Test_Task_{$i}",'status' => rand(1,3), 'file_name' => "files/testFile_{$i}.txt", 'project_id' => rand(1,7)
            ];
        }
        DB::table('tasks')->insert($projectArr);
    }
}
