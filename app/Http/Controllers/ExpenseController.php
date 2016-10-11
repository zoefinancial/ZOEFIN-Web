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

    private function getExpensesByCategoryAndDates($expenses){
        $result = array();
        foreach ($expenses as $expense){
            if(!isset($result[$expense->ExpenseType->description][$expense->date->format('Y-M')])){
                $result[$expense->ExpenseType->description][$expense->date->format('Y-M')]=0;
            }
            $result[$expense->ExpenseType->description][$expense->date->format('Y-M')]-=$expense->value;
        }
        return $result;
    }

    function getExpenses(){
        $expenses = Auth::user()->getExpenses();
        return self::getExpensesByCategoryAndDates($expenses);
    }

    function getExpensesBetweenDates($from,$to){
        $expenses = Auth::user()->getExpensesBetweenDates($from,$to);
        return self::getExpensesByCategoryAndDates($expenses);
    }

    function getExpensesTimeLineByAccount(){
        $expenses = Auth::user()->getExpenses();
        return self::getExpensesByAccountAndDates($expenses);
    }

    private function getExpensesByAccount($expenses){
        $result = array();
        $loans = array();
        $banking_accounts=array();

        foreach ($expenses as $expense){
            if($expense->loan_id!=null){
                if(!isset($loans[$expense->loan_id])){
                    $loan = $expense->Loan;
                    $loans[$expense->loan_id] = $loan;
                }else{
                    $loan = $loans[$expense->loan_id];
                }
                $account=$loan->number;
            }else{
                if($expense->banking_account_id!=null){
                    if(!isset($banking_accounts[$expense->banking_account_id])){
                        $banking_account = $expense->BankingAccount;
                        $banking_accounts[$expense->banking_account_id] = $banking_account;
                    }else{
                        $banking_account = $banking_accounts[$expense->banking_account_id];
                    }
                    $account=$banking_account->number;
                }
                else{
                    $account='Unknown';
                }
            }

            if(!isset($result[$account])){
                $result[$account]=0;
            }
            $result[$account]-=$expense->value;
        }
        return $result;
    }

    function getExpensesPieByAccount(){
        $expenses = Auth::user()->getExpenses();
        return self::getExpensesByAccount($expenses);
    }

    function getExpensesPieBetweenDatesByAccount($from,$to){
        $expenses = Auth::user()->getExpensesBetweenDates($from,$to);
        return self::getExpensesByAccount($expenses);
    }

    private function getExpensesByAccountAndDates($expenses){
        $result = array();
        $loans = array();
        $banking_accounts=array();
        foreach ($expenses as $expense){
            if($expense->loan_id!=null){
                if(!isset($loans[$expense->loan_id])){
                    $loan = $expense->Loan;
                    $loans[$expense->loan_id] = $loan;
                }else{
                    $loan = $loans[$expense->loan_id];
                }
                $account=$loan->number;
            }else{
                if($expense->banking_account_id!=null){
                    if(!isset($banking_accounts[$expense->banking_account_id])){
                        $banking_account = $expense->BankingAccount;
                        $banking_accounts[$expense->banking_account_id] = $banking_account;
                    }else{
                        $banking_account = $banking_accounts[$expense->banking_account_id];
                    }
                    $account=$banking_account->number;
                }
                else{
                    $account='Unknown';
                }
            }

            if(!isset($result[$account][$expense->date->format('Y-M')])){
                $result[$account][$expense->date->format('Y-M')]=0;
            }
            $result[$account][$expense->date->format('Y-M')]-=$expense->value;
        }
        return $result;
    }

    function getExpensesByAccountAndDate($from,$to){
        $expenses = Auth::user()->getExpensesBetweenDates($from,$to);
        return self::getExpensesByAccountAndDates($expenses);
    }

    private function getExpensesByCategory($expenses){
        $result = array();
        foreach ($expenses as $expense){
            if(!isset($result[$expense->ExpenseType->description])){
                $result[$expense->ExpenseType->description]=0;
            }
            $result[$expense->ExpenseType->description]-=$expense->value;
        }
        return $result;
    }

    function getExpensesCategorization(){
        $expenses = Auth::user()->getExpenses();
        return self::getExpensesByCategory($expenses);
    }

    function getExpensesCategorizationBetweenDates($from,$to){
        $expenses = Auth::user()->getExpensesBetweenDates($from,$to);
        return self::getExpensesByCategory($expenses);
    }

    private function getExpensesArray($expenses){
        $result = array();

        $loans = array();
        $loan_types = array();
        $banking_accounts=array();
        $banking_account_types=array();
        $expense_types = array();

        foreach ($expenses as $expense){

            if($expense->loan_id!=null){
                if(!isset($loans[$expense->loan_id])){
                    $loan = $expense->Loan;
                    $loans[$expense->loan_id] = $loan;
                }else{
                    $loan = $loans[$expense->loan_id];
                }
                $account=$loan->number;
                if(!isset($loan_types[$loan->loan_types_id])){
                    $account_type = $loan->getLoanType;
                    $loan_types[$loan->loan_types_id] = $account_type;
                }else{
                    $account_type = $loan_types[$loan->loan_types_id];
                }
                $account_type_description=$account_type->description;
            }else{
                if($expense->banking_account_id!=null){
                    if(!isset($banking_accounts[$expense->banking_account_id])){
                        $banking_account = $expense->BankingAccount;
                        $banking_accounts[$expense->banking_account_id] = $banking_account;
                    }else{
                        $banking_account = $banking_accounts[$expense->banking_account_id];
                    }
                    $account=$banking_account->number;
                    if(!isset($banking_account_types[$banking_account->account_types_id])){
                        $account_type = $banking_account->getAccountType;
                        $banking_account_types[$banking_account->account_types_id] = $account_type;
                    }else{
                        $account_type = $banking_account_types[$banking_account->account_types_id];
                    }
                    $account_type_description=$account_type->description;
                }
                else{
                    $account='Unknown';
                    $account_type_description='Unknown';
                }
            }

            if(!isset($expense_types[$expense->expense_types_id])){
                $expense_type = $expense->ExpenseType;
                $expense_types[$expense->expense_types_id]=$expense_type;
            }else{
                $expense_type = $expense_types[$expense->expense_types_id];
            }
            $expense_type_description=$expense_type->description;

            $result[] = ['Date'=>$expense->date->format('Y-m-d'),
                'Value'=>$expense->value,
                'Account type'=>$account_type_description,
                'Account Number'=>$account,
                'Expense category'=>$expense_type_description,
                'Transaction description'=>$expense->description
            ];
        }
        return $result;
    }

    function getAllExpenses(){
        $expenses = Auth::user()->getExpenses();
        return self::getExpensesArray($expenses);
    }

    function getAllExpensesBetweenDates($from,$to){
        $expenses = Auth::user()->getExpensesBetweenDates($from,$to);
        return self::getExpensesArray($expenses);
    }
}