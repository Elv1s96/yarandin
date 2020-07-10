<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [];
/* раскомментить, если в таблице users нет этой записи с полными правами.
        $users[] = [
            'name' => 'Egor', 'email' => 'Egor@admin.com', 'password' => bcrypt('admin123'), 'is_admin' => 1
        ];
*/
        for($i=2;$i<=7;$i++)
        {
            $pass = bcrypt("user{$i}12345");
            $users[] = [
                'name' => "simpleUser{$i}",'email' => "simpleuser{$i}@user.com", 'password' => $pass, 'is_admin' => 0
            ];
        }
        DB::table('users')->insert($users);
    }
}
