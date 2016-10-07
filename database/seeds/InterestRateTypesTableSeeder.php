<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InterestRateTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = Carbon::now();

        DB::table('interest_rate_types')->insert([
            ['description' => 'Fixed', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Variable', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Hybrid', 'created_at' => $dateNow, 'updated_at' => $dateNow],
        ]);
    }
}
