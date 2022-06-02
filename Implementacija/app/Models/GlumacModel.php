<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlumacModel extends Model
{
    use HasFactory;

    protected $table = 'glumac';
    protected $primaryKey = 'idGlumac';
    
    public $timestamps = false;

    protected $fillable = [
        'Ime',
        'Opis',
        'Datum_Rodjenja',
        'BrojLajk',
        'BrojDislajk'
    ];

    public function filmovi(){
        return $this->belongsToMany(FilmModel::class, 'glumi', 'Glumac_idGlumac', 'Film_idFilm')->withPivot('Ime_uloge');
    }

    /**
     * ocenio
     * 
     * Vraca za zadatog korisnika vrednost int u odnosu na to da li je ocenio film
     * 0 - nista, 1 - svidjanje, -1 - ne svidjanje
     *
     * @return int
     */
    public function ocenio()
    {   
        $podaci = ['Korisnik_idKorisnik' => auth()->id(), 'Indikator' => '1', 'Lokacija' => $this->idGlumac];
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