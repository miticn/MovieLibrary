<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaModel extends Model
{
    use HasFactory;

    protected $table = 'lista';
    protected $primaryKey = 'idLista';
    
    protected $fillable = [
        'Ime',
        'Korisnik_idKorisnik',
        'BrojLajk',
        'BrojDislajk'
    ];
}