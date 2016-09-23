<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Individual extends Model
{
    protected $fillable = ['users_id','name','lastname', 'gender', 'marital_status_id', 'date_birth', 'principal'];
}