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
            ['name' => 'JP Morgan Chase & Co.', 'quovo_id' => 12, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Bank of America', 'quovo_id' => 99, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Wells Fargo', 'quovo_id' => 100, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Citigroup', 'quovo_id' => 101, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'US Bankcorp', 'quovo_id' => 102, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Bank of New York Mellon', 'quovo_id' => 103, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'PNC Bank', 'quovo_id' => 104, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Capital One', 'quovo_id' => 105, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'TD Bank', 'quovo_id' => 106, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'State Street', 'quovo_id' => 107, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'BB&T Bank', 'quovo_id' => 108, 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['name' => 'Charles Schwab', 'quovo_id' => 6, 'created_at' => $dateNow, 'updated_at' => $dateNow],
        ]);
    }
}
