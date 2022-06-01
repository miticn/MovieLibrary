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

    public function oceni(Request $request)
    {
        $podaci = ['Korisnik_idKorisnik' => auth()->id(), 'Indikator' => $request->indikator, 'Lokacija' => $request->lokacija];
        $ocena = Lajk_DislajkModel::where($podaci)->first();
        $podatak = ListaModel::find($request->lokacija);
        switch($request->indikator){
            case 0: $podatak = FilmModel::find($request->lokacija); break;
            case 1: $podatak = GlumacModel::find($request->lokacija); break;
            case 2: $podatak = KomentarModel::find($request->lokacija); break; 
            case 0: $podatak = ListaModel::find($request->lokacija); break;
        }
        if($ocena == null){
            Lajk_DislajkModel::create([
                'Korisnik_idKorisnik' => auth()->id(),
                'Indikator' => $request->indikator,
                'Lokacija' => $request->lokacija,
                'Vrsta' => $request->vrsta
            ]);
            if($request->vrsta == 1){
                $podatak->BrojLajk++;
            }else{
                $podatak->BrojDislajk++;
            }
        }else{
            if($ocena->Vrsta == 1){
                $podatak->BrojLajk--;
            }else{
                $podatak->BrojDislajk--;
            }
            $ocena->delete();
        }
        $podatak->save();
        return back();
    }

    public function sacuvaj_film(Request $request)
    {
        $lista = ListaModel::find($request->get('izabrana'));
        $lista->cuva_film()->attach($request->film);
        return back();
    }

    public function zaboravi_film(Request $request)
    {
        $lista = ListaModel::find($request->lista);
        $lista->cuva_film()->detach($request->film);
        return back();
    }

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

    public function commentActor(Request $request, $id){
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
        return redirect('/actor/'.$id);
    }

    public function removeComment(Request $request, $id ,$commId){
        abort_if(! $request->user()->isAdmin(), 404);
        $komentar = KomentarModel::find($commId);
        $komentar->delete();
        return back();
    }

    public function removeRole(Request $request,$idFilm,$idActor){
        abort_if(! $request->user()->isAdmin(), 404);
        $flim = FilmModel::find($idFilm);
        $flim->glumci()->detach($idActor);
    }

    public function addRole(Request $request,$idFilm,$idActor){
        abort_if(! $request->user()->isAdmin(), 404);
        $request->validate([
            'Ime_uloge' => 'required'
        ]);
        if($idActor==-1){
            $idActor=$request->Glumac;
        }
        if($idFilm==-1){
            $idFilm=$request->Film;
        }
        $flim = FilmModel::find($idFilm);
        $flim->glumci()->attach($idActor,['Ime_uloge' => $request->Ime_uloge]);
        return redirect()->back();
    }
}