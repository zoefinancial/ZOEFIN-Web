<?php

namespace App\Http\Controllers\Auth;

use App\QuovoUser;
use App\User;
use App\Individual;
use Wela\Quovo;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
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
            'password' => 'required|min:8|confirmed',
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

        $data['individual']['gender'] = null;
        $data['individual']['marital_status_id'] = null;
        $data['individual']['date_birth'] = null;

        if (($onBoarding = Cookie::get('on_boarding')) !== null) {
            $data['individual']['gender'] = $onBoarding['gender'];
            $data['individual']['marital_status_id'] = $onBoarding['marital_status_id'];
            $data['individual']['date_birth'] = $onBoarding['date_birth'];
            Cookie::queue(Cookie::forget('on_boarding'));
        }

        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $user['individual'] = Individual::create([
            'users_id'          => $user['attributes']['id'],
            'name'              => $data['individual']['name'],
            'lastname'          => $data['individual']['lastname'],
            'gender'            => $data['individual']['gender'],
            'marital_status_id' => $data['individual']['marital_status_id'],
            'date_birth'        => $data['individual']['date_birth'],
            'principal'         => 1
        ]);

        if (!$user['individual']) {
            throw new \Exception('Error in saving user.');
        }

        try{
            $userQuovo = $this->createUserQuovo([
                "email" => $data['email'],
                "id"    => $user['attributes']['id'],
                "name"  => $data['individual']['name'] . ' ' . $data['individual']['lastname'],
                "phone" => null,
                "username" => $data['email'],
                "value" => null
            ]);
        }catch(\Exception $e){
            throw new \Exception('Error creating user on quovo.');
        }

        QuovoUser::create([
            'user_id' => $user['attributes']['id'],
            'quovo_user_id' => $userQuovo->user->id
        ]);

        return $user;
    }

    /**
     * @param $parameters
     * @return Quovo User
     */
    private function createUserQuovo($parameters)
    {
        $quovo = new Quovo(['user'=>env('QUOVO_USER', ''),'password'=>env('QUOVO_PASSWORD', '')]);

        return $quovo->user()->create([
                                "email" => $parameters['email'],
                                "id"    => $parameters['id'],
                                "name"  => $parameters['name'],
                                "phone" => null,
                                "username" => $parameters['email'],
                                "value" => null
                            ]);
    }
}
