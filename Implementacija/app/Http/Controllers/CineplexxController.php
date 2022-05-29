<?php

namespace App\Http\Controllers;

use App\Models\FilmModel;
use App\Models\PrikazujeModel;
use Weidner\Goutte\GoutteFacade;
use Illuminate\Http\Request;

class CineplexxController extends Controller
{
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

    public static function inRepertoar($id){
        return PrikazujeModel::find($id)!=null;
    }
}
