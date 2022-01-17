<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use Laravel\Socialite\Facades\Socialite;
use Sentinel;
use Reminder;
use Mail;
use Auth;

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

    //Password Reset
    public function passwordReset()
    {
        if(auth()->user()) {
            return redirect()->route('index');
        } else {
            return view('user.forgot_password');
        }
    }

    public function passwordReset_send(Request $req)
    {
        if(auth()->user()) {
            return redirect()->route('index');
        } else {
            $validated = $req->validate([
                'email' => 'required|email',
            ]);

            $user = user::where('email', $req->email)->first();

            if(!empty($user)) {
                $user = sentinel::findById($user->id);
                $reminder = reminder::exists($user) ? : reminder::create($user);
                $this->sendEmail($user, $reminder->code);
                return redirect()->back()->with('message', "Email was sended! Check your email");
            } else {
                return back()->with('error', "No user with this email was found!");
            }
        }
    }

    public function passwordReset_verify($email, $code, request $req)
    {
        if(auth()->user()) {
            return redirect()->route('index');
        } else {
            $user = user::where('email', $email)->first();

            if(!empty($user)) {
                $user = sentinel::findById($user->id);
                $reminder = reminder::exists($user);
                if($reminder) {
                    if($code == $req->code) {
                        return view('user.resetPassword')->with(['user'=>$user, 'code'=>$code]);
                    } else {
                        return redirect()->route('index');
                    }
                } else {
                    return back()->with('error', "Link expired! try again!");
                }
            } else {
                return back()->with('error', "No user with this email was found!");
            }

        }
    }

    public function passwordReset_change($email, $code, Request $req)
    {
        $this->validate($req, [
            'password' => 'required|min:6|max:50|confirmed'
        ]);

        $user = user::where('email', $email)->first();
        if(!empty($user)) {
            $user = sentinel::findById($user->id);
            $reminder = reminder::exists($user);
    
            if($reminder) {
                if($code == $req->code) {
                    reminder::complete($user, $code, $req->password);
                    return redirect()->route('auth')->with('message', 'Password successfuly changed!');
                } else {
                    return redirect()->route('index');
                }
            } else {
                return back()->with('error', "Link expired! try again!");
            }
        } else {
            return back()->with('error', "No user with this email was found!");
        }
    }

    public function sendEmail($user, $code) 
    {
        Mail::send(
            'email.reset',
            ['user' => $user, 'code' => $code],
            function($message) use ($user) {
                $message->to($user->email);
                $message->subject("$user->name, reset your password");
            }
        );
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
