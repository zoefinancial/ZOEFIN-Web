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
            ['name' => 'Betterment', 'quovo_id' => 99, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'JP Morgan Funds', 'quovo_id' => 101, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Wealthfront', 'quovo_id' => 102, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Fidelity', 'quovo_id' => 2, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Etrade', 'quovo_id' => 1, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Others', 'quovo_id' => 999999, 'created_at' => $dateNow, 'updated_at' => $dateNow],

        ]);
    }
}
