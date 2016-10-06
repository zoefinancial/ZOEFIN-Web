<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InvestmentVehiclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = Carbon::now();

        DB::table('investment_vehicles')->insert([
            ['description' => '401K', 'tax_deferred' => 1, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => '529', 'tax_deferred' => 1, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'IRA', 'tax_deferred' => 1, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Roth IRA', 'tax_deferred' => 1, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Securities', 'tax_deferred' => 0, 'created_at' => $dateNow, 'updated_at' => $dateNow],
        ]);
    }
}
