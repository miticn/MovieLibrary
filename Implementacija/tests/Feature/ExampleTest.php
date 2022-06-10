<?php

namespace Tests\Feature;

use App\Http\Controllers\KorisnikController;
use App\Models\KorisnikModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test1(){
        $imeToSet = "Novo ime Admina";
        $opisToSet = "Novi opis Admina";
        $idKorisnika = 1;

        $kc = new KorisnikController();
        $mockRequest = $this->createStub(Request::class);
        $mockRequest->Ime = $imeToSet;
        $mockRequest->Opis = $opisToSet;
        Auth::shouldReceive('id')->andReturn($idKorisnika);

        $kc->izmeni_submit($mockRequest);

        $korisnik = KorisnikModel::find($idKorisnika);

        $this->assertEquals($korisnik->Ime,$imeToSet);
        $this->assertEquals($korisnik->Opis,$opisToSet);
    }
}
