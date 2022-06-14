<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
}
