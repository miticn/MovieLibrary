<?php

//Autori: Nikola Mitic 2017/0110

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * klasa PrikazujeModel za tabelu prikazuje_se u bazi podataka
 */
class PrikazujeModel extends Model
{
    use HasFactory;

    protected $table = 'prikazuje_se';
    protected $primaryKey = 'Film_idFilm';

    protected $fillable = ['URL'];
    public $timestamps = false;

}
