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
        ]);
    }
}
