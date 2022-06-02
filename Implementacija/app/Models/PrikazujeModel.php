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

    /**
     * @var string
     */
    protected $table = 'prikazuje_se';
    /**
     * @var string
     */
    protected $primaryKey = 'Film_idFilm';

    /**
     * @var string[]
     */
    protected $fillable = ['URL'];
    /**
     * @var bool
     */
    public $timestamps = false;

}
