<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account_category extends Model{
    public $timestamps = false;

    protected $table = 'zoefin_model_MF.Account_category';

    protected $fillable = ['account_category_name','account_category_icon'];

    protected $guarded = ['account_category_id'];

}