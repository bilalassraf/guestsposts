<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;



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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
        return view('authentication.login');
    }
    public function login(Request $request)
    {

        $usernamefield = Filter_var($request->email,FILTER_VALIDATE_EMAIL) ? 'email': 'name';
        if(auth()->attempt([$usernamefield => $request->email, 'password' => $request->password]))
        {
            return redirect()->route('dashboard');
        }else{
        return back()->with('error','Credentails Does Not Match');
        }
    }
    public function logout ()
    {
        auth()->logout();
        return view('authentication.login');
    }


}
