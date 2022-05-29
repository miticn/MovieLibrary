<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrikazujeModel extends Model
{
    use HasFactory;

    protected $table = 'prikazuje_se';
    protected $primaryKey = 'Film_idFilm';

    protected $fillable = ['URL'];
    public $timestamps = false;

}
