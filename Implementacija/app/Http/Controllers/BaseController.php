<?php

namespace App\Http\Controllers;

use App\Models\KorisnikModel;

class BaseController extends Controller{
    
    public function profile($id){
        return view('profile', ['profile' => KorisnikModel::find($id)]);
    }

}