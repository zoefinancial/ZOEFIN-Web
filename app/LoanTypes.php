<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanTypes extends Model{

    protected $table = 'loan_types';

    protected $fillable = ['description'];


}