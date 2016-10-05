<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $hidden = array('users_id','expense_types_id');

    public function ExpenseType()
    {
        return $this->hasOne('App\ExpenseType','id','expense_types_id');
    }

    protected $dates = ['date'];
}