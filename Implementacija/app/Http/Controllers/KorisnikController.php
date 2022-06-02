<?php
//Autori: Momcilo Milic 2019/0377, Mateja Milojevic 2019/0382, Nikola Mitic 2017/0110
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

/**
 * Funkcije koje se pozivaju u rezimu korisnika
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
     * funkcija za preusmeravanje na formu za izmenu korisnickog profila
     */
    public function izmeni()
    {
        return view('izmeni');
    }

    /**
     * funkcija za prijavu izmena profila
     */
    public function izmeni_submit(Request $request)
    {
        if($request->has('slika')){
            $request->file('slika')->storeAs('public/img_profile','profile'.auth()->id().'.jpg');
        }
        KorisnikModel::find(auth()->id())->izmeniProfil($request);
        return redirect()->route('profile', ['id' => auth()->id(), 'profile' => KorisnikModel::find(auth()->id())]);
    }

    /**
     * Funkcija za pravljenje liste filmova
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
     * Funkcija koja obradjuje lajk/dislajk ocenu
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
     * Funkcija za cuvanje filma u listu
     */
    public function sacuvaj_film(Request $request)
    {
        $lista = ListaModel::find($request->get('izabrana'));
        $lista->cuva_film()->attach($request->film);
        return back();
    }

    /**
     * Funkcija za brisanje filma iz liste
     */
    public function zaboravi_film(Request $request)
    {
        $lista = ListaModel::find($request->lista);
        $lista->cuva_film()->detach($request->film);
        return back();
    }

    /**
     * Funkcija za cuvanje liste drugog korisnika
     */
    public function sacuvaj_listu(Request $request)
    {
        $lista = ListaModel::find($request->id);
        $lista->cuvana_je()->attach(auth::id());
        return back();
    }

    /**
     * Funkcija za brisanje liste iz cuvanih
     */
    public function zaboravi_listu(Request $request)
    {
        $lista = ListaModel::find($request->id);
        $lista->cuvana_je()->detach(auth::id());
        return back();
    }

    /**
     * funkcija za cuvanje drugog korisnika
     */
    public function sacuvaj_korisnika(Request $request)
    {
        KorisnikModel::find(auth::id())->sacuvani()->attach($request->id);
        return back();
    }

    /**
     * Funkcija za brisanje korisnika iz cuvanih
     */
    public function zaboravi_korisnika(Request $request)
    {
        KorisnikModel::find(auth::id())->sacuvani()->detach($request->id);
        return back();
    }

    /**
     * Funkcija za preusmeravanje na stranicu sa formom za pravljenje stranica
     */
    public function createPage(Request $request){
        abort_if(! $request->user()->isAdmin(), 404);
        return view('create');
    }

    /**
     * Funkcija za preusmeravanje na stranicu sa formom za pravljenje stranica filmova
     */
    public function createPageMovie(Request $request){
        abort_if(! $request->user()->isAdmin(), 404);
        return view('createMovie');
    }

    /**
     * Funkcija za preusmeravanje na stranicu sa formom za pravljenje stranica glumaca
     */
    public function createPageActor(Request $request){
        abort_if(! $request->user()->isAdmin(), 404);
        return view('createActor');

    }

    /**
     * Funkcija za pravljenje stranice glumca
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
        $request->file('poster')->storeAs('public/img_actor','glumac'.($glumac->idGlumac).'.jpg');
        return view('createActor',['uspeh'=>'Glumac je uspešno kreiran.']);
    }

    /**
     * Funkcija za pravljenje stranice filma
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
        $request->file('poster')->storeAs('public/img_film','film'.($film->idFilm).'.jpg');
        return view('createMovie',['uspeh'=>'Film je uspešno kreiran.']);
    }

    /**
     * Funkcija za pravljenje komentara
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
     * Funkcija za brisanje komentara
     */
    public function removeComment(Request $request, $id ,$commId){
        abort_if(! $request->user()->isAdmin(), 404);
        $komentar = KomentarModel::find($commId);
        $komentar->delete();
        return back();
    }

    /**
     * funkcija za brisanje uloge glumca
     */
    public function removeRole(Request $request,$idFilm,$idActor){
        abort_if(! $request->user()->isAdmin(), 404);
        $flim = FilmModel::find($idFilm);
        if(!$flim->glumci()->where('Glumac_idGlumac', $idActor)->exists())
            return redirect()->back();
        $flim->glumci()->detach($idActor);
    }

    /**
     * funckija za dodavanj uloge glumca
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