<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AccountTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = Carbon::now();

        DB::table('account_types')->insert([
            ['description' => 'Checking Account', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Saving Account', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'Others', 'created_at' => $dateNow, 'updated_at' => $dateNow],
        ]);
    }
}
