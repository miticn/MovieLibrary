<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function glumci(){
        return $this->belongsToMany(GlumacModel::class, 'glumi', 'Film_idFilm', 'Glumac_idGlumac')->withPivot('Ime_uloge');
    }
    public function u_bioskopu(){
        return $this->hasOne(PrikazujeModel::class,'Film_idFilm');
    }

    public function u_listi()
    {
        return $this->belongsToMany(ListaModel::class, 'u_listi', 'Film_idFilm', 'Lista_idLista');
    }

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