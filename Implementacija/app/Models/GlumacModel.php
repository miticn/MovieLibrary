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
        'BrojLajk',
        'BrojDislajk'
    ];
}