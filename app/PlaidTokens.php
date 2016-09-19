<?php
/**
 * Created by PhpStorm.
 * User: migfru
 * Date: 15/09/16
 * Time: 1:37 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaidTokens extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'plaid_tokens';

    protected $primaryKey = 'public_token';

    public $incrementing = false;

    protected $guarded = ['public_token','access_token'];

}