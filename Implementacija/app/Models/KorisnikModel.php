<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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