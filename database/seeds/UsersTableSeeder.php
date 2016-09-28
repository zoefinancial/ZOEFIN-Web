<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = Carbon::now();

        DB::table('users')->insert([
            ['id'=>1, 'email' => 'andres@zoefin.com', 'password' => bcrypt('12345678'), 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['id'=>2, 'email' => 'miguel@zoefin.com', 'password' => bcrypt('12345678'), 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['id'=>3, 'email' => 'alberto@zoefin.com', 'password' => bcrypt('12345678'), 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['id'=>4, 'email' => 'melissa@zoefin.com', 'password' => bcrypt('12345678'), 'created_at' => $dateNow, 'updated_at' => $dateNow],
        ]);
    }
}
