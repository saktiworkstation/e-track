<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login.index', [
            'title' => 'Login',
            'active' => 'login'
        ]);
    }

    public function register()
    {
        return view('auth.register.index', [
            'title' => 'Register',
            'active' => 'register'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max: 255',
            'username' => 'required|max: 255|min:3|unique:users',
            'email' => 'required|unique:users|email:dns',
            'password' => 'required|max: 255|min:5'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect('/login')->with('success', 'Register successfully! Please login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with('loginError', 'Login failed!');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/');
    }

    public function rolling($id){
        $user = User::where('id', $id)->firstOrFail();
        $newData = [];
        if($user->is_admin == 0){
            $oldRole = $user->is_admin;
            $newRole = $oldRole + 1;
            $newData['is_admin'] = $newRole;
            User::where('id', $id)->update($newData);
            return redirect('/dashboard')->with('success', 'User Role changed successfully!');
        }elseif($user->is_admin == 1){
            $oldRole = $user->is_admin;
            $newRole = $oldRole - 1;
            $newData['is_admin'] = $newRole;
            User::where('id', $id)->update($newData);
            return redirect('/dashboard')->with('success', 'User Role changed successfully!');
        }else {
            return redirect('/dashboard')->with('error', 'Role User is not registered, please delete this user!');
        }
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect('/dashboard')->with('success', 'User has been deleted!');
    }

    public function edit(Request $request, $id){
        $rules = [
            'name' => 'required|max:255',
        ];

        $validatedData = $request->validate($rules);

        User::where('id', $id)->update($validatedData);
        return redirect('/dashboard')->with('success', 'User Data changed successfully!');
    }
}
