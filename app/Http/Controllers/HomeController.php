<?php

namespace App\Http\Controllers;

use App\Home;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class HomeController extends Controller
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
            'home_types_id' => 'required',
            'address'       => 'required|max:100',
            'city'          => 'required|max:60',
            'state'         => 'required|max:60',
            'zip'           => 'required|max:999999|numeric',
            'current_value' => 'required|max:99999999999|numeric',
        ]);
        try{
            Home::create($request->all())->users_id=Auth::user()->id;
            return ['Information'=>'Home created'];
        }catch(\Exception $e){
            return ['Error'=>'Oops! Something went wrong'];
        }
    }

    public function delete(Request $request)
    {
        if(Home::where('id',base64_decode($request->get('delete_home_id')))->delete()==1){
            return ['Information'=>'Home deleted'];
        }else{
            return ['Error'=>'Oops! Something went wrong'];
        }

    }
}
