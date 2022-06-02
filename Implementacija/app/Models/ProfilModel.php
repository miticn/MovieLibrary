<?php

//Autori: Mateja Milojević 2019/0382

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * klasa KorisnikModel za tabelu korisnik u bazi podataka
 */
class KorisnikModel extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'korisnik';
    /**
     * @var string
     */
    protected $primaryKey = 'idKorisnik';
    
    /**
     * @var string[]
     */
    protected $fillable = [
        'KorisnickoIme',
        'Ime',
        'email',
        'Sifra',
        'Vrsta',
        'Opis'
    ];
}