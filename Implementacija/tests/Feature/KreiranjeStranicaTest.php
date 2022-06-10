<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\KorisnikModel;
use App\Models\FilmModel;
use App\Models\GlumacModel;
use App\Http\Controllers\KorisnikController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KreiranjeStranicaTest extends TestCase
{
    public function test_create()
    {
        $admin = KorisnikModel::find(1);

        $response = $this->actingAs($admin)->get('/create');

        $response->assertStatus(200);
    }

    public function test_createPageActor()
    {
        $admin = KorisnikModel::find(1);

        $response = $this->actingAs($admin)->get('/createActor');

        $response->assertStatus(200);
    }

    public function test_createPageMovie()
    {
        $admin = KorisnikModel::find(1);
        $response = $this->actingAs($admin)->get('/createMovie');

        $response->assertStatus(200);
    }

    public function test_createMovie()
    {
        $idKorisnika = 1;
        $admin = KorisnikModel::find(1);
        $kc = new KorisnikController();
        $zanr = 'zanr';
        $mockRequest = $this->createMock(Request::class);
        Auth::shouldReceive('id')->andReturn($idKorisnika);
        $mockRequest->expects($this->any())->method("user")->willReturn($admin);
        $mockRequest->ime = 'naziv';
        $mockRequest->opis = 'neki opis';
        $mockRequest->reziseri = 'reziser';
        $mockRequest->pisci = 'pisac';
        $mockRequest->zanrovi = 'zanr';
        $mockRequest->datum = '2000/1/1';
        $mockRequest->trajanje = '2:00';

        $kc->createMovie($mockRequest);
        $film = FilmModel::where('Naziv', 'naziv')->first();
        $this->assertEquals($film->Reziseri, 'reziser');
    }

    public function test_createActor()
    {
        $idKorisnika = 1;
        $admin = KorisnikModel::find(1);
        $kc = new KorisnikController();
        $zanr = 'zanr';
        $mockRequest = $this->createMock(Request::class);
        Auth::shouldReceive('id')->andReturn($idKorisnika);
        $mockRequest->expects($this->any())->method("user")->willReturn($admin);
        $mockRequest->ime = 'ime';
        $mockRequest->opis = 'neki opis';
        $mockRequest->datum = '2000/1/1';

        $kc->createActor($mockRequest);
        $glumac = GlumacModel::where('Ime', 'ime')->first();
        $this->assertEquals($glumac->Ime, 'ime');
    }
}
