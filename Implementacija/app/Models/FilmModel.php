<?php

//Autori: Mateja Milojevic 2019/0382, Nikola Mitic 2017/0110

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * klasa FilmModel za tabelu film u bazi podataka
 */
class FilmModel extends Model
{
    use HasFactory;

    protected $table = 'film';
    protected $primaryKey = 'idFilm';
    
    public $timestamps = false;

    protected $fillable = [
        'Naziv',
        'Opis',
        'Reziseri',	
        'Pisci',	
        'Zanrovi',	
        'Datum_Objave',	
        'Trajanje',	
        'BrojLajk',
        'BrojDislajk'
    ];

    /**
     * Funkcija koja vraca sve glumce filma
     */
    public function glumci(){
        return $this->belongsToMany(GlumacModel::class, 'glumi', 'Film_idFilm', 'Glumac_idGlumac')->withPivot('Ime_uloge');
    }

    /**
     * Funkcija koja proverava da li se film daje u bioskopu
     */
    public function u_bioskopu(){
        return $this->hasOne(PrikazujeModel::class,'Film_idFilm');
    }

    /**
     * Funkcija koja proverava da li se film nalazi u listi
     */
    public function u_listi()
    {
        return $this->belongsToMany(ListaModel::class, 'u_listi', 'Film_idFilm', 'Lista_idLista');
    }

    /**
     * Funkcija koja proverava da li je trenutno ulogovani korisnik vec ocenio film
     */
    public function ocenio()
    {   
        $podaci = ['Korisnik_idKorisnik' => auth()->id(), 'Indikator' => '0', 'Lokacija' => $this->idFilm];
        $ocena = Lajk_DislajkModel::where($podaci)->first();
        if($ocena == null){
            return 0;
        }elseif($ocena->Vrsta == 1){
            return 1;
        }else{
            return -1;
        }
    }
}