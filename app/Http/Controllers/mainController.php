<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\product;
use Auth;
use App\Models\user;
use App\Models\message;

class mainController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function auth()
    {
        return view('user.home');
    }

    //Facebook login
    public function redirectToFacebook()
    {
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

    public function add()
    {
        return view('user.add');
    }

    public function show($id)
    {
        $id = $id;
        return view('user.showposts', compact('id'));
    }

    public function profile($id)
    {
        $id = $id;
        return view('user.profile', compact('id'));
    }

    public function product_page(request $req) 
    {
        $product = product::where('id',$req->product_id)->first();
        return view('user.product_page', compact('product'));
    }

    public function balance()
    {
        return view('user.balance');
    }

    public function chat($roomId)
    {
        return view('user.chat')->with('roomId', $roomId);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function post_delete(Request $req)
    {
        product::where('id',$req->id)->delete();
        return back();
    }

    public function post_edit_get(Request $req)
    {
        $product = product::where('id', $req->id)->first();
        if(auth()->user()->id != $product->user_id) {
            return view('/');
        }
        return view('user.edit_post', compact('product'));
    }

    public function post_edit_post(Request $req)
    {
        $product = product::where('id', $req->id)->first();
        if(auth()->user()->id != $product->user_id) {
            return view('/');
        }
        $product->name = $req->title;
        if(isset($req->first_owner)) {
            $product->First_owner = 1;
        } else {
            $product->First_owner = 0;
        }
        if($req->category == 0) {
            $product->category = 4;
        } else {
            $product->category = $req->category;
        }
        $product->price = $req->price;
        if(isset($req->active)) {
            $product->Active = 0;
        } else {
            $product->Active = 1;
        }
        $product->save();
        return redirect(route('profile', auth()->user()->id));
    }

    public function balance_add(Request $req)
    {
        $deposit = $req->amount;
        if(!isset($deposit) or empty($deposit)) {
            return back()->with('message', 'Deposit amount cannot be empty!');
        }
        if($deposit < 5) {
            return back()->with('message', 'Deposit cannot be lower then 5$!');
        }

        //Here will be paywall gate

        $user = user::find(auth()->user()->id);
        $user->balance += $deposit;
        $user->save();
        return back()->with('success', 'deposit successful added to account!');

    }

    public function promote(Request $req)
    {
        $product = product::where('id', $req->id)->first();
        if(auth()->user()->id == $product->user_id) {
            if(now()->lt($product->promote_to) == true) {
                $promoting_to = $product->promote_to;
            } else {
                $promoting_to = '';
            }
            return view('user.promote')->with('promoting_to', $promoting_to)->with('id', $req->id);
        } else {
            return back();
        }
    }

    public function promote_add(Request $req)
    {
        $product = product::find($req->id);
        $user = auth()->user();
        $user = user::where('id',$user->id)->first();
        if($user->id == $product->user_id) {
            switch ($req->days) {
                case 3:
                    if($user->balance >= 5) {
                        $days = 3;
                        $balance = 5;
                    } else {
                        return back()->with('balance', 'not enought balance <a>.</a>');
                    }
                    break;
                case 14:
                    if($user->balance >= 15) {
                        $days = 14;
                        $balance = 15;
                    } else {
                        return back()->with('balance', 'not enought balance <a>.</a>');
                    }
                    break;
                case 30:
                    if($user->balance >= 30) {
                        $days = 30;
                        $balance = 30;
                    } else {
                        return back()->with('balance', 'not enought balance <a>.</a>');
                    }
                    break;
                default:
                    return back()->with('message', 'Invalid days');
                    break;
            }
            if(now()->lt($product->promote_to) == true and $product->promote_to != NULL) {
                $product->promote_to = $product->promote_to->addDays($days);
            } else {
                $product->promote_to = now()->addDays($days);
            }
            $user->balance -= $balance;
            $product->save();
            $user->save();
            return back()->with('success', 'Promoting successfully bought');
        } else {
            return back();
        }
    }

    public function messages()
    {
        $buying = message::where('buyer', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        foreach($buying as $message) {
            if(isset($collectionBuying)) {
                foreach($collectionBuying as $i) {
                    if($message->roomId == $i["roomId"]) {
                        continue;
                    } else {
                        $collectionBuying[] = ['seller' => $message->seller, 'roomId' => $message->roomId, 'product' => $message->product_id, 'time' => $message->created_at];
                    }
                }
            } else {
                $collectionBuying[] = ['seller' => $message->seller, 'roomId' => $message->roomId, 'product' => $message->product_id, 'time' => $message->created_at];
            }
        }

        $selling = message::where('seller', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        foreach($selling as $message) {
            if(isset($collectionSelling)) { 
                foreach($collectionSelling as $i) {
                    if($message->roomId == $i["roomId"]) {
                        continue;
                    } else {
                        $collectionSelling[] = ['buyer' => $message->buyer, 'roomId' => $message->roomId, 'product' => $message->product_id, 'time' => $message->created_at];
                    }
                }
            } else {
                $collectionSelling[] = ['buyer' => $message->buyer, 'roomId' => $message->roomId, 'product' => $message->product_id, 'time' => $message->created_at];
            }
        }

        if(empty($collectionBuying)) {
            $collectionBuying = [];
        }
        if(empty($collectionSelling)) {
            $collectionSelling = [];
        }

        return view('user.messages', [
            'collectionBuying' => $collectionBuying,
            'collectionSelling' => $collectionSelling,
        ]);
    }
}
