<?php

namespace App\Http\Controllers;

use App\BankingAccount;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;

class BankingAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store banking accounts
     *
     * @return array
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'banks_id'          => 'required',
            'account_types_id'  => 'required',
            'account_status_id' => 'required',
            'name'            => 'required|max:4',
            'current_balance'   => 'required|max:99999999999|numeric',
        ]);
        try {
            $bankingAccount = new BankingAccount($request->all());
            $bankingAccount->users_id = Auth::user()->id;
            $bankingAccount->save();
            return ['Information'=>'Banking account created'];
        } catch (\Exception $e) {
            //return ['Error'=>$e->getMessage()];
            return ['Error'=>'Oops! Something went wrong'];
        }
    }

    public function delete(Request $request)
    {
        if (BankingAccount::where('id', base64_decode($request->get('delete_banking_account_id')))->delete()==1) {
            return ['Information'=>'Banking Account deleted'];
        } else {
            return ['Error'=>'Oops! Something went wrong'];
        }
    }

    public static function getBankingAccount($user_id)
    {
        return BankingAccount::where('users_id', $user_id)->get();
    }
}
