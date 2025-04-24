<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class UserAccountController extends Controller
{
    public function create(){
        return inertia('UserAccount/Create');
    }

    public function store(Request $request){

        $user =User::make($request->validate([
            'name'=>'string|required',
            'email'=>'email| required |unique:users',
           'phone' => [
            'required',
            'regex:/^(05\d{8}|5\d{8}|009665\d{8})$/',
            'unique:users,phone'
],
            'password'=>'required|min:8|confirmed'
        ]));
        $user->save();
        Auth::login($user);

        return redirect()->route('home')->with('seccess','user created successfully');
    }
}
