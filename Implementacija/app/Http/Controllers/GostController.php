<?php

/**Autori: Mateja Milojević 2019/0382, Momcilo Milic 2019/0377*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KorisnikModel;
use Illuminate\Support\Facades\Hash;

/**
 * Kontroler za neregistrovane korisnike
 */
class GostController extends Controller{
    /**
     * login
     * 
     * Odlazak na stranu za prijavljivanje
     *
     * @return view
     */
    public function login()
    {
        return view('login');
    }

    /**
     * Funkcija koja preusmerava na stranicu forme za registraciju
     */
    public function register()
    {
        return view('register');
    }

    /**
     * login_submit
     * 
     * Primanje i provera podataka pri prijavi
     *
     * @param Request $request
     * 
     * @return view
     */
    public function login_submit(Request $request)
    {
        $this->validate($request,[
            'KorisnickoIme' => 'required',
            'Sifra' => 'required'
        ],
        [
            'required' => 'Polje :attribute je obavezno.'
        ]); 

        $korIme = $request->KorisnickoIme;
        $sifra = $request->Sifra;

        $korImeCount = KorisnikModel::where('KorisnickoIme', $korIme)->count();
        $emailCount = KorisnikModel::where('email', $korIme)->count();

        if($korImeCount > 0){
            $korisnik = KorisnikModel::where('KorisnickoIme', $korIme)->first();
        } else if($emailCount > 0) {
            $korisnik = KorisnikModel::where('email', $korIme)->first();
        } else {
            return back()->with('status', 'Pogresni podaci.');
        }

        if(Hash::check($sifra, $korisnik->Sifra)){
            $hashSifra = Hash::make($sifra);
            auth()->attempt(['KorisnickoIme' => $korisnik->KorisnickoIme, 'Sifra' => $korisnik->Sifra]);
        } else {
            return back()->with('status', 'Pogresni podaci.');
        }
        return redirect()->route('index');
    }

    /**
     * Funkcija za registraciju, tj. pravljenje novog korisnika
     */
    public function register_submit(Request $request)
    {
        //dd($request);
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
            $korisnik->Sifra = Hash::make($sifra);
        } else {
            return back()->with('status', 'Sifre se ne poklapaju.');
        }

        $korisnikCount = KorisnikModel::where('KorisnickoIme', $request->KorisnickoIme)->count();
        if($korisnikCount > 0) {
            return back()->with('korImeErr', 'Korisnicko ime je zauzeto.');
        }
        $emailCount = KorisnikModel::where('email', $request->ePosta)->count();
        if($emailCount > 0) {
            return back()->with('emailErr', 'E-mail adresa je zauzeta.');
        }
        $korisnik->Ime = $request->Ime;
        $korisnik->email = $request->ePosta;
        $korisnik->vrsta = 0;
        $korisnik->opis = "Novajlija ovde";
        $korisnik->save();
        auth()->attempt(['KorisnickoIme' => $korisnik->KorisnickoIme, 'Sifra' => $korisnik->Sifra]);
        //if(!auth()->attempt($request->only('KorisnickoIme', 'Sifra'))){
          //  return back()->with('stat', 'Pogresni podaci.');
        //}
        return redirect()->route('profile', ['id' => $korisnik->idKorisnik]);
    }
}