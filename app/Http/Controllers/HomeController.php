<?php

namespace App\Http\Controllers;

use App\Home;
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

        return Home::create($request->all());
//        Home::create($data);

    }
}
