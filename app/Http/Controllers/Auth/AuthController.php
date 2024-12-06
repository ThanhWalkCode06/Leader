<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    //
    public function showLogin(){
        // dd($_COOKIE['name']);
        if( isset($_COOKIE['name']) && isset($_COOKIE['remember_token']) ){
            return redirect()->route('nhanviens.index');
        }
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

                setcookie('remember_token', $request->remember_token, time() + (86400 * 30), "/"); // 30 ngày
                setcookie('name', $request->name, time() + (86400 * 30), "/");
                };
                $userName = Auth::user()->name;
                session(['userName' => $userName]);
                return redirect()->intended('nhanviens');
            }
        return redirect()->back()->withErrors([
            'error' => 'Thông tin người dùng không đúng'
        ]);
    }

    public function showRegister(){
        return view('auth.register');
    }


    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string',
        ]);
        $user = User::query()->create($data);
        Auth::login($user);
        return redirect()->intended('/');
    }

    public function logout(Request $request){
        Auth::logout();
        Cookie::queue(Cookie::forget('remember_token'));
        Cookie::queue(Cookie::forget('name'));
        $request->session()->forget('userName');
        return view('auth.logout');
    }

    public function showReset(){
        return view('auth.reset');
    }

    public function storeReset(Request $request){
        $user = User::query()->where('email',$request->email)->first();
        $email = $request->email;
        $request->validate([
            'email' =>'required|email|exists:users,email',
        ],['email.exists' => 'Email not exists']);

    // Tạo token
    $token = Str::random(60);
    // Lưu token vào bảng password_resets
    DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $email],
        ['token' => $token, 'created_at' => now()]
    );
    Mail::to($email)->send(new ResetPasswordMail($token));

    return redirect()->route('login')->with(['success' => 'you can check your mail let access link!']);
}

    public function showResetPass(string $token){

        return view('auth.reset_pass',compact('token'));
    }

    public function storeResetPass(Request $request, $token){
        $user = DB::table('password_reset_tokens')->where('token',$token)->first();
        $email = $user->email;
        $request->validate([
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        $pass = bcrypt($request->password);
        DB::table('users')->where('email', $email)->update(['password' => $pass]);

    return redirect()->route('login')->with('success','You could login');
    }

    public function editPass(){

        return view('auth.change');
    }

    public function UpdatePass(Request $request){
        $user = User::query()->where('name',session('userName'))->first();
        $request->validate([
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        $pass = bcrypt($request->password);
        // dd($pass, $user->id);
        DB::table('users')->where('id', $user->id)->update(['password' => $pass]);

    return redirect()->route('login')->with('success',', you did change password. Please login again');
    }
}


