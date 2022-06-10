<?php

namespace Tests\Feature;

use App\Http\Controllers\KorisnikController;
use App\Models\KorisnikModel;
use App\Models\ListaModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class KontrollerMatTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function test_izmeni(){
        $idKorisnika = 1;
        $user = KorisnikModel::find($idKorisnika);
        $response = $this->actingAs($user)->post('/izmeni');

        $response->assertSuccessful();
        $response->assertViewIs('izmeni');
    }
	public function test_izmeni_submit(){//fali test za fajl upload
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
    
    public function test_napravi_listu(){
        $idKorisnika = 1;
        $imeListe = "Ime nove liste";

        $mockRequest = $this->createMock(Request::class);
        $mockRequest->Ime = $imeListe;

        $user = KorisnikModel::find($idKorisnika);
        $response= $this->actingAs($user)->from('profile')->post('/napravi_listu', [
            'Ime' => $imeListe,
        ]);
        $response->assertRedirect('profile');

        $lista = ListaModel::where('Ime',$imeListe)->where('Korisnik_idKorisnik',$idKorisnika)->first();

        $this->assertEquals($idKorisnika,$lista->Korisnik_idKorisnik);
        $this->assertEquals($imeListe,$lista->Ime);
    }
    public function oceni_test(){
        $mockRequest = $this->createMock(Request::class);
        
    }
    public function test_sacuvaj_film(){//Nema proveru za usera

        $kc = new KorisnikController();
        $mockRequest = $this->createMock(Request::class);
        $kc->sacuvaj_film($mockRequest);

    }
    public function test_zaboravi_film(){//Nema proveru za usera
        $kc = new KorisnikController();
        $mockRequest = $this->createMock(Request::class);
        $kc->sacuvaj_film($mockRequest);
    }
    public function test_sacuvaj_listu_i_zaboravi_listu(){
        $idListe = 7;
        $idKorisnika = 1;
        Auth::shouldReceive('id')->andReturn($idKorisnika);
        $kc = new KorisnikController();
        $mockRequest = $this->createMock(Request::class);
        $mockRequest->id = $idListe;
        $kc->sacuvaj_listu($mockRequest);

        $this->assertDatabaseHas('cuva_listu', ['Korisnik_id_cuva' => $idKorisnika, 'Lista_id_cuvana' => $idListe]);

        $kc->zaboravi_listu($mockRequest);
        $this->assertDatabaseMissing('cuva_listu', ['Korisnik_id_cuva' => $idKorisnika, 'Lista_id_cuvana' => $idListe]);
    }

    public function test_sacuvaj_korisnika_i_zaboravi_korisnika(){
        $idCuvan = 1;
        $idCuva = 2;
        Auth::shouldReceive('id')->andReturn($idCuva);
        $kc = new KorisnikController();
        $mockRequest = $this->createMock(Request::class);
        $mockRequest->id = $idCuvan;
        $kc->sacuvaj_korisnika($mockRequest);

        $this->assertDatabaseHas('cuva_korisnika', ['idCuva' => $idCuva, 'idCuvan' => $idCuvan ]);

        $kc->zaboravi_korisnika($mockRequest);
        $this->assertDatabaseMissing('cuva_korisnika', ['idCuva' => $idCuva, 'idCuvan' => $idCuvan ]);
    
    }
}
