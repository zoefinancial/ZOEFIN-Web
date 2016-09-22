<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Individual;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'individual.name.required' => 'We need to know your first name.',
            'individual.lastname.required' => 'We need to know your last name.',
            'individual.name.max' => 'The first name may not be greater than :max characters.',
            'individual.lastname.max' => 'The last name may not be greater than :max characters.',
        ];
        return Validator::make($data, [
            'individual.name' => 'required|max:50',
            'individual.lastname' => 'required|max:50',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:1|confirmed',
            // min 8
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        //$profileData = Input::only('individual');
        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $user['individual'] = Individual::create([
            'users_id' => $user['attributes']['id'],
            'name' => $data['individual']['name'],
            'lastname' => $data['individual']['lastname'],
            'principal' => 1
        ]);
        return $user;
    }
}
