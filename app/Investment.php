<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
