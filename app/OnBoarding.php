<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnBoarding extends Model
{
    protected $table = 'on_boardings';
    protected $fillable = [ 'marital_status_id', 'gender', 'income', 'date_birth'];
}
