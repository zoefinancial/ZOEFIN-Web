<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loans extends Model
{
    protected $fillable = ['users_id','ammount'];

    public function getLoanType()
    {
        return $this->hasOne('App\LoanTypes','id','loan_types_id');
    }
}