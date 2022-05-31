<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function getKorisnik(){
        return $this->hasOne(KorisnikModel::class,'idKorisnik','Korisnik_idKorisnik');
    }
}