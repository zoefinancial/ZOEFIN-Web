<?php

namespace App\Http\Controllers;

use App\Home;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;


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
            $home = new Home($request->all());
            $home->users_id=Auth::user()->id;
            $home->save();
            return ['Information'=>'Home created'];
        }catch(\Exception $e){
            return ['Error'=>'Oops! Something went wrong'];
        }
    }

    public function update(Request $request){
        $this->validate($request, [
            'id'=>'required',
            'home_types_id' => 'required',
            'address'       => 'required|max:100',
            'city'          => 'required|max:60',
            'state'         => 'required|max:60',
            'zip'           => 'required|max:999999|numeric',
            'current_value' => 'required|max:99999999999|numeric',
        ]);

        try{
            Home::where('id',base64_decode($request->get('id')))->update([
            'home_types_id'=>$request->get('home_types_id'),
            'address'=>$request->get('address'),
            'city'=>$request->get('city'),
            'state'=>$request->get('state'),
            'zip'=>$request->get('zip'),
            'current_value'=>$request->get('current_value')]
            );
            return ['Information'=>'Home updated'];
        }catch(\Exception $e){
            return ['Error'=>'Oops! Something went wrong'];
            //return ['Error'=>$e->getMessage()];
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

    static public function getHome($user_id)
    {
        return Home::where('users_id',$user_id)->get();
    }
}
