<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
