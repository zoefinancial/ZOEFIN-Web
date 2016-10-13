<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = ['users_id', 'loan_types_id', 'bank_id', 'account_quovo_id', 'quovo_id', 'active', 'amount', 'interest_rate', 'name', 'comments', 'details', 'quovo_last_change'];

    public function getLoanType()
    {
        return $this->hasOne('App\LoanType', 'id', 'loan_types_id');
    }
}
