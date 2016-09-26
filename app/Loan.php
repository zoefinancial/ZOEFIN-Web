<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = ['users_id','amount'];

    public function getLoanType()
    {
        return $this->hasOne('App\LoanType','id','loan_types_id');
    }
}