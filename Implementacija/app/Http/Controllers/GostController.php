<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GostController extends Controller{
    public function login()
    {
        return view('login');
    }

    public function login_submit(Request $request)
    {
        # code...
    }
}