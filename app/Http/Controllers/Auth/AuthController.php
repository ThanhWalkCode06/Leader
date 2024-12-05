<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function showLogin(){
        return view('auth.login');
    }

    public function login(Request $request, User $user){
        // dd($request->remember_token);
        $user = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);
        if(Auth::attempt($user)){
            if($request->remember_token){
                $currentUser = Auth::user();
                // Gán token vào user
                $currentUser->remember_token = $request->remember_token;
                // Lưu lại vào database
                $currentUser->save();
                };
                setcookie('remember_token', $request->remember_token, time() + (86400 * 30), "/"); // 30 ngày
                setcookie('name', $request->name, time() + (86400 * 30), "/");
            }
            $userName = Auth::user()->name;

            session(['userName' => $userName]);
            return redirect()->intended('nhanviens');

        return redirect()->back()->withErrors([
            'error' => 'Thông tin người dùng không đúng'
        ]);
    }

    public function showRegister(){
        return view('auth.register');
    }


    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'email' => 'required|string',
        ]);
        $user = User::query()->create($data);
        Auth::login($user);
        return redirect()->intended('/');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->forget('userName');
        return view('auth.logout');
    }

}


