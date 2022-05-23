<?php

namespace App\Http\Controllers;

use App\Models\FilmModel;
use App\Models\KorisnikModel;

class BaseController extends Controller{
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
    private static function getScore($BrojLajk,$BrojDislajk){
        return round($BrojLajk/($BrojLajk+$BrojDislajk)*100);
    }


    public function profile($id){
        return view('profile', ['profile' => KorisnikModel::find($id)]);
    }

    public function indexPage(){
        $filmovi = FilmModel::orderByDesc('BrojLajk')->limit(18)->get();
        $trophies = [];
        $scores = [];
        foreach($filmovi as $film){
            $score = BaseController::getScore($film->BrojLajk,$film->BrojDislajk);
            array_push($scores,$score);
            array_push($trophies,BaseController::getTrophy($score));
        }
        
        return view('index',['filmovi' => $filmovi, 'scores'=>$scores, 'trophies'=>$trophies]);
    }
    public function search($Naziv){

    }
}