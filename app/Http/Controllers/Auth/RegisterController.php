<?php

namespace Webdev\Http\Controllers\Auth;

use Webdev\Models\User;
use Webdev\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/cabinet';
    private $keepLoginTemporary = '';
    public function redirectTo()
    {
        //Save Login into the Session if Registration is success
        session(['login' => $this->keepLoginTemporary]);
        //Go to the Email Notification Page after Registration
        return route('after_register');
    }
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'login' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:wdusers',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Webdev\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        //Set role Guest with role_id 3 into the Pivot table. By default when a User is registered.
        $user->roles()->attach(3);//$roleId
        return $user;
    }
    /**
     *  Override Method from the Trait
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        //We remove it to prevent LogIn user
        //$this->guard()->login($user);
       
        //Save login into the property for using in the Session
        $this->keepLoginTemporary = $request->input('login');

        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }
}
