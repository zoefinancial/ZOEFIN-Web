<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = ['quovo_id', 'name'];

    static public function getQuovoBank($data)
    {
        $bank = Bank::select('id')
                        ->where('quovo_id', $data['quovo_id'])
                        ->first();

        if( is_null($bank)) {
            $bank = InvestmentCompany::create($data);
        }

        return $bank;
    }
}
