<?php

namespace App\Http\Controllers;

use App\Loan;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|max:99999999999|numeric',
            'interest_rate'=>'required',
            'loan_types_id'=>'required'
        ]);
        try {
            $loan = new Loan($request->all());
            $loan->amount        = $loan->amount*-1;
            $loan->users_id      = Auth::user()->id;
            $loan->interest_rate = $request->get('interest_rate');
            $loan->loan_types_id = $request->get('loan_types_id');
            $loan->save();
            return ['Information'=>'Loan created'];
        } catch (\Exception $e) {
            return ['Error'=>$e->getMessage()];
        }
    }

    public function delete(Request $request)
    {
        if (Loan::where('id', base64_decode($request->get('delete_loan_id')))->delete()==1) {
            return ['Information'=>'Loan deleted'];
        } else {
            return ['Error'=>'Oops! Something went wrong'];
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id'=>'required',
            'loan_types_id'=>'required',
            'amount' => 'required|max:99999999999|numeric',
            'interest_rate'=>'required',
        ]);

        try {
            Loan::where('id', base64_decode($request->get('id')))->update(
                [
                    'amount'        => $request->get('amount')*-1,
                    'comments'      => $request->get('comments'),
                    'details'       => $request->get('details'),
                    'interest_rate' => $request->get('interest_rate'),
                ]
            );
            return ['Information'=>'Loan updated'];
        } catch (\Exception $e) {
            return ['Error'=>'Oops! Something went wrong'];
            //return ['Error'=>$e->getMessage()];
        }
    }
}
