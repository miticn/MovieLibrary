<?php

//Autori: Mateja Milojevic 2019/0382, Nikola Mitic 2017/0110

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * klasa KomentarModel za tabelu komentar u bazi podataka
 */
class KomentarModel extends Model
{
    use HasFactory;

    protected $table = 'komentar';
    protected $primaryKey = 'idKomentar';
    
    public $timestamps = false;

    protected $fillable = [
        'Tekst',
        'Korisnik_idKorisnik',
        'Indikator',
        'Stranica',
        'BrojLajk',
        'BrojDislajk'
    ];

    /**
     * Dohvata korisnika ciji je komentar
     *
     * @return KorisnikModel
     * 
     */
    public function getKorisnik(){
        return $this->hasOne(KorisnikModel::class,'idKorisnik','Korisnik_idKorisnik');
    }

    /**
     * Funkcija koja proverava da li je trenutno ulogovani korisnik vec ocenio komentar
     */
    public function ocenio()
    {   
        $podaci = ['Korisnik_idKorisnik' => auth()->id(), 'Indikator' => '2', 'Lokacija' => $this->idKomentar];
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