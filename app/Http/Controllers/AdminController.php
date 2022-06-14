<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    public function index() {
        $users = User::whereNotNull('email_verified_at')->get();
        return view('admin.index', compact('users'));
    }

    public function confirmUser($user_id) {
        $user = User::findOrFail($user_id);
        $user->update(['verified' => 1]);
        return redirect()->back();
    }
}
