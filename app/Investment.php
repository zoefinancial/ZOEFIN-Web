<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = ['individuals_id', 'investment_vehicles_id', 'investment_companies_id', 'employer', 'total_balance', 'initial', 'end'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function individual()
    {
        return $this->belongsTo(Individual::class);
    }

    public function investmentCompany()
    {
        return $this->belongsTo(InvestmentCompany::class);
    }

    public function investmentVehicle()
    {
        return $this->belongsTo(InvestmentVehicle::class);
    }
}
