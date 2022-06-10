<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\FilmModel;
use App\Http\Controllers\BaseController;
use App\Models\KorisnikModel;

class PregledPocetneStraneTest extends TestCase
{
    public function test_movie()
    {
        $response = $this->get('/movie/1');
        $response->assertStatus(200);
    }

    public function test_actor()
    {
        $response = $this->get('/actor/1');
        $response->assertStatus(200);
    }
}
