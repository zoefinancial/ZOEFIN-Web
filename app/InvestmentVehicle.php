<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestmentVehicle extends Model
{
    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
}
