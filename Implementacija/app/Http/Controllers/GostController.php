<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KorisnikModel;

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
        $korisnik->KorisnickoIme = $request->KorisnickoIme;
        $sifra = $request->Lozinka;
        $ponSifra = $request->PonovljenaLozinka;
        if($sifra == $ponSifra){
            $korisnik->sifra = $sifra;
        } else {
            return back()->with('status', 'Sifre se ne poklapaju.');
        }
        $korisnik->Ime = $request->Ime;
        $korisnik->email = $request->ePosta;
        $korisnik->vrsta = 0;
        $korisnik->opis = "Ja nisam admin";
        $korisnik->save();
        //return redirect()->route('profile', ['id' => $korisnik->idKorisnik]);
        return redirect()->route('index');
    }
}