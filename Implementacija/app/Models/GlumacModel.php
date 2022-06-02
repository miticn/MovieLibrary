<?php

//Autori: Momcilo Milic 2019/0377, Mateja Milojevic 2019/0382, Nikola Mitic 2017/0110

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * klasa GlumacModel za tabelu glumac u bazi podataka
 */
class GlumacModel extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'glumac';
    /**
     * @var string
     */
    protected $primaryKey = 'idGlumac';
    
    /**
     * @var bool
     */
    public $timestamps = false;

     /**
     * @var string[]
     */
    protected $fillable = [
        'Ime',
        'Opis',
        'Datum_Rodjenja',
        'BrojLajk',
        'BrojDislajk'
    ];

    /**
     * Funkcija koja vraca filmove u kom igra glumac
     */
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