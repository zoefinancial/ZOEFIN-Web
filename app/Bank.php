<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = ['quovo_id', 'name'];

    public static function getQuovoBank($data)
    {
        $bank = Bank::select('id')
                        ->where('quovo_id', $data['quovo_id'])
                        ->first();

        if (is_null($bank)) {
            $bank = Bank::create($data);
        }

        return $bank;
    }
}
