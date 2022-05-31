<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GostController extends Controller{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
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

    public function register_submit(Request $request)
    {
        $this->validate($request,[
            'KorisnickoIme' => 'required',
            'Lozinka' => 'required',
            'PonovljenaLozinka' => 'required',
            'ePosta' => 'required',
            'Ime' => 'required',
            'uslovi' => 'required',
        ],
        [
            'required' => 'Polje je obavezno'
        ]);

        $korisnik = new KorisnikModel();
        $korisnik->KorisnickoIme = $request->input('KorisnickoIme');
        return redirect()->route('profile');
    }
}