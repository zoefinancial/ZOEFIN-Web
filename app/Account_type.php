<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account_type extends Model{
    public $timestamps = false;

    protected $table = 'zoefin_model_MF.Account_types';

    protected $fillable = ['account_type_name', 'tac_deferred_bl', 'account_sum_bl','taxeable_bl','account_subcategory_id'];

    protected $guarded = ['account_type_id'];

}