<?php
/**
 * Created by PhpStorm.
 * User: miguelfruto
 * Date: 20/09/16
 * Time: 5:48 PM
 */

namespace App\Http\Controllers;


use App\AccountType;
use App\Bank;
use App\BankingAccount;
use App\Investment;
use App\InvestmentCompany;
use App\InvestmentVehicle;
use App\Loan;
use App\LoanType;
use App\QuovoUser;
use Illuminate\Support\Facades\Auth;
use Wela\Quovo;

class QuovoClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private static $quovo;

    static function getQuovo(){
        if(self::$quovo==null){
            self::$quovo = new Quovo(['user'=>env('QUOVO_USER', ''),'password'=>env('QUOVO_PASSWORD', '')]);
        }
        return self::$quovo;
    }

    static function getQuovoUserId(){
        $quovoUsers =QuovoUser::where('user_id',Auth::user()->id)
            ->take(1)
            ->get();

        if(count($quovoUsers)==0) {
            $users=self::getQuovo()->user()->all();
            $found=null;
            foreach($users->users as $user){
                if($user->email==Auth::user()->email){
                    $found=$user->id;
                    break;
                }
            }
            if($found==null){
                $parameters=array('username'=>Auth::user()->email,'name'=>Auth::user()->name,'email'=>Auth::user()->email,'phone'=>null);
                $user=self::getQuovo()->user()->create($parameters);
                $found=$user->id;
            }
            $quovoUser= new QuovoUser(array('user_id'=>Auth::user()->id,'quovo_user_id'=>$found));
            $quovoUser->save();
            $quovoUserid=$found;
        }else{
            $quovoUserid=$quovoUsers[0]->quovo_user_id;
        }
        return $quovoUserid;
    }

    static function  getIFrameToken(){
        try{
            $quovo_user_id=self::getQuovoUserId();
            $token =  self::getQuovo()->iframe()->getIframeToken($quovo_user_id);
            return ['user_id'=>$quovo_user_id,'token'=>$token->iframe_token->token];
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    static function getBank($name,$quovo_id){
        $bank = Bank::firstOrCreate(['name'=>$name]);
        if($bank->quovo_id==null){
            $bank->quovo_id=$quovo_id;
            $bank->save();
        }
        return $bank;
    }

    static function getAccountType($description){
        $accountType = AccountType::firstOrCreate(['description'=>$description]);
        return $accountType;
    }

    static function processLoanPortfolio($portfolio){
        $loanType = LoanType::firstOrCreate(['description' => $portfolio->portfolio_type]);
        $bank=self::getBank($portfolio->brokerage_name,$portfolio->brokerage);
        $loan = Loan::firstOrCreate(['users_id'=>Auth::user()->id,
            'number'=>$portfolio->portfolio_name,
            'loan_types_id'=>$loanType->id,
            'bank_id'=>$bank->id,
            ]);
        $loan->amount=$portfolio->value;
        $loan->individuals_id=0;
        $loan->loan_status_id=0;
        $loan->comments='Synchronized with Quovo';
        $loan->save();
        return true;
    }

    static function processInvestmentPortfolio($portfolio){
        exit(response()->json($portfolio));

        $vehicle = InvestmentVehicle::firstOrCreate('description', $portfolio->portfolio_type);
        $company = InvestmentCompany::firstOrCreate();
        //$investment = Investment::firsOrCreate([]);
        //return $portfolio;
    }

    static function processBankingPortfolio($portfolio){
        $bank=self::getBank($portfolio->brokerage_name,$portfolio->brokerage);
        $accountType=self::getAccountType($portfolio->portfolio_type);
        $bankingAccount = BankingAccount::firstOrCreate(['users_id'=>Auth::user()->id,
            'banks_id'=>$bank->id,
            'account_types_id'=>$accountType->id,
            'number'=>$portfolio->portfolio_name,
            ]);
        $bankingAccount->current_balance=$portfolio->value;
        $bankingAccount->account_status_id=1;
        $bankingAccount->save();
        return true;
    }

    static function processInsurancePortfolio($portfolio){
        return true;
    }

    static function processPortfolio($portfolio){
        switch ($portfolio->portfolio_category){
            case 'Loan':
                self::processLoanPortfolio($portfolio);
                break;
            case 'Investment':
                self::processInvestmentPortfolio($portfolio);
                break;
            case 'Banking':
                if($portfolio->portfolio_type=='Credit Card'){
                    self::processLoanPortfolio($portfolio);
                }
                else{
                    self::processBankingPortfolio($portfolio);
                }
                break;
            case 'Insurance':
                self::processInsurancePortfolio($portfolio);
                break;
        }
    }

    static function clientSync(){
        try{
            $quovo_user_id=self::getQuovoUserId();
            $quovoResponse=self::getQuovo()->user()->portfolios($quovo_user_id);
           // return response()->json($quovoResponse);
            foreach($quovoResponse->portfolios as $portfolio) {
                if (!$portfolio->is_inactive) {
                    if ($portfolio->portfolio_category != 'Unknown') {
                        self::processPortfolio($portfolio);
                    }
                }
            }
            return response()->json(['Information'=>'Synchronizing process succeed']);
        }catch(\Exception $e){
            return response()->json(['Information'=>'Synchronizing process failed']);
        }

    }
}