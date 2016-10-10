<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestmentVehicle extends Model
{
    protected $fillable = ['description', 'tax_deferred'];

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
}
