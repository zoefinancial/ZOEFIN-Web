<?php
/**
 * Created by PhpStorm.
 * User: migfru
 * Date: 15/09/16
 * Time: 1:37 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuovoUser extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quovo_users';

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    public $timestamps = false;

}