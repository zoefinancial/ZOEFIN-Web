<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AccountStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = Carbon::now();

        DB::table('account_status')->insert([
            ['description' => 'active', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'inactive', 'created_at' => $dateNow, 'updated_at' => $dateNow],
        ]);
    }
}
