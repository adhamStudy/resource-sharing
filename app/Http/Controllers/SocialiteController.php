<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class SocialiteController extends Controller
{
    
public function login()
{
    return Socialite::driver('github')->redirect();
}

public function redirect()
{
    $socialiteUser= Socialite::driver('github')->user();

    // dd($socialiteUser);
    // Check if the user already exists in the databa
    if($socialiteUser->getName()==null){
        return redirect()->route('login')->with('error','can not login with github missing name');
    }
    $user=User::UpdateOrCreate(
        [
            'provider_id'=>$socialiteUser->getId(),
            'name'=>$socialiteUser->getName(),
            'email'=>$socialiteUser->getEmail(),
        ],
        
    );
    

    Auth::login($user,true);

    return redirect()->route('home')->with('success','Login successful');
}
}