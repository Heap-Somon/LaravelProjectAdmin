<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Authentication extends Controller
{
    public function register(){
        return view('Authentication.register');
    }
    public function submitRegister(Request $request){
        $validate = Validator::make($request->all(),
        [
            'name' => 'required|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:20',
            'profile' => [
                'required',
                'mimes:jpg,jpeg,png',
                'max:1000'
            ]
        ]) ;

        if($validate->fails()){
            return redirect()->back()->withErrors($validate);
        }

        $image = $request->file('profile');
        $filename = time()."-".$image -> getClientOriginalName();
        $path = './image';

        if(!file_exists($path)){
            mkdir('./image',0777,1);
        }

        $image->move($path,$filename);

        $result = DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => Hash::make($request -> password),
            'profile' => $filename
        ]);

        if($result){
            return redirect()->route('login')->with('success','User register success');
        }
    }

    public function login(){
        return view('Authentication.login');
    }
    public function submitLogin(Request $request){
        $username = $request -> name_email;
        $password = $request -> password;
        if(Auth::attempt(['name' => $username,'password' => $password])){
            return redirect('/')->with('success','Login successful');
        } 
        else if(Auth::attempt(['email' => $username,'password' => $password])){
            return redirect('/')->with('success','Login successful');
        }
        else{
            return redirect()->back()->with('error','Login failed');
        }
    }

    public function logout(){
        return view('dashboard.logout');
    }
    public function submitLogout(Request $request){
        
        Auth::logout();

        return redirect()->route('login')->with('success','Logout Successful');
    }
}
