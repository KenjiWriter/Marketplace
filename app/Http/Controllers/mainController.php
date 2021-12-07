<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;

class mainController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function auth()
    {
        return view('home');
    }

    public function add()
    {
        return view('add');
    }
    public function show($id)
    {
        $id = $id;
        return view('showposts', compact('id'));
    }
    public function profile($id)
    {
        $id = $id;
        return view('profile', compact('id'));
    }
    public function delete(request $req)
    {
        dd($req->all());
    }
    public function product_page(request $req) 
    {
        $product = product::where('id',$req->product_id)->first();
        return view('product_page', compact('product'));
    }
}
