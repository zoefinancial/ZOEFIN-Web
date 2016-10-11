<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $hidden = array('users_id','income_types_id');

    protected $fillable = ['users_id','income_types_id','loan_id','date','value','banking_account_id','quovo_transaction_id'];

    public function IncomeType()
    {
        return $this->hasOne('App\IncomeType','id','income_types_id');
    }

    protected $dates = ['date'];


}