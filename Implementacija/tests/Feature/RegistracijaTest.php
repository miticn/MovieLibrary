<?php

namespace Tests\Feature;

use App\Http\Controllers\GostController;
use App\Models\KorisnikModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class RegistracijaTest extends TestCase
{
    public function testUspesnaRegistracija(){

        $this->markTestSkipped('Preskoceno: Da ne bi brisao stalno novog korisnika.');
        
        $KorisnickoIme = 'testkorisnik';
        $Sifra = 'testsifra';
        $PonovljenaSifra = 'testsifra';
        $ePosta = 'test@gmail.com';
        $Ime = 'test testic';
        $uslovi = 'on';

        $this->assertDatabaseMissing('korisnik', ['KorisnickoIme' => $KorisnickoIme]);

        $this->post('/register_submit', [
            'KorisnickoIme' => $KorisnickoIme,
            'Sifra' => $Sifra,
            'PonovljenaSifra' => $PonovljenaSifra,
            'ePosta' => $ePosta,
            'Ime' => $Ime,
            'uslovi' => $uslovi
        ]);

        $this->assertDatabaseHas('korisnik', ['KorisnickoIme' => $KorisnickoIme]);
    }

    /**
     * @dataProvider izostavljenaPolja
     */
    public function testIsostavljeniPodaci($podaci, $greska){

        $this->post('/register_submit', $podaci)->assertSessionHasErrors($greska);

    }

    public function izostavljenaPolja()
    {
        return [
            [
                ['KorisnickoIme' => '',
                'Sifra' => 'testsifra',
                'PonovljenaSifra' => 'testsifra',
                'ePosta' => 'test@test.tst',
                'Ime' => 'test testic',
                'uslovi' => 'on'],
                ['KorisnickoIme']
            ],
            [
                ['KorisnickoIme' => 'testkorisnik',
                'Sifra' => '',
                'PonovljenaSifra' => 'testsifra',
                'ePosta' => 'test@test.tst',
                'Ime' => 'test testic',
                'uslovi' => 'on'],
                ['Sifra']
            ],
            [
                ['KorisnickoIme' => 'testkorisnik',
                'Sifra' => 'testsifra',
                'PonovljenaSifra' => '',
                'ePosta' => 'test@test.tst',
                'Ime' => 'test testic',
                'uslovi' => 'on'],
                ['PonovljenaSifra']
            ],
            [
                ['KorisnickoIme' => 'testkorisnik',
                'Sifra' => 'testsifra',
                'PonovljenaSifra' => 'testsifra',
                'ePosta' => '',
                'Ime' => 'test testic',
                'uslovi' => 'on'],
                ['ePosta']
            ],
            [
                ['KorisnickoIme' => 'testkorisnik',
                'Sifra' => 'testsifra',
                'PonovljenaSifra' => 'testsifra',
                'ePosta' => 'test@test.tst',
                'Ime' => '',
                'uslovi' => 'on'],
                ['Ime']
            ],
            [
                ['KorisnickoIme' => 'testkorisnik',
                'Sifra' => 'testsifra',
                'PonovljenaSifra' => 'testsifra',
                'ePosta' => 'test@test.tst',
                'Ime' => 'test testic',
                'uslovi' => ''],
                ['uslovi']
            ]
        ];
    }

    public function testZauzetoIme()
    {       
        $KorisnickoIme = 'testkorisnik';
        $Sifra = 'testsifra';
        $PonovljenaSifra = 'testsifra';
        $ePosta = 'test@gmail.com';
        $Ime = 'test testic';
        $uslovi = 'on';
        
        $this->assertDatabaseHas('korisnik', ['KorisnickoIme' => $KorisnickoIme]);

        $this->post('/register_submit', [
            'KorisnickoIme' => $KorisnickoIme,
            'Sifra' => $Sifra,
            'PonovljenaSifra' => $PonovljenaSifra,
            'ePosta' => $ePosta,
            'Ime' => $Ime,
            'uslovi' => $uslovi
        ]);
        $this->assertGuest();
    }

    public function testNeispravanMail()
    {
        $this->markTestSkipped('Preskoceno: Nije implementirano.');
    }
}
