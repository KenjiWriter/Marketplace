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
    public function product_page(request $req) 
    {
        $product = product::where('id',$req->product_id)->first();
        return view('user.product_page', compact('product'));
    }
}
