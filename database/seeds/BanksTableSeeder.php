<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = Carbon::now();

        DB::table('banks')->insert([
            ['name' => 'JP Morgan Chase & Co.', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Bank of America', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Wells Fargo', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Citigroup', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'US Bankcorp', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Bank of New York Mellon', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'PNC Bank', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Capital One', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'TD Bank', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'State Street', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'BB&T Bank', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Charles Schwab', 'created_at' => $dateNow, 'updated_at' => $dateNow],
        ]);
    }
}
