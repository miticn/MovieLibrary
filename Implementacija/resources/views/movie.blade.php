@extends('template')
@section('content')
<div class="content_wrapper">
    <table >
        <tr>
            <td class="library-info" rowspan="2">
                <img class="library-image" src="/IMG/img_film/film{{$film->idFilm}}.jpg"><br><b>{{$film->Naziv}}</b>
                <br>
                <i class="fa {{$trophy}}"></i> {{$score}}%
                <br>
                <button class="like guest">↑</button>
                <button class="dislike guest">↓</button>
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
                <td class="comment">
                    <a href="/profile/{{$komentar->Korisnik_idKorisnik}}">
                    <img src="/IMG/img_profile/profile{{$komentar->Korisnik_idKorisnik}}.png" class="comment-profile-pic">
                    </a>
                    <h4 class="comment-username">
                        <a href="/profile/{{$komentar->Korisnik_idKorisnik}}" class="comment-username">{{$komentar->getKorisnik->Ime}}</a>
                    </h4>
                    <hr>
                    <p class="comment-text">
                        {{$komentar->Tekst}}
                    </p>
                    <button class="comment-like guest">↑</button>
                    78
                    <button class="comment-dislike guest">↓</button>
                </td>

            </tr>
        @endforeach
    </table>
</div>
@endsection