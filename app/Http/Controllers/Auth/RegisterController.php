<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

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
//    protected $redirectTo = '/home';

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
     * @param  array $data
     * @return array
     */
    /*    protected function validator(array $data)
        {
            $customMessages = [
                'required' => 'The :attribute field cannot be blank.'
            ];

            $validator = Validator::make($data, [
                'country' => 'required',
                'enterprise' => 'required',
                'gender' => 'nullable',
                'lname' => 'required',
                'fname' => 'required',
                'password' => 'required',
                'email' => 'required|unique:users'
            ], $customMessages);


            if ($validator->fails()) {
                return json_encode(['error' => true]);
    //            return response()->json(['error' => true], 422);
            }
        }*/

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'lname' => $data['lname'],
            'fname' => $data['fname'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'enterprise' => $data['enterprise'],
            'country' => $data['country'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function registered(Request $request, $user)
    {
        $user->generateToken();
        return response()->json(['error' => false, 'message' => ['User registered successfully'], 'user' => $user->toArray()]);
    }
}
