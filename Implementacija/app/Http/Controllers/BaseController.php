<?php

namespace App\Http\Controllers;

use App\Models\FilmModel;
use App\Models\KorisnikModel;

class BaseController extends Controller{
    
    public function profile($id){
        return view('profile', ['profile' => KorisnikModel::find($id)]);
    }

    public function indexPage(){
        return view('index',['filmovi' => FilmModel::orderByDesc('BrojLajk')->limit(18)->get()]);
    }
}