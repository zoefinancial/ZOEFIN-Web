<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $fillable = ['users_id','home_types_id','investments_id', 'address', 'city', 'state', 'zip','current_value'];

    public function getHomeType()
    {
        return $this->hasOne('App\HomeType', 'id', 'home_types_id');
    }
}
