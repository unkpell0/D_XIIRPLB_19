<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    public function userLogin(Request $request)
    {
        // Validate and attempt login for users
        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            return redirect()->intended('/user/dashboard');
        }
        return back()->withErrors('Invalid login credentials');
    }

    public function adminLogin(Request $request)
    {
        // Validate and attempt login for admins
        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            return redirect()->intended('/admin/dashboard');
        }
        return back()->withErrors('Invalid login credentials');
    }
}
