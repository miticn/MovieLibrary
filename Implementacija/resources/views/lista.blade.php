@extends('template')
@section('content')

<table class="prikaz_liste">
    <tr>
        <td>{{$lista->Ime}} by<br>{{$lista->autor()}}</td>
    </tr>
@foreach ($lista->cuva_film as $film)
    <tr><td style="border:5px solid black;">
        <a href="/">
            <div>{{$film->Naziv}}</div>
            <div class="background_movie"style="background-image: url('{{URL::asset('IMG/img_film/film'.
            $film->idFilm.'.jpg')}}')"></div></a>
    </td></tr>
@endforeach
</table>

@endsection