<?php
/**
 * Created by PhpStorm.
 * User: miguelfruto
 * Date: 20/09/16
 * Time: 5:48 PM
 */

namespace App\Http\Controllers;


use App\Bank;
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

    static function processLoanPortfolio($portfolio){
        $loanType = LoanType::firstOrCreate(['description' => $portfolio->portfolio_type]);
        $bank = Bank::firstOrCreate(['name'=>$portfolio->brokerage_name]);
        if($bank->quovo_id==null){
            $bank->quovo_id=$portfolio->brokerage;
            $bank->save();
        }
        var_dump($portfolio);
        $loan = Loan::firstOrCreate(['users_id'=>Auth::user()->id,
            'number'=>$portfolio->portfolio_name,
            'loan_types_id'=>$loanType->id]);
        $loan->amount=$portfolio->value;
        $loan->individuals_id=0;
        $loan->loan_status_id=0;
        $loan->save();
        return true;
    }

    static function processInvestmentPortfolio($portfolio){
        return true;
    }

    static function processBankingPortfolio($portfolio){
        return true;
    }

    static function processInsurancePortfolio($portfolio){
        return true;
    }

    static function processPortfolio($portfolio){
        switch ($portfolio->portfolio_category){
            case 'Loan':
                echo 'processing: Loan';
                self::processLoanPortfolio($portfolio);
                break;
            case 'Investment':
                self::processInvestmentPortfolio($portfolio);
                break;
            case 'Banking':
                self::processBankingPortfolio($portfolio);
                break;
            case 'Insurance':
                self::processInsurancePortfolio($portfolio);
                break;
        }
    }

    static function clientSync(){
        $quovo_user_id=self::getQuovoUserId();
        $quovoResponse=self::getQuovo()->user()->portfolios($quovo_user_id);
        //$str=array();
        foreach($quovoResponse->portfolios as $portfolio) {
            if (!$portfolio->is_inactive) {

                if (!isset($str[$portfolio->portfolio_category])) {
                    $str[$portfolio->portfolio_category] = array();
                }
                if ($portfolio->portfolio_category != 'Unknown') {
                    self::processPortfolio($portfolio);
                }
                /*$str[$portfolio->portfolio_category][] = array('user_name' => $portfolio->username,
                    'brokerage_name' => $portfolio->brokerage_name,
                    'portfolio_name' => $portfolio->portfolio_name,
                    'nickname' => $portfolio->nickname,
                    'value' => $portfolio->value,
                );*/
            }
        }
        //return response()->json($str);
    }
}