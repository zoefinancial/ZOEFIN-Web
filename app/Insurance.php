<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $fillable = ['individuals_id','company_name','coverage','insurance_type','years','anual_payment'];

}