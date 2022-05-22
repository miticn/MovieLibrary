<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class KorisnikModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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

    public function getAuthPassword()
    {
        return $this->Sifra;
    }

}
