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
        DB::table('marital_status')->insert([
            ['description' => 'single', 'created_at' => Carbon::now()],
            ['description' => 'married', 'created_at' => Carbon::now()],
            ['description' => 'divorced', 'created_at' => Carbon::now()]
        ]);
    }
}
