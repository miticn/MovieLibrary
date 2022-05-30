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
                <h3>Dopstupnost u bioskopima</h3>
                <ul>
                    <li><a href="https://www.cineplexx.rs/movie/betmen/">Cineplexx</a></li>
                </ul>
            </td>
        </tr>
    </table>
    <hr>
    <table class="comment-table">
        <h3>Komentari</h3>
        <tr>
            <td class="comment">
                <a href="profile-notLoggedin.html">
                <img src="profile_images/profile_pic.png" class="comment-profile-pic">
                </a>
                <h4 class="comment-username">
                    <a href="profile-notLoggedin.html" class="comment-username">Marko Markovic</a>
                </h4>
                <hr>
                <p class="comment-text">
                    Sjajan film, <a href="actor.html" class="handle">@Robert Pattinson</a> se jako dobro pokazao u ulozi betmena
                </p>
                <button class="comment-like guest">↑</button>
                78
                <button class="comment-dislike guest">↓</button>
            </td>

        </tr>
        <tr >
            <td class="comment">
                <a href="profile-notLoggedin.html">
                <img src="profile_images/profile_pic_default.jpg" class="comment-profile-pic">
                </a>
                <h4 class="comment-username">
                    <a href="profile-notLoggedin.html" class="comment-username">Username</a>
                </h4>
                <hr>
                <p class="comment-text">
                    Sjajan film, među najboljim od svih betmen filmova
                </p>
                <button class="comment-like guest">↑</button>
                24
                <button class="comment-dislike guest">↓</button>
            </td>
        </tr>
    </table>
</div>
@endsection