<?php
/**
 * Created by PhpStorm.
 * User: miguelfruto
 * Date: 20/09/16
 * Time: 5:48 PM
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function getIncomes(){
        $result = array();
        foreach (Auth::user()->getIncomes() as $income){
            $result[$income->IncomeType->description][$income->date->format('Y-M')]=$income->value;
            if(!isset($result['Total'][$income->date->format('Y-M')])){
                $result['Total'][$income->date->format('Y-M')]=0;
            }
            $result['Total'][$income->date->format('Y-M')]+=$income->value;
        }
        return $result;
    }
}