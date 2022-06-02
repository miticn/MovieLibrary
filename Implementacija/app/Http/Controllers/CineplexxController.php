<?php
/*@author     Nikola Mitic 17/0110*/
namespace App\Http\Controllers;

use App\Models\FilmModel;
use App\Models\PrikazujeModel;
use Weidner\Goutte\GoutteFacade;
use Illuminate\Http\Request;

/**
 * Ovaj kontroler sluzi za povezivanje sa cineplexx.rs
 */
class CineplexxController extends Controller
{
    /**
     * Funkcija dovlaci filmove sa cineplexx.rs sajta sve filmove koji su trenutno u ponudi, 
     * pa onda ih uporedjuje sa filmovima u lokalnoj bazi i cuva u PrikazujeModel.
     * @return void
     * 
     */
    public static function updateRepertoar(){
            $crawler = GoutteFacade::request('GET', 'https://www.cineplexx.rs/service/program.php');
            PrikazujeModel::truncate();
            $crawler->filter('.clearfix')->each(function ($node){
                $link = $node->filter('a')->first()->attr('href');
                $title = $node->filter('.starBoxSmall')->filter('p')->first()->text();
                //dump($title,$link);
                $film = FilmModel::query()
                    ->where('Naziv', 'LIKE', "{$title}")->first();
                if($film!=null){
                    $filmsave = new PrikazujeModel();
                    $filmsave->Film_idFilm = $film->idFilm;
                    $filmsave->URL = $link;
                    $filmsave->save();
                }
            });
    }

    /**
     * Proverava da li se film sa $id prikazuje u cineplexxu.
     *
     * @param int $id
     * 
     * @return bool
     * 
     */
    public static function inRepertoar($id){
        return PrikazujeModel::find($id)!=null;
    }
}
