<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $hidden = array('users_id','income_types_id');

    public function IncomeType()
    {
        return $this->hasOne('App\IncomeType','id','income_types_id');
    }

    protected $dates = ['date'];


}