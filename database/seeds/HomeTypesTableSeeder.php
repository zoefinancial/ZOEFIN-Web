<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HomeTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = Carbon::now();

        DB::table('home_types')->insert([
            ['description' => 'Primary', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Vacation', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Investment', 'created_at' => $dateNow, 'updated_at' => $dateNow]
        ]);

    }
}
