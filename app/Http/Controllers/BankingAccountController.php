<?php

namespace App\Http\Controllers;

use App\BankingAccount;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankingAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store banking accounts
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'banks_id'          => 'required',
            'account_types_id'  => 'required',
            'account_status_id' => 'required',
            'number'            => 'required|max:100',
            'current_balance'   => 'required|max:99999999999|numeric',
        ]);
        try{
            $bankingAccount = new BankingAccount($request->all());
            $bankingAccount->users_id = Auth::user()->id;
            $bankingAccount->save();
            return ['Information'=>'Bankig account created'];
        }catch(\Exception $e){
            return ['Error'=>'Oops! Something went wrong'];
        }
    }

    public function delete(Request $request)
    {
        if(BankingAccount::where('id',base64_decode($request->get('delete_banking_account_id')))->delete()==1){
            return ['Information'=>'Banking Account deleted'];
        }else{
            return ['Error'=>'Oops! Something went wrong'];
        }
    }

    static public function getBankingAccount($user_id)
    {
        return BankingAccount::where('users_id',$user_id)->get();
    }
}
