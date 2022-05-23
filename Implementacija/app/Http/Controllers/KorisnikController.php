<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KorisnikModel;
use App\Models\ListaModel;
use Illuminate\Support\Facades\Auth;

class KorisnikController extends Controller{
    public function logout()
    {
        auth()->logout();
        return redirect()->route('index');
    }

    public function sacuvaj_listu(Request $request)
    {
        $lista = ListaModel::find($request->id);
        $lista->cuvana_je()->attach(auth::id());
        return back();
    }

    public function zaboravi_listu(Request $request)
    {
        $lista = ListaModel::find($request->id);
        $lista->cuvana_je()->detach(auth::id());
        return back();
    }

    public function sacuvaj_korisnika(Request $request)
    {
        KorisnikModel::find(auth::id())->sacuvani()->attach($request->id);
        return back();
    }

    public function zaboravi_korisnika(Request $request)
    {
        KorisnikModel::find(auth::id())->sacuvani()->detach(auth::id($request->id));
        return back();
    }
}