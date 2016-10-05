<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Investment extends Model
{
    protected $fillable = ['individuals_id', 'investment_vehicles_id', 'investment_companies_id', 'employer', 'total_balance', 'initial', 'end'];

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
       /* return array(['Tax Type'=>'Federal','Marginal Tax Rate'=>'28%','Effective Tax Rate'=>'18%','Tax Amount'=>'44123'],
            ['Tax Type'=>'Social Security','Marginal Tax Rate'=>'1.45%','Effective Tax Rate'=>'6.7%','Tax Amount'=>'16715'],
            ['Tax Type'=>'State','Marginal Tax Rate'=>'6.7%','Effective Tax Rate'=>'6.3%','Tax Amount'=>'15664'],
            ['Tax Type'=>'Local','Marginal Tax Rate'=>'0%','Effective Tax Rate'=>'0%','Tax Amount'=>'0']);*/

        return DB::table('investments')
            ->join('investment_vehicles', 'investments.investment_vehicles_id', '=', 'investment_vehicles.id')
            ->select(DB::raw("investment_vehicles.description Vehicle, sum(investments.`total_balance`) Total, CASE  investment_vehicles.tax_deferred When 1 THEN 'Tax deferred' ELSE 'Taxable' END as Category"))
            ->where('investments.users_id', '=', $user_id)
            ->groupBy('investment_vehicles.id')
            ->get();
    }
}
