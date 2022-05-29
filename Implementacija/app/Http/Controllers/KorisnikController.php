<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
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

    public function izmeni()
    {
        return view('izmeni');
    }

    public function izmeni_submit(Request $request)
    {
        if($request->has('slika')){
            #$request->file('slika')->storeAs('public/IMG', "yeboi");
            #Storage::disk('library')->put("pleasebruv.txt", 'sum');
        }
        KorisnikModel::find(auth()->id())->izmeniProfil($request);
        return redirect()->route('profile', ['id' => auth()->id(), 'profile' => KorisnikModel::find(auth()->id())]);
    }

    public function napravi_listu(Request $request)
    {
        $this->validate($request,[
            'Ime' => 'required'
        ]);

        $lista = ListaModel::create([
            'Korisnik_idKorisnik' => auth()->id(),
            'Ime' => $request->Ime
        ]);
        $lista->cuvana_je()->attach(auth::id());
        return back();
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
        KorisnikModel::find(auth::id())->sacuvani()->detach($request->id);
        return back();
    }


    public function createPage(Request $request){
        if (auth::check()) {
            abort_if(! $request->user()->isAdmin(), 404);
            return view('create');
        }
        else abort(404);
    }

    public function createPageMovie(Request $request){
        if (auth::check()) {
            abort_if(! $request->user()->isAdmin(), 404);
            return view('create');
        }
        else abort(404);
    }
}