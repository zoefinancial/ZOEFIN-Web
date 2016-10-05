<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InvestmentCompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = Carbon::now();

        DB::table('investment_companies')->insert([
            ['name' => 'Betterment', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'JP Morgan Funds', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Wealthfront', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Fidelity', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Etrade', 'created_at' => $dateNow, 'updated_at' => $dateNow],

        ]);
    }
}
