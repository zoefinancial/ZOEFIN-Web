<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class QuovoUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = Carbon::now();

        DB::table('quovo_users')->insert([
            ['user_id' => '3', 'quovo_user_id' => '642745' ,'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['user_id' => '2', 'quovo_user_id' => '642745' ,'created_at' => $dateNow, 'updated_at' => $dateNow],
        ]);
    }
}
