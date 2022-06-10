<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Controllers\KorisnikController;
use Illuminate\Support\Facades\Auth;
use App\Models\KorisnikModel;
use App\Models\KomentarModel;

class BrisanjeKomentaraTest extends TestCase
{
    public function test_removeComment(){
        $idKorisnika = 1;
        $admin = KorisnikModel::find($idKorisnika);
        $mockRequest = $this->createMock(Request::class);
        Auth::shouldReceive('id')->andReturn($idKorisnika);
        $mockRequest->expects($this->any())->method("user")->willReturn($admin);

        $kc = new KorisnikController();
        $kc->removeComment($mockRequest, 1, 1);
        $comment = KomentarModel::find(1);
        $this->assertEmpty($comment);
    }
}
