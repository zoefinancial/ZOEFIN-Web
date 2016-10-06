<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuovoUser
 * @package App
 */
class QuovoUser extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quovo_users';

    protected $fillable = ['user_id', 'quovo_user_id'];

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    public $timestamps = false;

}