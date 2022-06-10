<?php

namespace Tests\Feature;

use App\Http\Controllers\KorisnikController;
use App\Models\KorisnikModel;
use App\Models\ListaModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class ListeCuvanjaIzmenaProfilaTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function test_izmeni(){
        $idKorisnika = 1;
        $user = KorisnikModel::find($idKorisnika);
        $response = $this->actingAs($user)->get('/izmeni');

        $response->assertSuccessful();
        $response->assertViewIs('izmeni');
    }
	public function test_izmeni_submit(){
        $imeToSet = "Novo ime Admina";
        $opisToSet = "Novi opis Admina";
        $idKorisnika = 1;

        $user = KorisnikModel::find($idKorisnika);

        $response= $this->actingAs($user)->from('profile',['id' =>$idKorisnika])->post('/izmeni_submit', [
            'Ime' => $imeToSet,
            'Opis' => $opisToSet
        ]);
        $response->assertRedirect('profile/1');
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
    public function test_sacuvaj_film_zaboravi_film(){
        $idKorisnika = 1;
        $filmId = 1;
        $listId = 1;
        $listId_block2 = 2;
        Auth::shouldReceive('id')->andReturn($idKorisnika);
        $kc = new KorisnikController();
        $mockRequest = $this->createMock(Request::class);
        $mockRequest->film= $filmId;
        $mockRequest->izabrana = $listId;

        $kc->sacuvaj_film($mockRequest);
        $this->assertDatabaseHas('u_listi', ['Lista_idLista' => $listId, 'Film_idFilm' => $filmId]);


        $mockRequest->lista = $listId;
        $kc->zaboravi_film($mockRequest);

        $this->assertDatabaseMissing('u_listi', ['Lista_idLista' => $listId, 'Film_idFilm' => $filmId]);


        $mockRequest->izabrana = $listId_block2;
        $kc->sacuvaj_film($mockRequest);
        $this->assertDatabaseMissing('u_listi', ['Lista_idLista' => $listId_block2, 'Film_idFilm' => $filmId]);

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
