<?php

namespace Tests\Feature;

use App\Http\Controllers\KorisnikController;
use App\Models\KorisnikModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class SvidjanjeINeSvidjanjeTest extends TestCase
{
    public function testSvidjanje(){
        $indikator = 3;
        $lokacija = 1;
        $vrsta = 1;
        $id = 1;

        Auth::shouldReceive('id')->andReturn($id);

        $base = new KorisnikController();
        
        $mockreq = $this->createStub(Request::class);
        $mockreq->indikator = $indikator;
        $mockreq->lokacija = $lokacija;
        $mockreq->vrsta = $vrsta;

        $base->oceni($mockreq);

        //$this->post('oceni', ['indikator' => $indikator, 'lokacija' => $lokacija, 'vrsta' => $vrsta]);

        $this->assertDatabaseHas('lajk_dislajk', ['Korisnik_idKorisnik' => $id, 'indikator' => $indikator, 'lokacija' => $lokacija, 'vrsta' => $vrsta]);

    }
}