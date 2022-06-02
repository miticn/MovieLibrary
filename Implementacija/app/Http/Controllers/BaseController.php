<?php
//Autori: Momcilo Milic 2019/0377, Mateja Milojevic 2019/0382, Nikola Mitic 2017/0110
namespace App\Http\Controllers;

use App\Models\FilmModel;
use App\Models\GlumacModel;
use App\Models\KomentarModel;
use App\Models\KorisnikModel;
use App\Models\ListaModel;

use Illuminate\Http\Request;

/**
* BaseController - klasa za opste funkcije
*/

class BaseController extends Controller{
    /**
     * Funkcija koja odredjuje vrstu trofeja
     */
    private static function getTrophy($score){
        if($score<50){
            $trophy = 'fa-recycle trash';
        }else if ($score>=50 && $score<66){
            $trophy = 'fa-trophy bronze-trophy';
        }else if ($score>=66 && $score<82){
            $trophy = 'fa-trophy silver-trophy';
        }else if ($score>=82){
            $trophy = 'fa-trophy gold-trophy';
        }
        return $trophy;
    }

    /**
     * Funkcija koja racuna i vraca rezultat u procentima na osnovu lajk/dislajk odnosa
     */
    private static function getScore($BrojLajk,$BrojDislajk){
        if ($BrojLajk+$BrojDislajk===0) return 0;
        return round($BrojLajk/($BrojLajk+$BrojDislajk)*100);
    }

    /**
     * Funkcija koja dobavlja rezultat i trofej za neku stranicu
     */
    private static function getScoreAndTrophyArray($Library){
        $array = [];
        $array['scores'] = [];
        $array['trophies'] = [];
        foreach($Library as $lib){
            $score = BaseController::getScore($lib->BrojLajk,$lib->BrojDislajk);
            array_push($array['scores'],$score);
            array_push($array['trophies'],BaseController::getTrophy($score));
        }
        return $array;
    }
    
    /**
     * Funkcija za preusmeravanje na stranicu profila
     */
    public function profile($id){
        return view('profile', ['profile' => KorisnikModel::find($id)]);
    }

    /**
     * Funkcija za preusmeravanje na pocetnu stranicu
     */
    public function indexPage(){
        $filmovi = FilmModel::orderByDesc('BrojLajk')->limit(18)->get();
        $array = BaseController::getScoreAndTrophyArray($filmovi);
        
        return view('index',['filmovi' => $filmovi, 'scores'=>$array['scores'], 'trophies'=>$array['trophies']]);
    }

    /**
     * Funkcija koja vrsi pretragu i preusmerava na stranicu sa rezultatima pretrage
     */
    public function search(Request $request){
        $Naziv = $request->query('naziv');
        $filmovi = FilmModel::query()
            ->where('Naziv', 'LIKE', "%{$Naziv}%")
            ->orWhere('Opis', 'LIKE', "%{$Naziv}%")
            ->limit(50)->get();

        $glumci = GlumacModel::query()
            ->where('Ime', 'LIKE', "%{$Naziv}%")
            ->orWhere('Opis', 'LIKE', "%{$Naziv}%")
            ->limit(50)->get();

        $korisnici = KorisnikModel::query()
            ->where('KorisnickoIme', 'LIKE', "%{$Naziv}%")
            ->orWhere('Ime', 'LIKE', "%{$Naziv}%")
            ->orWhere('Opis', 'LIKE', "%{$Naziv}%")
            ->limit(50)->get();

        $stFilmovi = BaseController::getScoreAndTrophyArray($filmovi);
        $stGlumci = BaseController::getScoreAndTrophyArray($glumci);
        return view('search',['filmovi' => $filmovi, "glumci" => $glumci, "stFilmovi"=> $stFilmovi, "stGlumci"=> $stGlumci ,"korisnici" => $korisnici ,"naziv" => $Naziv]);
    }

    /**
     * Funkcija za preusmeravanje na stranicu liste
     */
    public function lista($id)
    {
       return view('lista', ['lista' => ListaModel::find($id)]);
    }

    /**
     * Funkcija za preusmeravanje na stranicu glumca
     */
    public function actor($id) {
        $glumac = GlumacModel::find($id);
        $score = BaseController::getScore($glumac->BrojLajk, $glumac->BrojDislajk);
        $trophy = BaseController::getTrophy($score);
        $komentari = BaseController::getComments('actor', $id);
        $sviFilmovi = FilmModel::all()->sortBy('Naziv');
        return view('actor', ['glumac' => $glumac, 'score'=>$score, 'trophy' =>$trophy, 'komentari' => $komentari,'sviFilmovi'=>$sviFilmovi]);
    }

    /**
     * Funkcija za preusmeravanje na stranicu filma
     */
    public function movie($id){
        $film = FilmModel::find($id);
        $score = BaseController::getScore($film->BrojLajk,$film->BrojDislajk);
        $trophy = BaseController::getTrophy($score);
        $komentari = BaseController::getComments('movie',$id);
        $sviGlumci = GlumacModel::all()->sortBy('Ime');
        return view('movie',['film'=>$film, 'score'=>$score, 'trophy'=>$trophy,'komentari'=>$komentari,'sviGlumci'=>$sviGlumci]);
    }

    /**
     * Funkcija koja vraca indikator na osnovu naziva
     */
    public static function getIndikator($naziv){
        $indikator = -1;
        if($naziv=='movie'){
            $indikator = 0;
        }else if ($naziv=='actor'){
            $indikator = 1;
        }
        return $indikator;
    }

    /**
     * Funkcija koja vraca sve komentare na nekoj stranici
     */
    public function getComments($indikator,$stranica){
        return KomentarModel::where('Indikator',BaseController::getIndikator($indikator))->where('Stranica',$stranica)->get();
    }
}