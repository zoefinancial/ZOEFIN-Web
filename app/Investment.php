<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Investment extends Model
{
    protected $fillable = ['individuals_id', 'investment_vehicles_id', 'investment_companies_id', 'account_quovo_id', 'quovo_id', 'active', 'employer', 'total_balance', 'name', 'quovo_last_change', 'initial', 'end'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function individual()
    {
        return $this->belongsTo(Individual::class, 'individuals_id', 'id');
    }

    public function investmentCompany()
    {
        return $this->belongsTo(InvestmentCompany::class, 'investment_companies_id', 'id');
    }

    public function investmentVehicle()
    {
        return $this->belongsTo(InvestmentVehicle::class,'investment_vehicles_id','id');
    }

    public function taxesDistribution($user_id)
    {
        return DB::table('investments')
                ->join('investment_vehicles', 'investments.investment_vehicles_id', '=', 'investment_vehicles.id')
                ->select(DB::raw("CASE  investment_vehicles.tax_deferred When 1 THEN 'Tax deferred' ELSE 'Taxable' END as description, sum(investments.`total_balance`) total"))
                ->where('investments.users_id', '=', $user_id)
                ->groupBy('investment_vehicles.tax_deferred')
                ->get();
    }

    public function vehicleGroup($user_id)
    {
        return DB::table('investments')
            ->join('investment_vehicles', 'investments.investment_vehicles_id', '=', 'investment_vehicles.id')
            ->select(DB::raw("investment_vehicles.description Vehicle, sum(investments.`total_balance`) Total, CASE  investment_vehicles.tax_deferred When 1 THEN 'Tax deferred' ELSE 'Taxable' END as Category"))
            ->where('investments.users_id', '=', $user_id)
            ->groupBy('investment_vehicles.id')
            ->get();
    }
}
