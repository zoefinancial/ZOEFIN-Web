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
        //parameters
        $this->call(MaritalStatusTableSeeder::class);
        $this->call(AccountStatusTableSeeder::class);
        $this->call(RelationshipTypesTableSeeder::class);
        $this->call(AccountTypesTableSeeder::class);
        $this->call(HomeTypesTableSeeder::class);
        $this->call(LoanTypesTableSeeder::class);
        $this->call(ExpenseTypesTableSeeder::class);
        $this->call(InterestRateTypesTableSeeder::class);
        $this->call(IncomeTypesTableSeeder::class);

        //populate
        $this->call(BanksTableSeeder::class);
        $this->call(InvestmentCompaniesTableSeeder::class);
        $this->call(InvestmentVehiclesTableSeeder::class);

        //test value
        $this->call(UsersTableSeeder::class);
        $this->call(IndividualsTableSeeder::class);

    }
}
