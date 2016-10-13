<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankingAccount extends Model
{
    protected $fillable = ['users_id', 'banks_id', 'account_types_id', 'account_status_id', 'account_quovo_id', 'quovo_id', 'active', 'number', 'name', 'current_balance', 'quovo_last_change'];

    public function getAccountType()
    {
        return $this->hasOne('App\AccountType','id','account_types_id');
    }

    public function getBank()
    {
        return $this->hasOne('App\Bank','id','banks_id');
    }

    public function getAccountStatus()
    {
        return $this->hasOne('App\AccountStatus','id','account_status_id');
    }
}
