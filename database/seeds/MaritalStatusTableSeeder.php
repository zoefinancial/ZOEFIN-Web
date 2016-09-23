<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MaritalStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = Carbon::now();

        DB::table('marital_status')->insert([
            ['description' => 'single', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'married', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'divorced', 'created_at' => $dateNow, 'updated_at' => $dateNow],
        ]);
    }
}
