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

/**
 * Bazični kontroler koji služi i korisnicima i gostima
 */
class BaseController extends Controller{
    /**
     * Vraca html klase za odgovarajuci trofej na osnovu skora
     *
     * @param int $score
     * 
     * @return string
 
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
     * Vraca odgovarajuci skor za filmove i glumce na osnovu broja lajkova i dislajkova
     *
     * @param int $BrojLajk
     * @param int $BrojDislajk
     * 
     * @return int
     */
    private static function getScore($BrojLajk,$BrojDislajk){
        if ($BrojLajk+$BrojDislajk===0) return 0;
        return round($BrojLajk/($BrojLajk+$BrojDislajk)*100);
    }

    /**
     * Racuna skorove i trofeje za niz stranica i vraca niz skorova i trofeja
     *
     * @param mixed $Library
     * 
     * @return int[]string[]
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
     * profile
     * 
     * Prikaz profila na osnovu id-a
     *
     * @param mixed $id
     * 
     * @return view
     */
    public function profile($id){
        return view('profile', ['profile' => KorisnikModel::find($id)]);
    }

    /**
     * Funkcija koja se poziva prilokom otvaranja pocetne stranice
     *
     * @return view
     * 
     */
    public function indexPage(){
        $filmovi = FilmModel::orderByDesc('BrojLajk')->limit(18)->get();
        $array = BaseController::getScoreAndTrophyArray($filmovi);
        
        return view('index',['filmovi' => $filmovi, 'scores'=>$array['scores'], 'trophies'=>$array['trophies']]);
    }
    /**
     * Funkcija za pretragu flilmova glumaca i korisnika
     *
     * @param Request $request
     * 
     * @return view
     * 
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
     * lista
     * 
     * Prikaz liste na osnovu id-a
     *
     * @param mixed $id
     * 
     * @return view
     */
    public function lista($id)
    {
       return view('lista', ['lista' => ListaModel::find($id)]);
    }

    /**
     * Funkcija koja vraca prikaz filma sa adekvatnim podacima za taj film
     *
     * @param int $id
     * 
     * @return view
     * 
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
     * Funkcija koja vraca prikaz filma sa adekvatnim podacima za taj film
     *
     * @param int $id
     * 
     * @return view
     * 
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
     * Dohvata indikator na osnovu naziva stranice
     *
     * @param string $naziv
     * 
     * @return int
     * 
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
     * Dohvata sve komentara za zadatu stranicu i indikator
     *
     * @param string $indikator
     * @param int $stranica
     * 
     * @return KomentarModel
     * 
     */
    public function getComments($indikator,$stranica){
        return KomentarModel::where('Indikator',BaseController::getIndikator($indikator))->where('Stranica',$stranica)->get();
    }
}