<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
//        $this->validateLogin($request);
        $rules = [$this->username() => 'email|required|string', 'password' => 'required|string'];
        $customMessages = $customMessages = [
            'required' => 'The :attribute field cannot be blank.'
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            foreach ($errors as $error) {
                trim($error);
            }
            return response()->json(['error' => true, 'message' => $errors], 422);
//            return array('error'=>true, 'message'=>$validator->errors()->all());
        }

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $user->generateToken();

            return response()->json(
                [
                    'error' => false,
                    'message' => ['User logged in successfully'],
                    'user' => $user
                ]);
        }

//        return $this->sendFailedLoginResponse($request);
    }

    /*   protected function authenticated(Request $request, $user)
       {
           return response()->json(['error' => false, 'message' => 'User logged in successfully', 'user' => $user]);

       }*/

    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();
//        $user = $this->guard()->user();
//        $user = Auth::guard()->user();
        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json(['error' => 'false', 'message' => ['User logged out.']], 200);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }
}
