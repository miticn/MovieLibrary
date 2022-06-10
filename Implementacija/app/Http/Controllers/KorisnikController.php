<?php

/**Autori: Mateja Milojević 2019/0382, Nikola Mitic 2017/0110*/

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
use Illuminate\Support\Facades\Validator;

/**
 * Korisnik kontroler za autorizovane korisnike i administratore
 */
class KorisnikController extends Controller{
    /**
     * funkcija za izlogovanje, preusmerava na pocetnu stranu
     */
    public function logout()
    {
        auth()->logout();
        return redirect()->route('index');
    }

    /**
     * izmeni
     * 
     * Odlazak na stranu za izmenu profila
     *
     * @return view
     */
    public function izmeni()
    {
        return view('izmeni');
    }

    /**
     * izmeni_submit
     * 
     * Potvrda izmena profila
     *
     * @param Request $request
     * 
     * @return view
     */
    public function izmeni_submit(Request $request)
    {
        $v = Validator::make($request->all(),[ 
            'Ime' => 'required']
        );
        if ($v->fails()) 
            return redirect()->back();
        if($request->has('slika')){
            $request->file('slika')->storeAs('public/img_profile','profile'.auth()->id().'.jpg');
        }
        KorisnikModel::find(auth()->id())->izmeniProfil($request);
        return redirect()->route('profile', ['id' => auth()->id()]);
    }

    /**
     * napravi_listu
     * 
     * Pravljenje liste sa prosledjenim imenom od strane autorizovanog korisnika
     *
     * @param Request $request
     * 
     * @return view
     */
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

    /**
     * oceni
     * 
     * Svidjanje/Ne svidjanje filma, glumca, komentara, liste... 
     * Kriterijumi i podaci obrazlozeni u specifikacijama baze podataka
     *
     * @param Request $request
     * 
     * @return view
     */
    public function oceni(Request $request)
    {
        $podaci = ['Korisnik_idKorisnik' => auth()->id(), 'Indikator' => $request->indikator, 'Lokacija' => $request->lokacija];
        $ocena = Lajk_DislajkModel::where($podaci)->first();
        $podatak = ListaModel::find($request->lokacija);
        switch($request->indikator){
            case 0: $podatak = FilmModel::find($request->lokacija); break;
            case 1: $podatak = GlumacModel::find($request->lokacija); break;
            case 2: $podatak = KomentarModel::find($request->lokacija); break; 
            case 3: $podatak = ListaModel::find($request->lokacija); break;
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

    /**
     * sacuvaj_film
     * 
     * Čuvanje filma u izabranu listu
     *
     * @param Request $request
     * 
     * @return view
     */
    public function sacuvaj_film(Request $request)
    {
        $lista = ListaModel::find($request->izabrana);
        if($lista->Korisnik_idKorisnik==auth()->id()) 
            if(!($lista->cuva_film()->where('Film_idFilm',$request->film)->exists()))
                $lista->cuva_film()->attach($request->film);
        return back();
    }

    /**
     * zaboravi_film
     * 
     * Uklanjanje filma iz liste
     *
     * @param Request $request
     * 
     * @return view
     */
    public function zaboravi_film(Request $request)
    {
        $lista = ListaModel::find($request->lista);
        if($lista->Korisnik_idKorisnik==auth()->id()){
            $lista->cuva_film()->detach($request->film);
        }
        return back();
    }

    /**
     * sacuvaj_listu
     * 
     * Čuvanje liste na profilu
     *
     * @param Request $request
     * 
     * @return view
     */
    public function sacuvaj_listu(Request $request)
    {
        $lista = ListaModel::find($request->id);
        $lista->cuvana_je()->attach(auth::id());
        return back();
    }

    /**
     * zaboravi_listu
     * 
     * Uklanjanje liste iz liste sačuvanih listi na profilu
     *
     * @param Request $request
     * 
     * @return view
     */
    public function zaboravi_listu(Request $request)
    {
        $lista = ListaModel::find($request->id);
        $lista->cuvana_je()->detach(auth::id());
        if($lista->Korisnik_idKorisnik==auth::id()){
            $lista->Korisnik_idKorisnik=NULL;
            $lista->save();
        }
        return back();
    }

    /**
     * sacuvaj_korisnika
     * 
     * Čuvanje izabranog profila na sopstvenom
     *
     * @param Request $request
     * 
     * @return view
     */
    public function sacuvaj_korisnika(Request $request)
    {
        $korisnik = KorisnikModel::find(auth::id())->sacuvani()->where('idCuvan',$request->id);
        if(!$korisnik->exists()) KorisnikModel::find(auth::id())->sacuvani()->attach($request->id);
        return back();
    }

    /**
     * zaboravi_korisnika
     * 
     * Uklanjanje sačuvanog profila iz liste sačuvanih na profilu
     *
     * @param Request $request
     * 
     * @return view
     */
    public function zaboravi_korisnika(Request $request)
    {
        KorisnikModel::find(auth::id())->sacuvani()->detach($request->id);
        return back();
    }


    /**
     * Vraca pregled stranice za kreiranje stranica, ako je korisnik admin, a ako nije vraca 404 Not Found
     *
     * @param Request $request
     * 
     * @return view
     * 
     */
    public function createPage(Request $request){
        abort_if(! $request->user()->isAdmin(), 404);
        return view('create');
    }

    /**
     * Vraca pregled stranice za kreiranje stranica filma, ako je korisnik admin, a ako nije vraca 404 Not Found
     *
     * @param Request $request
     * 
     * @return view
     * 
     */
    public function createPageMovie(Request $request){
        abort_if(! $request->user()->isAdmin(), 404);
        return view('createMovie');
    }

    /**
     * Vraca pregled stranice za kreiranje stranica glumca, ako je korisnik admin, a ako nije vraca 404 Not Found
     *
     * @param Request $request
     * 
     * @return view
     * 
     */
    public function createPageActor(Request $request){
        abort_if(! $request->user()->isAdmin(), 404);
        return view('createActor');

    }

    /**
     * Dodaje glumca u bazu podataka, ako su ispostovani uslovi.
     *
     * @param Request $request
     * 
     * @return view
     * 
     */
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
        $file = $request->file('poster');
        if($file != null) {
            $file->storeAs('public/img_actor','glumac'.($glumac->idGlumac).'.jpg');
        }
        $id = $glumac->idGlumac;
        return redirect('/actor/'.$id);
    }

    /**
     * Dodaje film u bazu podataka, ako su ispostovani uslovi.
     *
     * @param Request $request
     * 
     * @return view
     * 
     */
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
        $file = $request->file('poster');
        if($file != null) {
            $file->storeAs('public/img_film','film'.($film->idFilm).'.jpg');
        }
        $id = $film->idFilm;
        return redirect('/movie/'.$id);
    }


    

    /**
     * Dodaje komentar na zeljenu stranicu
     *
     * @param Request $request
     * @param int $id
     * 
     * @return redirect
     * 
     */
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
        if($komentar->Indikator==0)
            return redirect('/movie/'.$id);
        else if ($komentar->Indikator==1)
            return redirect('/actor/'.$id);
    }

    /**
     * Brise zeljeni komentar ako je korisnik admin
     *
     * @param Request $request
     * @param int $id
     * @param int $commId
     * 
     * @return void
     * 
     */
    public function removeComment(Request $request, $id ,$commId){
        abort_if(! $request->user()->isAdmin(), 404);
        $komentar = KomentarModel::find($commId);
        Lajk_DislajkModel::where('Lokacija',$commId)->where('Indikator','2')->delete();
        $komentar->delete();
        return back();
    }

    /**
     * Brise ulogu glumca ako ona postiji
     *
     * @param Request $request
     * @param int $idFilm
     * @param int $idActor
     * 
     * @return redirect
     * 
     */
    public function removeRole(Request $request,$idFilm,$idActor){
        abort_if(! $request->user()->isAdmin(), 404);
        $flim = FilmModel::find($idFilm);
        if(!$flim->glumci()->where('Glumac_idGlumac', $idActor)->exists())
            return redirect()->back();
        $flim->glumci()->detach($idActor);
    }

    /**
     * Dodaje ulogu glumca za zadati film, ako on vec ne glumi u tom filmu
     *
     * @param Request $request
     * @param mixed $idFilm
     * @param mixed $idActor
     * 
     * @return redirect
     * 
     */
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
        if($flim->glumci()->where('Glumac_idGlumac', $idActor)->exists())
            return redirect()->back();
        $flim->glumci()->attach($idActor,['Ime_uloge' => $request->Ime_uloge]);
        return redirect()->back();
    }
}