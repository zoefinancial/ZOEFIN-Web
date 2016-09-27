<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class IndividualsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = Carbon::now();

        DB::table('individuals')->insert([
            ['users_id'=>1, 'marital_status_id' => 1, 'name' => 'andres@zoefin.com', 'lastname' => bcrypt('12345678'), 'date_birth' => '1983-01-01', 'gender' => 'M', 'principal' => 1, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['users_id'=>2, 'marital_status_id' => 1, 'name' => 'miguel@zoefin.com', 'lastname' => bcrypt('12345678'), 'date_birth' => '1983-01-01', 'gender' => 'M', 'principal' => 1, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['users_id'=>3, 'marital_status_id' => 1, 'name' => 'alberto@zoefin.com', 'lastname' => bcrypt('12345678'), 'date_birth' => '1983-01-01', 'gender' => 'M', 'principal' => 1, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['users_id'=>4, 'marital_status_id' => 1, 'name' => 'melissa@zoefin.com', 'lastname' => bcrypt('12345678'), 'date_birth' => '1983-01-01', 'gender' => 'F', 'principal' => 1, 'created_at' => $dateNow, 'updated_at' => $dateNow],
        ]);
    }
}
