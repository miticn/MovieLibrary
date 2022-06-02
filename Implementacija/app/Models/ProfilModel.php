<?php

//Autori: Nikola Mitic 2017/0110

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * klasa KorisnikModel za tabelu korisnik u bazi podataka
 */
class KorisnikModel extends Model
{
    use HasFactory;

    protected $table = 'korisnik';
    protected $primaryKey = 'idKorisnik';
    
    protected $fillable = [
        'KorisnickoIme',
        'Ime',
        'email',
        'Sifra',
        'Vrsta',
        'Opis'
    ];
}