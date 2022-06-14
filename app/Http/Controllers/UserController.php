<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        return view('user.index');
    }

    public function update(Request $request) {
        $user = User::find(auth()->id());
        $user->update([
            'name' => $request->name
        ]);
        return redirect()->back()->with('successUpdate', true);
    }

    public function changePassword(Request $request) {
        $user = User::find(auth()->id());
        $request->validate([
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ]);
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return redirect()->back()->with('successChangePassword', true);
    }
}
