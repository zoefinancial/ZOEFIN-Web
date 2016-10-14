<?php

namespace App\Http\Controllers;

use App\AccountType;
use App\Bank;
use App\BankingAccount;
use App\Expense;
use App\ExpenseSubtype;
use App\ExpenseType;
use App\Income;
use App\IncomeType;
use App\Loan;
use App\LoanType;
use App\QuovoUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Wela\Quovo;

class QuovoClientController extends Controller
{
    private static $quovo;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function getQuovo()
    {
        if (self::$quovo==null) {
            self::$quovo = new Quovo(['user'=>env('QUOVO_USER', ''), 'password'=>env('QUOVO_PASSWORD', '')]);
        }
        return self::$quovo;
    }

    public static function getQuovoUserId()
    {
        $quovoUsers =QuovoUser::where('user_id', Auth::user()->id)
            ->take(1)
            ->get();

        if (count($quovoUsers)==0) {
            $users=self::getQuovo()->user()->all();
            $found=null;
            foreach ($users->users as $user) {
                if ($user->email==Auth::user()->email) {
                    $found=$user->id;
                    break;
                }
            }
            if ($found==null) {
                $parameters=array('username'=>Auth::user()->email,'name'=>Auth::user()->name,'email'=>Auth::user()->email,'phone'=>null);
                $user=self::getQuovo()->user()->create($parameters);
                $found=$user->id;
            }
            $quovoUser= new QuovoUser(array('user_id'=>Auth::user()->id, 'quovo_user_id'=>$found));
            $quovoUser->save();
            $quovoUserid=$found;
        } else {
            $quovoUserid=$quovoUsers[0]->quovo_user_id;
        }
        return $quovoUserid;
    }

    public static function getIFrameToken()
    {
        try {
            $quovo_user_id=self::getQuovoUserId();
            $token =  self::getQuovo()->iframe()->getIframeToken($quovo_user_id);
            return ['user_id'=>$quovo_user_id,'token'=>$token->iframe_token->token];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getAccountType($description)
    {
        $accountType = AccountType::firstOrCreate(['description'=>$description]);
        return $accountType;
    }

    public static function processLoanPortfolio($portfolio)
    {
        $loan = self::getLoan($portfolio, $portfolio->user_id);
        $loan->amount=$portfolio->value;
        $loan->individuals_id=0;
        $loan->loan_status_id=0;
        $loan->comments='Synchronized with Quovo';
        $loan->save();
        return $loan;
    }

    public static function getBank($portfolio)
    {
        $bank = Bank::getQuovoBank(['quovo_id' => $portfolio->brokerage, 'name' =>$portfolio->brokerage_name]);
        return $bank;
    }

    public static function getLoan($portfolio, $user_id)
    {
        $loanType = LoanType::firstOrCreate(['description' => $portfolio->portfolio_type]);
        $bank = self::getBank($portfolio);
        $loan = Loan::firstOrCreate([
            'users_id' => $user_id,
            'loan_types_id' => $loanType->id,
            'bank_id'       => $bank->id,
            'name'          =>$portfolio->portfolio_name,
            'account_quovo_id'  => $portfolio->account,
            'quovo_id'          => $portfolio->id,
            'active'            => !($portfolio->is_inactive),
            'quovo_last_change' => $portfolio->last_change->timestamp,
        ]);
        return $loan;
    }

    public static function processInvestmentPortfolio($portfolio)
    {
        $investment = new InvestmentController();
        $investment->findOrCreate($portfolio);
        return true;
    }

    public static function processBankingPortfolio($portfolio)
    {
        $bank = self::getBank($portfolio);
        $accountType=self::getAccountType($portfolio->portfolio_type);
        $bankingAccount = BankingAccount::firstOrCreate(['users_id'=> $portfolio->user_id,
            'banks_id'=>$bank->id,
            'account_types_id'=>$accountType->id,
            'name'=>$portfolio->portfolio_name,
            'account_quovo_id'  => $portfolio->account,
            'quovo_id'          => $portfolio->id,
            'active'            => !($portfolio->is_inactive),
            'quovo_last_change' => $portfolio->last_change->timestamp,
            ]);
        $bankingAccount->current_balance=$portfolio->value;
        $bankingAccount->account_status_id=1;
        $bankingAccount->save();
        return $bankingAccount;
    }

    public static function processInsurancePortfolio($portfolio)
    {
        return true;
    }

    public static function processPortfolio($portfolio)
    {
        switch ($portfolio->portfolio_category) {
            case 'Loan':
                self::processLoanPortfolio($portfolio);
                break;
            case 'Investment':
                self::processInvestmentPortfolio($portfolio);
                break;
            case 'Banking':
                if ($portfolio->portfolio_type == 'Credit Card') {
                    self::processLoanPortfolio($portfolio);
                } else {
                    self::processBankingPortfolio($portfolio);
                }
                break;
            case 'Insurance':
                self::processInsurancePortfolio($portfolio);
                break;
        }
    }

    public static function clientSync()
    {
        try {
            $quovo_user_id=self::getQuovoUserId();
            $quovoResponse=self::getQuovo()->user()->portfolios($quovo_user_id);
            foreach ($quovoResponse->portfolios as $portfolio) {
                $portfolio->portfolio_name = \str_replace(array('*'), '', $portfolio->portfolio_name);
                $portfolio->last_change = new Carbon($portfolio->last_change);

                if ($portfolio->portfolio_category != 'Unknown') {
                    $portfolio->user_id = Auth::user()->id;
                    self::processPortfolio($portfolio);
                }
            }
            return response()->json(['Information'=>'Synchronizing process succeed']);
        } catch (\Exception $e) {
            return response()->json(['Information'=>'Synchronizing process failed']);
        }
    }

    public static function completeSync()
    {
        $quovoUsers = QuovoUser::all();
        /*$quovoUsers = QuovoUser::where('user_id','2')->get();*/
        foreach ($quovoUsers as $quovoUser) {
            $userPortfolios = self::getQuovo()->user()->portfolios($quovoUser->quovo_user_id);
            foreach ($userPortfolios->portfolios as $userPortfolio) {
                $transactions = array();
                try {
                    $transactions = self::getQuovo()->portfolio()->transactions($userPortfolio->id);
                } catch (\Exception $e) {
                    echo "Error retrieving the transactions: ".$e->getMessage();
                }
                if (count($transactions)>0) {
                    foreach ($transactions->history as $transaction) {
                        self::processTransaction($quovoUser->user_id, $userPortfolio, $transaction);
                    }
                }
            }
        }
    }

    public static function processTransaction($user_id, $portfolio, $transaction)
    {
        switch ($portfolio->portfolio_category) {
            case 'Loan':
                return self::processLoanTransaction($user_id, $portfolio, $transaction);
                break;
            case 'Banking':
                if ($portfolio->portfolio_type=='Credit Card') {
                    return self::processLoanTransaction($user_id, $portfolio, $transaction);
                } else {
                    return self::processBankingTransaction($user_id, $portfolio, $transaction);
                }
                break;
        }
    }

    public static function processLoanTransaction($user_id, $portfolio, $transaction)
    {
        $loan=self::processLoanPortfolio($portfolio, $user_id);
        $db_transaction=null;
        if ($transaction->value<0) {
            $db_transaction = Expense::firstOrCreate(['users_id'=>$user_id,
                'loan_id'=>$loan->id,
                'quovo_transaction_id'=>$transaction->id,
            ]);
            if($db_transaction->expense_type_id==null){
                if (!property_exists($transaction, 'expense_category') || $transaction->expense_category==null) {
                    $expenseType = ExpenseType::firstOrCreate(['description'=>'Other']);
                } else {
                    $expenseType = ExpenseType::firstOrCreate(['description'=>$transaction->expense_category]);
                }
                $db_transaction->expense_types_id=$expenseType->id;
            }

            if($db_transaction->expense_subtype_id==null){
                $db_transaction->expense_subtype_id=ExpenseSubtype::firstOrCreate(['description'=>'Recurring Expense']);
            }
        } else {
            if (!property_exists($transaction, 'expense_category') || $transaction->expense_category==null) {
                $incomeType = ExpenseType::firstOrCreate(['description'=>'Other']);
            } else {
                $incomeType = ExpenseType::firstOrCreate(['description'=>$transaction->expense_category]);
            }
            $db_transaction = Income::firstOrCreate(['users_id'=>$user_id,
            'loan_id'=>$loan->id,
            'quovo_transaction_id'=>$transaction->id]);
            $db_transaction->income_types_id=$incomeType->id;
        }
        $db_transaction->date=$transaction->date;
        $db_transaction->value=$transaction->value;
        $db_transaction->description=$transaction->tran_category.'/'.$transaction->tran_type.' - '.$transaction->memo;
        $db_transaction->save();
    }

    public static function processBankingTransaction($user_id, $portfolio, $transaction)
    {
        $bankingAccount = self::processBankingPortfolio($portfolio, $user_id);
        $db_transaction=null;
        if ($transaction->value<0) {
            $db_transaction = Expense::firstOrCreate(['users_id'=>$user_id,
                'banking_account_id'=>$bankingAccount->id,
                'quovo_transaction_id'=>$transaction->id,
            ]);
            if($db_transaction->expense_type_id==null){
                if (!property_exists($transaction, 'expense_category') || $transaction->expense_category==null) {
                    $expenseType = ExpenseType::firstOrCreate(['description'=>'Other']);
                } else {
                    $expenseType = ExpenseType::firstOrCreate(['description'=>$transaction->expense_category]);
                }
                $db_transaction->expense_types_id=$expenseType->id;
            }

            if($db_transaction->expense_subtype_id==null){
                $db_transaction->expense_subtype_id=ExpenseSubtype::firstOrCreate(['description'=>'Recurring Expense']);
            }
        } else {
            $incomeType = IncomeType::firstOrCreate(['description'=>$transaction->tran_category.'/'.$transaction->tran_type]);
            $db_transaction = Income::firstOrCreate(['users_id'=>$user_id,
                'banking_account_id'=>$bankingAccount->id,
                'quovo_transaction_id'=>$transaction->id]);
            $db_transaction->income_types_id=$incomeType->id;
        }

        $db_transaction->date=$transaction->date;
        $db_transaction->value=$transaction->value;
        $db_transaction->description=$transaction->tran_category.'/'.$transaction->tran_type.' - '.$transaction->memo;
        $db_transaction->save();
    }
}
