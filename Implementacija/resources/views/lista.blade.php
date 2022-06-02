<!-- Autori: Mateja Milojevic 2019/0382-->
@extends('template')
@section('content')

<table class="prikaz_liste">
    <tr>
        <td>{{$lista->Ime}} by<br>{{$lista->autor()}}</td>
    </tr>
@foreach ($lista->cuva_film as $film)
    <tr><td style="border:5px solid black;">
        <a href="{{route('movie', ['id' => $film->idFilm])}}">
            {{$film->Naziv}}
            <div class="background_movie"style="background-image: url('{{URL::asset('IMG/img_film/film'.$film->idFilm.'.jpg')}}')">
            @if($lista->Korisnik_idKorisnik == auth()->id())
                <form style="margin-left: 100%;" name="zaboravi_film" action="{{route('zaboravi_film', ['lista' => $lista->idLista, 'film' => $film->idFilm])}}" method="POST">
                @csrf<input type="submit" value="&#10006;"></form></div></a>
            @endif
    </td></tr>
@endforeach
</table>

@endsection