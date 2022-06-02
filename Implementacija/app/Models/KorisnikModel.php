<?php

/**Autori: Mateja Milojević */

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\ListaModel;

/**
 * Model tabele korisnik
 */
class KorisnikModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'korisnik';
    protected $primaryKey = 'idKorisnik';
    public $timestamps = false;
    
    protected $fillable = [
        'KorisnickoIme',
        'Ime',
        'email',
        'Sifra',
        'Vrsta',
        'Opis'
    ];

    /**
     * getAuthPassword
     * 
     * Vraca sifru korisnika
     *
     * @return int
     */
    public function getAuthPassword()
    {
        return $this->Sifra;
    }

    /**
     * sacuvani
     * 
     * Vraca odnos korisnika i profila koje čuva
     *
     * @return KorisnikModel
     */
    public function sacuvani()
    {
        return $this->belongsToMany(KorisnikModel::class, 'cuva_korisnika', 'idCuva', 'idCuvan');
    }

    /**
     * liste
     * 
     * Vraca odnos korisnika i listi koje čuva
     *
     * @return ListaModel
     */
    public function liste()
    {
        return $this->belongsToMany(ListaModel::class, 'cuva_listu', 'Korisnik_id_cuva', 'Lista_id_cuvana');
    }

    /**
     * napravljeneListe
     * 
     * Vraca odnos korisnika i listi koje je napravio
     *
     * @return ListaModel
     */
    public function napravljeneListe()
    {
        return $this->hasMany(ListaModel::class, 'Korisnik_idKorisnik', 'idKorisnik');
    }

    public function isAdmin(){
        return $this->Vrsta;
    }

    /**
     * izmeniProfil
     * 
     * Postavljanje podataka za izmenu
     *
     * @param mixed $request
     * 
     * @return null
     */
    public function izmeniProfil($request)
    {
        
        $this->Ime = $request->Ime;
        $this->Opis = $request->Opis;
        $this->save();
    }
    
}
