<?php

/**Autori: Mateja Milojević */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model tabele Svidjanja i Ne Svidjanja
 */
class Lajk_DislajkModel extends Model
{
    use HasFactory;

    protected $table = 'lajk_dislajk';
    protected $primaryKey = 'idLajk_Dislajk';
    public $timestamps = false;
    
    protected $fillable = [
        'idLajk_Dislajk',
        'Korisnik_idKorisnik',
        'Indikator',
        'Lokacija',
        'Vrsta'
    ];
}