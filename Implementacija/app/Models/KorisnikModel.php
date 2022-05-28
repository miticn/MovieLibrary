<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\ListaModel;

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

    public function sacuvani()
    {
        return $this->belongsToMany(KorisnikModel::class, 'cuva_korisnika', 'idCuva', 'idCuvan');
    }

    public function liste()
    {
        return $this->belongsToMany(ListaModel::class, 'cuva_listu', 'Korisnik_id_cuva', 'Lista_id_cuvana');
    }

    public function isAdmin(){
        return $this->Vrsta;
    }
    
}
