<?php

namespace App\Http\Controllers;

use App\Models\GlumacModel;
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
        abort_if(! $request->user()->isAdmin(), 404);
        return view('create');
    }

    public function createPageMovie(Request $request){
        abort_if(! $request->user()->isAdmin(), 404);
        return view('createMovie');
    }

    public function createPageActor(Request $request){
        abort_if(! $request->user()->isAdmin(), 404);
        return view('createActor');

    }

    public function createActor(Request $request){
        abort_if(! $request->user()->isAdmin(), 404);
        $request->validate([
            'poster'=>'mimes:jpg,jpeg|max:2048',
            'ime'=> 'required',
            'opis' => 'required',
            'datum' => 'required'
        ]);
        $glumac = new GlumacModel();
        $glumac->Ime=$request->ime;
        $glumac->Opis=$request->opis;
        $glumac->save();
        $request->file('poster')->storeAs('public/img_actor',($glumac->idGlumac).'.jpg');
        return view('createActor',['uspeh'=>'Glumac je uspešno kreiran.']);
    }

    public function createMovie(Request $request){
        abort_if(! $request->user()->isAdmin(), 404);
        $request->validate([
            'poster'=>'mimes:jpg,jpeg|max:2048',
            'ime'=> 'required',
            'opis' => 'required',
            'datum' => 'required'
        ]);
        $glumac = new GlumacModel();
        $glumac->Ime=$request->ime;
        $glumac->Opis=$request->opis;
        $glumac->save();
        $request->file('poster')->storeAs('public/img_actor',($glumac->idGlumac).'.jpg');
        return view('createActor',['uspeh'=>'Glumac je uspešno kreiran.']);
    }
}