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
            'Sifra' => 'required',
            'PonovljenaSifra' => 'required',
            'ePosta' => 'required|regex:/^\w+@[a-z]+\.[a-z]{2,3}$/',
            'Ime' => 'required',
            'uslovi' => 'required',
        ],
        [
            'required' => 'Polje je obavezno',
            'regex' => 'mejl nije ispravan'
        ]);

        $korisnik = new KorisnikModel();
        $korisnik->KorisnickoIme = $request->KorisnickoIme;
        $sifra = $request->Sifra;
        $ponSifra = $request->PonovljenaSifra;
        if($sifra == $ponSifra){
            $korisnik->sifra = $sifra;
        } else {
            return back()->with('status', 'Sifre se ne poklapaju.');
        }
        $korisnikCheck = KorisnikModel::where('KorisnickoIme', $request->Ime);
        if(!empty($korisnikCheck)) {
            return back()->with('korImeErr', 'Vec postoji korisnik sa ovim korisnickim imenom.');
        }
        $korisnik->Ime = $request->Ime;
        $korisnik->email = $request->ePosta;
        $korisnik->vrsta = 0;
        $korisnik->opis = "Ja nisam admin";
        $korisnik->save();
        if(!auth()->attempt($request->only('KorisnickoIme', 'Sifra'))){
            return back()->with('stat', 'Pogresni podaci.');
        }
        return redirect()->route('profile', ['id' => $korisnik->idKorisnik]);
    }
}