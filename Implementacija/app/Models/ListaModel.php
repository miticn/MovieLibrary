<?php

/**Autori: Mateja Milojević */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KorisnikModel;
use Illuminate\Support\Facades\DB;

/**
 * Model tabele listi filmova
 */
class ListaModel extends Model
{
    use HasFactory;

    protected $table = 'lista';
    protected $primaryKey = 'idLista';

    public $timestamps = false;
    
    protected $fillable = [
        'Ime',
        'Korisnik_idKorisnik',
        'BrojLajk',
        'BrojDislajk'
    ];

    /**
     * cuvana_je
     * 
     * Vraca odnos listi i profila koji je cuvaju
     *
     * @return KorisnikModel
     */
    public function cuvana_je()
    {
        return $this->belongsToMany(KorisnikModel::class, 'cuva_listu', 'Lista_id_cuvana', 'Korisnik_id_cuva');
    }

    /**
     * autor
     * 
     * Vraca ime autora liste
     *
     * @return KorisnikModel
     */
    public function autor()
    {
        return (KorisnikModel::find($this->Korisnik_idKorisnik))->Ime;
    }

    /**
     * cuva_film
     * 
     * Vraca odnos liste i filmova koje cuva
     *
     * @return FilmModel
     */
    public function cuva_film()
    {
        return $this->belongsToMany(FilmModel::class, 'u_listi', 'Lista_idLista', 'Film_idFilm');
    }

    /**
     * ocenio
     * 
     * Vraca za zadatog korisnika vrednost int u odnosu na to da li je ocenio listu
     * 0 - nista, 1 - svidjanje, -1 - ne svidjanje
     *
     * @return int
     */
    public function ocenio()
    {   
        $podaci = ['Korisnik_idKorisnik' => auth()->id(), 'Indikator' => '3', 'Lokacija' => $this->idLista];
        $ocena = Lajk_DislajkModel::where($podaci)->first();
        if($ocena == null){
            return 0;
        }elseif($ocena->Vrsta == 1){
            return 1;
        }else{
            return -1;
        }
    }

    /**
     * napravio
     * 
     * Vraca liste napravljene od strane prosledjenog korisnika
     *
     * @param mixed $user
     * 
     * @return ListaModel
     */
    public function napravio($user)
    {
        return ListaModel::where('Korisnik_idKorisnik', '=', $user);
    }
}