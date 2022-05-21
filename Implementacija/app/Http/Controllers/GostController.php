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
        $this->validate($request,[
            'KorisnickoIme' => 'required',
            'Sifra' => 'required'
        ],
        [
            'required' => 'Polje :attribute je obavezno.'
        ]);

        if(!auth()->attempt($request->only('KorisnickoIme', 'Sifra'))){
            return back()->with('status', 'Pogresni podaci.');
        }
            return redirect()->route('index');
    }
}