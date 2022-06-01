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
                    <form name="sacuvaj" action="{{route('sacuvaj_film', ['lista' => "izabrana" , 'film' => $film->idFilm ])}}" method="POST">
                        @csrf
                        <input type="submit" value="&#128190;">
                        <select name="izabrana" id="bruv">
                            @foreach (Auth::user()->napravljeneListe as $lista)          
                            <option value="{{$lista->idLista}}">{{$lista->Ime}}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                @endauth
                <hr>
                <h3>Opis</h3>
                <hr>
                <p>
                    {{$film->Opis}}
                </p>
                <h3>Uloge</h3>
                <hr>
                <ul>
                    @foreach ($film->glumci as $glumac)
                        <li class="cast-filmography">{{$glumac->pivot->Ime_uloge}} - <a href="/actor/{{$glumac->idGlumac}}">{{$glumac->Ime}} <a></li>
                    @endforeach

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
                <td class="comment" id="{{$komentar->idKomentar}}">
                    <a href="/profile/{{$komentar->Korisnik_idKorisnik}}">
                    <img src="/IMG/img_profile/profile{{$komentar->Korisnik_idKorisnik}}.png" class="comment-profile-pic">
                    </a>
                    <h4 class="comment-username">
                        <a href="/profile/{{$komentar->Korisnik_idKorisnik}}" class="comment-username">{{$komentar->getKorisnik->Ime}}</a>
                        @auth
                            @if (auth()->user()->isAdmin())
                                <iframe name="nothing" style="display:none;"></iframe>
                                <form method="POST" action="/movie/{{$film->idFilm}}/removeComment/{{$komentar->idKomentar}}" target="nothing">
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
                    <form name="oceni" action="{{route('oceni', ['indikator' => '2', 'lokacija' => $komentar->idKomentar, 'vrsta' => '0'])}}" method="POST">
                        @csrf
                        @if($komentar->ocenio() == -1) <input style="background-color: #950750;" type="submit" value="&#x1F92E;">
                        @else <input type="submit" value="&#x1F92E;">
                        @endif
                    </form>
                    <form class="lajkovi">{{$komentar->BrojLajk-$komentar->BrojDislajk}}</form>
                    </div>
                    @endauth
                </td>

            </tr>
        @endforeach
    </table>
</div>
@endsection