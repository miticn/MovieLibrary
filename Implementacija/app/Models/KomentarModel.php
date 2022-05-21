<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomentarModel extends Model
{
    use HasFactory;

    protected $table = 'komentar';
    protected $primaryKey = 'idKomentar';
    
    protected $fillable = [
        'Tekst',
        'Korisnik_idKorisnik',
        'Idikator',
        'Stranica'
    ];
}