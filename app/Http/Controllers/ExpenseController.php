<?php
/**
 * Created by PhpStorm.
 * User: miguelfruto
 * Date: 20/09/16
 * Time: 5:48 PM
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function getExpenses(){
        $result = array();
        foreach (Auth::user()->getExpenses() as $expense){
            $result[$expense->ExpenseType->description][$expense->date->format('Y-M')]=$expense->value;
            if(!isset($result['Total'][$expense->date->format('Y-M')])){
                $result['Total'][$expense->date->format('Y-M')]=0;
            }
            $result['Total'][$expense->date->format('Y-M')]+=$expense->value;
        }
        return $result;
    }
}