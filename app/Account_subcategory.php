<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account_subcategory extends Model{
    public $timestamps = false;

    protected $table = 'zoefin_model_MF.Account_subcategory';

    protected $fillable = ['account_subcategory_name','account_subcategory_icon','account_subcategory_id'];

}