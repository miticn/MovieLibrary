<?php

namespace Tests\Feature;

use App\Http\Controllers\GostController;
use App\Models\KorisnikModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class AutorizacijaTest extends TestCase
{

    public function testUspesnaAutorizacija(){
        $KorisnickoIme = 'alanrickman';
        $Sifra = 'alan123';

        $this->post('/login_submit', [
            'KorisnickoIme' => $KorisnickoIme,
            'Sifra' => $Sifra
        ]);
        $this->assertAuthenticated();
    }

    /**
     * @dataProvider nedostajuKredencijali
     */
    public function testNedostajuKredencijali($podaci){
        $this->post('/login_submit', $podaci);

        $this->assertGuest();
    }

    public function nedostajuKredencijali()
    {
        return [
                [
                    ['KorisnickoIme' => '',
                    'Sifra' => 'alan123']
                ],
                [
                    ['KorisnickoIme' => 'alan123',
                    'Sifra' => '']
                ]
            ];
    }

        /**
     * @dataProvider pogresniKredencijali
     */
    public function testPogresniKredencijali($podaci){
        $this->post('/login_submit', $podaci);

        $this->assertGuest();
    }

    public function pogresniKredencijali()
    {
        return [
                [
                    ['KorisnickoIme' => 'alan',
                    'Sifra' => 'alan123']
                ],
                [
                    ['KorisnickoIme' => 'alan123',
                    'Sifra' => 'alan']
                ]
            ];
    }
}