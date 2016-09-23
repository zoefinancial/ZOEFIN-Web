<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RelationshipTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = Carbon::now();

        DB::table('relationship_types')->insert([
            ['description' => 'spouse', 'created_at' => $dateNow, 'updated_at' => $dateNow],
            ['description' => 'child', 'created_at' => $dateNow, 'updated_at' => $dateNow],
        ]);
    }
}
