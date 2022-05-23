<?php

namespace App\Http\Controllers;

use App\Models\FilmModel;
use App\Models\KorisnikModel;
use App\Models\ListaModel;
use GuzzleHttp\Psr7\Request;

class BaseController extends Controller{
    
    public function profile($id){
        return view('profile', ['profile' => KorisnikModel::find($id)]);
    }

    public function indexPage(){
        return view('index',['filmovi' => FilmModel::orderByDesc('BrojLajk')->limit(18)->get()]);
    }

    public function lista($id)
    {
       return view('lista', ['lista' => ListaModel::find($id)]);
    }
}