<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestmentCompany extends Model
{
    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
}
