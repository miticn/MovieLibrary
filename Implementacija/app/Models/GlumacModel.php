<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlumacModel extends Model
{
    use HasFactory;

    protected $table = 'glumac';
    protected $primaryKey = 'idGlumac';
    
    public $timestamps = false;

    protected $fillable = [
        'Ime',
        'Opis',
        'Datum_Rodjenja',
        'BrojLajk',
        'BrojDislajk'
    ];

    public function filmovi(){
        return $this->belongsToMany(FilmModel::class, 'glumi', 'Glumac_idGlumac', 'Film_idFilm')->withPivot('Ime_uloge');
    }
}