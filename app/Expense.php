<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $hidden = array('users_id','expense_types_id');

    protected $fillable = ['users_id','expense_types_id','loan_id','date','value','banking_account_id','quovo_transaction_id'];

    public function ExpenseType()
    {
        return $this->hasOne('App\ExpenseType','id','expense_types_id');
    }

    public function Loan()
    {
        return $this->hasOne('App\Loan','id','loan_id');
    }

    public function BankingAccount()
    {
        return $this->hasOne('App\BankingAccount','id','banking_account_id');
    }

    public function Subtype(){
        return $this->hasOne('App\ExpenseSubtype','id','expense_subtype_id');
    }

    protected $dates = ['date'];
}