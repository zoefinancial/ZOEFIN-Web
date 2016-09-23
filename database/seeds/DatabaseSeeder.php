<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MaritalStatusTableSeeder::class);
        $this->call(RelationshipTypesTableSeeder::class);
        $this->call(HomeTypesTableSeeder::class);
    }
}
