<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register() {
        return view('auth.register');
    }

    public function doRegister(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'email|required',
            'password' => 'min:6|required',
            'password_confirm' => 'same:password'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        $user = User::create($data);

        event(new Registered($user));

        Auth::attempt([
            'email' => $data['email'], 
            'password' => $data['password']
        ]);

        return redirect()->route('verification.notice');
    }

    public function login() {
        return view('auth.login');
    }

    public function doLogin(Request $request) {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        $remember = false;
        if($request->get('remember')) {
            $remember = true;
        }
        
        Auth::attempt([
            'email' => $request->email, 
            'password' => $request->password,
        ], $remember);

        return redirect('/');
    }

    public function forgotPassword() {
        return view('auth.forgot-password');
    }

    public function doForgotPassword(Request $request) {
        $request->validate(['email' => 'required|email']);
 
        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword($token) {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function doResetPassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return response()->json([], 200);
    }
}
