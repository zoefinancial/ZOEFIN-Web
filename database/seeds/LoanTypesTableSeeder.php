<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LoanTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = Carbon::now();

        DB::table('loan_types')->insert([
            ['description' => 'Mortgage', 'icon' => 'fa fa-home', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Car loan', 'icon' => 'fa fa-car', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Student loan', 'icon' => 'fa fa-book', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Credit card', 'icon' => 'fa fa-credit-card', 'created_at' => $dateNow, 'updated_at' => $dateNow],
        ]);
    }
}
