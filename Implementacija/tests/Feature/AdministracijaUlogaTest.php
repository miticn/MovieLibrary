<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\KorisnikModel;
use App\Http\Controllers\KorisnikController;
use App\Models\FilmModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministracijaUlogaTest extends TestCase
{
   public function test_addRole()
   {
       $idKorisnika = 1;
       $admin = KorisnikModel::find(1);
       $kc = new KorisnikController();
       $mockRequest = $this->createMock(Request::class);
       Auth::shouldReceive('id')->andReturn($idKorisnika);
       $mockRequest->expects($this->any())->method("user")->willReturn($admin);
       $mockRequest->Ime_uloge = 'uloga_test';

       $kc->addRole($mockRequest, 2, 61);
       $film = FilmModel::find(2);
       $glumci = $film->glumci;
       foreach ($glumci as $glumac) {
           if($glumac->idGlumac == 61) {
               $this->assertTrue($glumac->idGlumac == 61);
           }
       }
   }

   public function test_removeRole()
   {
       $idKorisnika = 1;
       $admin = KorisnikModel::find(1);
       $kc = new KorisnikController();
       $mockRequest = $this->createMock(Request::class);
       Auth::shouldReceive('id')->andReturn($idKorisnika);
       $mockRequest->expects($this->any())->method("user")->willReturn($admin);

       $kc->removeRole($mockRequest, 1, 1);
       $film = FilmModel::find(1);
       $glumci = $film->glumci;
       $nema = true;
       foreach ($glumci as $glumac) {
           if($glumac->idGlumac == 1) {
               $nema = false;
           }
       }
       $this->assertTrue($nema);
   }
}
