<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KorisnikModel;

class KorisnikController extends Controller{
    public function logout()
    {
        auth()->logout();
        return redirect()->route('index');
    }
}