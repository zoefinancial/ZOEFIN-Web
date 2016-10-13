<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class CashFlowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCashFlow()
    {
        $result = array();
        foreach (Auth::user()->getIncomes() as $income) {
            if (!isset($result['Total'][$income->date->format('Y-M')])) {
                $result['Incomes'][$income->date->format('Y-M')]=0;
                $result['Expenses'][$income->date->format('Y-M')]=0;
                $result['Total'][$income->date->format('Y-M')]=0;
            }
            $result['Incomes'][$income->date->format('Y-M')]+=$income->value;
            $result['Total'][$income->date->format('Y-M')]+=$income->value;
        }
        foreach (Auth::user()->getExpenses() as $expense) {
            if (!isset($result['Total'][$expense->date->format('Y-M')])) {
                $result['Incomes'][$expense->date->format('Y-M')]=0;
                $result['Expenses'][$expense->date->format('Y-M')]=0;
                $result['Total'][$expense->date->format('Y-M')]=0;
            }
            $result['Expenses'][$expense->date->format('Y-M')]+=$expense->value;
            $result['Total'][$expense->date->format('Y-M')]+=$expense->value;
        }
        return $result;
    }
}
