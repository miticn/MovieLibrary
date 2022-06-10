<?php

namespace Tests\Feature;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\KorisnikController;
use App\Models\KorisnikModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class BazicniPreglediTest extends TestCase
{
    public function testOdlazakNaFilm()
    {
        $response = $this->get('movie/1');
        $response->assertViewIs('movie');
    }

    public function testOdlazakNaRegistraciju()
    {
        $response = $this->get('register');
        $response->assertViewIs('register');
    }

    public function testOdlazakNaLogin()
    {
        $response = $this->get('login');
        $response->assertViewIs('login');
    }

    public function testOdlazakNaGlumca()
    {
        $response = $this->get('actor/1');
        $response->assertViewIs('actor');
    }

    public function testOdlazakNaProfil()
    {
        $response = $this->get('profile/1');
        $response->assertViewIs('profile');
    }

    public function testOdlazakNaListu()
    {
        $response = $this->get('lista/1');
        $response->assertViewIs('lista');
    }

    public function testOdlazakNaIndex()
    {
        $response = $this->get('index');
        $response->assertViewIs('index');
    }
}