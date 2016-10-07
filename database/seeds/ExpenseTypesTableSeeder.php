<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ExpenseTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = Carbon::now();

        DB::table('expense_types')->insert([
            ['description' => 'Mortgage', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'House taxes/Insurance', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Additional taxes', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Home yearly servicing', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Home Projects', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Child care/nanny', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Food', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'School', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Out of school kid programs', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Car payments/lease', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => '529 Plan', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Helping out parents', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Shopping (electronics, clothes, books)', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Kids toys/kids gift', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Vacation', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Heating oil', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Gasoline', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Donations', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Train commute', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Car Maintenance', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Life Insurance', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Electricity', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Phones', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Lawn & Landscape', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Hair cuts/nails', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Cable/Netflix', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Car parking', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'House alarm', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Dry Cleaning', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Tax services', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'EZ Pass', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Entertainment (Movies, going out to bars)', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Doctors', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Newspapers', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'AMEX Membership', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Snow Removal', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Sprinkler', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Air condition services', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Boiler services', 'created_at' => $dateNow, 'updated_at' => $dateNow],
        ]);
    }
}
