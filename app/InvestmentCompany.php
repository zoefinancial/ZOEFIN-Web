<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestmentCompany extends Model
{
    protected $fillable = ['quovo_id','name'];

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function getInvestmentCompany($data)
    {
        $investmentCompany = InvestmentCompany::where('quovo_id', $data['quovo_id'])->first();

        if (is_null($investmentCompany)) {
            $investmentCompany = InvestmentCompany::create($data);
        }

        return $investmentCompany;
    }
}
