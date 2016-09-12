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
        DB::table('relationship_types')->insert([
            ['description' => 'spouse', 'created_at' => Carbon::now()],
            ['description' => 'child', 'created_at' => Carbon::now()]
        ]);
    }
}
