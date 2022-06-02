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

    /**
     * @var string
     */
    protected $table = 'lajk_dislajk';
    /**
     * @var string
     */
    protected $primaryKey = 'idLajk_Dislajk';
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string[]
     */
    protected $fillable = [
        'idLajk_Dislajk',
        'Korisnik_idKorisnik',
        'Indikator',
        'Lokacija',
        'Vrsta'
    ];
}