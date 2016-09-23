<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Homes extends Model
{
    protected $fillable = ['users_id','home_types_id','investments_id', 'address', 'city', 'state', 'zip','current_value'];
}