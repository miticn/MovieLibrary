<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KorisnikModel;
use Illuminate\Support\Facades\DB;

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

    public function cuvana_je()
    {
        return $this->belongsToMany(KorisnikModel::class, 'cuva_listu', 'Lista_id_cuvana', 'Korisnik_id_cuva');
    }

    public function autor()
    {
        return (KorisnikModel::find($this->Korisnik_idKorisnik))->Ime;
    }

    public function cuva_film()
    {
        return $this->belongsToMany(FilmModel::class, 'u_listi', 'Lista_idLista', 'Film_idFilm');
    }

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

    public function napravio($user)
    {
        return ListaModel::where('Korisnik_idKorisnik', '=', $user);
    }
}