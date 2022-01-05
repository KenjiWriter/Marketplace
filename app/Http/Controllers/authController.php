<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use Auth;
use Laravel\Socialite\Facades\Socialite;

class authController extends Controller
{
    public function auth()
    {
        return view('user.home');
    }

    //Facebook login
    public function redirectToFacebook()
    {
        if(auth()->user()) {
            return redirect()->route('index');
        }
        return Socialite::driver('facebook')->redirect();
    }

    //Facebook Callback
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->stateless()->user();
        $this->_registerOrLoginUser($user);
        return redirect()->route('index');
    }

    //Google login
    public function redirectToGoogle()
    {
        if(auth()->user()) {
            return redirect()->route('index');
        }
        return Socialite::driver('google')->redirect();
    }

    //Google Callback
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        $this->_registerOrLoginUser($user);
        return redirect()->route('index');
    }

    protected function _registerOrLoginUser($data)
    {
        $user = User::where('email', $data->email)->first();
        if(!$user) {
            $user = new User();
            $user->provider_id = $data->id;
            $user->name = $data->name;
            $user->email = $data->email;
            $user->avatar = $data->avatar;
            $user->save();
        }
        Auth::login($user); 
    }

    //Email verification

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
