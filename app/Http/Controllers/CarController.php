<?php

namespace App\Http\Controllers;

use App\Car;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;



class CarController extends Controller
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
            'current_value' => 'required|max:99999999999|numeric',
        ]);
        try{
            $car = new Car($request->all());
            $car->users_id=Auth::user()->id;
            $car->save();
            return ['Information'=>'Car created'];
        }catch(\Exception $e){
            return ['Error'=>$e->getMessage()];
        }
    }

    public function delete(Request $request)
    {
        if(Car::where('id',base64_decode($request->get('delete_car_id')))->delete()==1){
            return ['Information'=>'Car deleted'];
        }else{
            return ['Error'=>'Oops! Something went wrong'];
        }

    }
}