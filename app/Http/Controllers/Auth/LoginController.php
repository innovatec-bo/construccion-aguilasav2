<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    // public function login()
    // {
        // return view('auth.login');
    // }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials, $request->has('remember-me')))
        {
            $request->session()->regenerate();
            return redirect()
                ->intended(route('admin.home.index'))
                ->withSuccess('Iniciaste sesion exitosamente!');
        }

        return back()->withErrors([
            'email' => 'Tus credenciales parecen no estar registrados en el sistema.',
        ])->onlyInput('email');
    } 
    
    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('Sesion finalzada exitosamente!');;
    }    
}
