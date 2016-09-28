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
        $this->call(UsersTableSeeder::class);
        $this->call(IndividualsTableSeeder::class);
        $this->call(MaritalStatusTableSeeder::class);
        $this->call(RelationshipTypesTableSeeder::class);
        $this->call(HomeTypesTableSeeder::class);
        $this->call(AccountTypesTableSeeder::class);
        $this->call(AccountStatusTableSeeder::class);
        $this->call(BanksTableSeeder::class);
    }
}
