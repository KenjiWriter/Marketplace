<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use Auth;

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

    public function product_page(request $req) 
    {
        $product = product::where('id',$req->product_id)->first();
        return view('user.product_page', compact('product'));
    }
}
