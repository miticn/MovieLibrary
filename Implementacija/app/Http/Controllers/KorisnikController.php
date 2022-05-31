<?php

namespace App\Http\Controllers;

use App\Models\FilmModel;
use App\Models\GlumacModel;
use App\Models\KomentarModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\KorisnikModel;
use App\Models\Lajk_DislajkModel;
use App\Models\ListaModel;
use Illuminate\Support\Facades\Auth;

class KorisnikController extends Controller{
    public function logout()
    {
        auth()->logout();
        return redirect()->route('index');
    }

    public function izmeni()
    {
        return view('izmeni');
    }

    public function izmeni_submit(Request $request)
    {
        if($request->has('slika')){
            $request->file('slika')->storeAs('public/img_profile','profile'.auth()->id().'.jpg');
        }
        KorisnikModel::find(auth()->id())->izmeniProfil($request);
        return redirect()->route('profile', ['id' => auth()->id(), 'profile' => KorisnikModel::find(auth()->id())]);
    }

    public function napravi_listu(Request $request)
    {
        $this->validate($request,[
            'Ime' => 'required'
        ]);

        $lista = ListaModel::create([
            'Korisnik_idKorisnik' => auth()->id(),
            'Ime' => $request->Ime
        ]);
        $lista->cuvana_je()->attach(auth::id());
        return back();
    }

    // public function oceni(Request $request)
    // {
    //     $podaci = ['Korisnik_idKorisnik' => auth()->id(), 'Indikator' => $request->indikator, 'Lokacija' => $request->lokacija];
    //     $ocena = Lajk_DislajkModel::where($podaci)->first();
    //     $lista = ListaModel::find($request->lokacija);
    //     if($ocena == null){
    //         Lajk_DislajkModel::create($podaci, $request->vrsta);
    //         if($request->vrsta == 1){
    //             $lista->BrojLajk++;
    //         }else{
    //             $lista->BrojLajk--;
    //         }
    //     }elseif($ocena->vrsta == 1){
    //         if($request->vrsta == 1){
    //             $lista->BrojLajk--;
    //             //$ocena->
    //         }
    //     }else{
    //         $ocena->Vrsta = 0;
    //     }
    //     $ocena->save();
    //     return view('testing', ['info' => $ocena]);
    // }

    public function sacuvaj_listu(Request $request)
    {
        $lista = ListaModel::find($request->id);
        $lista->cuvana_je()->attach(auth::id());
        return back();
    }

    public function zaboravi_listu(Request $request)
    {
        $lista = ListaModel::find($request->id);
        $lista->cuvana_je()->detach(auth::id());
        return back();
    }

    public function sacuvaj_korisnika(Request $request)
    {
        KorisnikModel::find(auth::id())->sacuvani()->attach($request->id);
        return back();
    }

    public function zaboravi_korisnika(Request $request)
    {
        KorisnikModel::find(auth::id())->sacuvani()->detach($request->id);
        return back();
    }


    public function createPage(Request $request){
        abort_if(! $request->user()->isAdmin(), 404);
        return view('create');
    }

    public function createPageMovie(Request $request){
        abort_if(! $request->user()->isAdmin(), 404);
        return view('createMovie');
    }

    public function createPageActor(Request $request){
        abort_if(! $request->user()->isAdmin(), 404);
        return view('createActor');

    }

    public function createActor(Request $request){
        abort_if(! $request->user()->isAdmin(), 404);
        $request->validate([
            'poster'=>'mimes:jpg,jpeg|max:2048',
            'ime'=> 'required',
            'opis' => 'required',
            'datum' => 'required'
        ]);
        $glumac = new GlumacModel();
        $glumac->Ime=$request->ime;
        $glumac->Opis=$request->opis;
        $glumac->Datum_Rodjenja = $request->datum;
        $glumac->save();
        $request->file('poster')->storeAs('public/img_actor','glumac'.($glumac->idGlumac).'.jpg');
        return view('createActor',['uspeh'=>'Glumac je uspešno kreiran.']);
    }

    public function createMovie(Request $request){
        abort_if(! $request->user()->isAdmin(), 404);
        $request->validate([
            'poster'=>'mimes:jpg,jpeg|max:2048',
            'ime'=> 'required',
            'opis' => 'required',
            'reziseri' => 'required',
            'pisci' => 'required',
            'zanrovi' => 'required',
            'datum' => 'required',
            'trajanje' => 'required'
        ]);
        $film = new FilmModel();
        $film->Naziv = $request->ime;
        $film->Opis = $request->opis;
        $film->Reziseri = $request->reziseri;
        $film->Pisci = $request->pisci;
        $film->Zanrovi = $request->zanrovi;
        $film->Datum_Objave = $request->datum;
        $film->Trajanje = $request->trajanje;
        $film->save();
        $request->file('poster')->storeAs('public/img_film','film'.($film->idFilm).'.jpg');
        return view('createMovie',['uspeh'=>'Film je uspešno kreiran.']);
    }


    

    public function comment(Request $request, $id){
        $request->validate([
            'tekst' => 'required'
        ]);
        $indLong = explode('/',$request->getRequestUri())[1];
        $komentar = new KomentarModel();
        $komentar->Tekst = $request->tekst;
        $komentar->Korisnik_idKorisnik = auth()->id();
        $komentar->Indikator = BaseController::getIndikator($indLong);
        $komentar->Stranica = $id;
        $komentar->save();
        return redirect('/movie/'.$id);
    }
}