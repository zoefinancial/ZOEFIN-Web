<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class IncomeTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = Carbon::now();

        DB::table('income_types')->insert([
            ['description' => 'Salary', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Bonus', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Investments Dividends', 'created_at' => $dateNow, 'updated_at' => $dateNow],
        ]);
    }
}
