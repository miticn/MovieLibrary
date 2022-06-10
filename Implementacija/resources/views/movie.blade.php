<!-- Autori: Momcilo Milic 2019/0377, Mateja Milojevic 2019/0382, Nikola Mitic 2017/0110-->
@extends('template')
@section('css')
    <link rel='stylesheet' href='{{ URL::asset('css/style-old.css') }}'>
    <link rel='stylesheet' href='{{ URL::asset('css/library_style.css') }}'>
    <script src='{{ URL::asset('js/rm-comment.js') }}'></script>
@endsection

@section('content')
<div class="content_wrapper">
    <table >
        <tr>
            <td class="library-info" rowspan="2">
                <img class="library-image" src="/IMG/img_film/film{{$film->idFilm}}.jpg"><br><b>{{$film->Naziv}}</b>
                <br>
                <i class="fa {{$trophy}}"></i> {{$score}}%
                <br>
                @auth
                <div class="dugmici">
                    <form name="oceni" action="{{route('oceni', ['indikator' => '0', 'lokacija' => $film->idFilm, 'vrsta' => '1'])}}" method="POST">
                        @csrf
                        @if($film->ocenio() == 1) <input style="background-color: #950750;" type="submit" value="&#128525;">
                        @else <input type="submit" value="&#128525;">
                        @endif
                    </form>
                    <form name="oceni" action="{{route('oceni', ['indikator' => '0', 'lokacija' => $film->idFilm, 'vrsta' => '0'])}}" method="POST">
                        @csrf
                        @if($film->ocenio() == -1) <input style="background-color: #950750;" type="submit" value="&#x1F92E;">
                        @else <input type="submit" value="&#x1F92E;">
                        @endif
                    </form>
                    @if(!(Auth::user()->napravljeneListe)->isEmpty())
                    <form name="sacuvaj" action="{{route('sacuvaj_film', ['lista' => "izabrana" , 'film' => $film->idFilm ])}}" method="POST">
                        @csrf
                        <input type="submit" value="&#128190;">
                        <select name="izabrana" id="bruv">
                            @foreach (Auth::user()->napravljeneListe as $lista)          
                            <option value="{{$lista->idLista}}">{{$lista->Ime}}</option>
                            @endforeach
                        </select>
                    </form>
                    @endif
                </div>
                @endauth
                @guest
                <div class="dugmici">
                    <input style="filter: grayscale(100%);background-color: #808080;" type="submit" value="&#128525;">
                    <input style="filter: grayscale(100%);background-color: #808080;" type="submit" value="&#x1F92E;">
                </div>
                @endguest
                <hr>
                <h3>Opis</h3>
                <hr>
                <p>
                    {{$film->Opis}}
                </p>
                <h3>Detalji o filmu:</h3>
                Režiseri: {{$film->Reziseri}}<br>
                Pisci: {{$film->Pisci}}<br>
                Trajanje filma: {{$film->Trajanje}}<br>
                Datum objavljivanja: {{$film->Datum_Objave}}</p>
                <h3>Uloge</h3>
                <hr>
                <ul>
                    @foreach ($film->glumci as $glumac)
                        <li id ="g{{$glumac->idGlumac}}" class="cast-filmography">{{$glumac->pivot->Ime_uloge}} - <a href="/actor/{{$glumac->idGlumac}}">{{$glumac->Ime}} </a>
                        @auth
                        @if (auth()->user()->isAdmin())
                            <iframe name="nothing-role" style="display:none;"></iframe>
                            <form class="hidden-form" method="POST" action="/roleRemove/{{$film->idFilm}}/{{$glumac->idGlumac}}/"target="nothing-role">
                                @csrf
                        
                                <button class="remove-role" type="submit" onclick="removeFadeOut(this.parentNode.parentNode.id)">X</button>
                            </form>
                        @endif
                        @endauth
                        </li>
                    @endforeach

                    @auth
                        @if (auth()->user()->isAdmin())
                        <li class="add-cast">
                            <form class="hidden-form" method="POST" action="/addRole/{{$film->idFilm}}/-1">
                            @csrf
                            <input class="add-cast" name="Ime_uloge" type="text" placeholder="Ime uloge..." required>
                            <select class="add-cast" name="Glumac" id="glumac" required>
                                @foreach($sviGlumci as $jedanGlumac)
                                <option value="{{$jedanGlumac->idGlumac}}">{{$jedanGlumac->Ime}}</option>
                                @endforeach
                            </select>
                            <button class="remove-role" type="submit">✓</button>
                            </form>

                        </li>
                        @endif
                    @endauth

                </ul>
            </td>
            <td>
                <h3>Žanrovi</h3>
                <ul>
                    @foreach (explode (",", $film->Zanrovi)  as $zanr)
                        <li>{{$zanr}}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        <tr>
            <td class="theatre-links">
                @if ($film->u_bioskopu!=NULL)
                <h3>Dopstupnost u bioskopima</h3>
                <ul>
                    <li><a href="{{$film->u_bioskopu->URL}}">Cineplexx</a></li>
                </ul>
                @endif
            </td>
        </tr>
    </table>
    <hr>
    <table class="comment-table">
        <h3>Komentari</h3>
        @auth
            
        <tr>
            <td class="comment">
                Ostavite komentar:
                <form method="POST" action="/movie/{{$film->idFilm}}/comment">
                    @csrf
                    <br>
                    <div class="comment-box">
                        <textarea id="" cols="30" rows="3" name="tekst" class="comment-box" placeholder="Unesite vaše utiske..."></textarea>
                    </div>
                    <br>
                    <input type="Submit" value="Objavi">
                </form>
            </td>
        </tr>
        @endauth
        @if ($komentari->isEmpty())
            <h4>Nema komentara.</h4>
        @endif
        @foreach ($komentari as $komentar)
            <tr>
                <td class="comment" id="k{{$komentar->idKomentar}}">
                    <a href="/profile/{{$komentar->Korisnik_idKorisnik}}">
                    <img src="/IMG/img_profile/profile{{$komentar->Korisnik_idKorisnik}}.jpg" class="comment-profile-pic"
                    onerror="this.onerror=null; this.src='{{URL::asset('IMG/img_profile/profile_def.jpg')}}'">
                    </a>
                    <h4 class="comment-username">
                        <a href="/profile/{{$komentar->Korisnik_idKorisnik}}" class="comment-username">{{$komentar->getKorisnik->KorisnickoIme}}</a>
                        @auth
                            @if (auth()->user()->isAdmin())
                                <iframe name="nothing" style="display:none;"></iframe>
                                <form class="hidden-form" method="POST" action="/movie/{{$film->idFilm}}/removeComment/{{$komentar->idKomentar}}" target="nothing">
                                    @csrf
                                    <button type="submit" class="remove-comment" onclick="removeFadeOut(this.parentNode.parentNode.parentNode.id)">X</button>
                                </form>
                            @endif
                        @endauth
                    </h4>
                    <hr>
                    <p class="comment-text">
                        {{$komentar->Tekst}}
                    </p>
                    @auth
                    <div class="dugmici">
                        <form name="oceni" action="{{route('oceni', ['indikator' => '2', 'lokacija' => $komentar->idKomentar, 'vrsta' => '1'])}}" method="POST">
                            @csrf
                            @if($komentar->ocenio() == 1) <input style="background-color: #950750;" type="submit" value="&#128525;">
                            @else <input type="submit" value="&#128525;">
                            @endif
                        </form>
                        <form class="like-number">{{$komentar->BrojLajk-$komentar->BrojDislajk}}</form>
                        <form name="oceni" action="{{route('oceni', ['indikator' => '2', 'lokacija' => $komentar->idKomentar, 'vrsta' => '0'])}}" method="POST">
                            @csrf
                            @if($komentar->ocenio() == -1) <input style="background-color: #950750;" type="submit" value="&#x1F92E;">
                            @else <input type="submit" value="&#x1F92E;">
                            @endif
                        </form>
                    </div>
                    @endauth
                    @guest
                    <div class="dugmici">
                        <input style="filter: grayscale(100%);background-color: #808080;" type="submit" value="&#128525;">
                        <form class="like-number">{{$komentar->BrojLajk-$komentar->BrojDislajk}}</form>
                        <input style="filter: grayscale(100%);background-color: #808080;" type="submit" value="&#x1F92E;">
                    </div>
                    @endguest
                </td>

            </tr>
        @endforeach
    </table>
</div>
@endsection