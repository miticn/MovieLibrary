<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lajk_DislajkModel extends Model
{
    use HasFactory;

    protected $table = 'lajk_dislajk';
    protected $primaryKey = 'idLajk_Dislajk';
    
    protected $fillable = [
        'idLajk_Dislajk',
        'Korisnik_idKorisnik',
        'Indikator',
        'Lokacija',
        'Vrsta'
    ];
}