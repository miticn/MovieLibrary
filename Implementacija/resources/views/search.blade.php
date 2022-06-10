<!-- Autor: Nikola Mitic 17/0110-->
@extends('template')

@section('css')
    <link rel='stylesheet' href='{{ URL::asset('css/style-old.css') }}'>
@endsection

@section('content')
<div class="row">
<h1>Rezultati pretrage "{{$naziv}}":</h1>
</div>	<h2>Pronađeni filmovi:</h2>
		<table class="search">
			<tr>
				<th class="search">Ocena</th> 
				<th class="search">Poster</th> 
				<th class="search">Naziv i opis</th>
			</tr>
			@for ($i = 0; $i < count($filmovi); $i++)
				<tr class="search" onclick="window.location='movie/{{$filmovi[$i]->idFilm}}';">
					<td class="search ocena"><i class="fa {{$stFilmovi['trophies'][$i]}}"></i> {{$stFilmovi['scores'][$i]}}%</td>
					<td class="search poster"><img class="search" src="IMG/img_film/film{{$filmovi[$i]->idFilm}}.jpg"></td> 
					<td class="search title"><b>{{$filmovi[$i]->Naziv}}</b></td> 
				</tr>
			@endfor
		</table>
		<h2>Pronađeni glumci:</h2>
		<table class="search">
			<tr>
				<th class="search">Ocena</th> 
				<th class="search">Poster</th> 
				<th class="search">Naziv i opis</th>
			</tr>
			@for ($i = 0; $i < count($glumci); $i++)
				<tr class="search" onclick="window.location='actor/{{$glumci[$i]->idGlumac}}';">
					<td class="search"><i class="fa {{$stGlumci['trophies'][$i]}}"></i> {{$stGlumci['scores'][$i]}}%</td>
					<td class="search poster"><img class="search" src="IMG/img_actor/actor{{$glumci[$i]->idGlumac}}.jpg"></td> 
					<td class="search"><b>{{$glumci[$i]->Ime}}</b></td> 
				</tr>
			@endfor
		</table>

		<h2>Pronađeni korisnici:</h2>
		<table class="search">
			<tr>
				<th class="search">Korisničko Ime</th> 
				<th class="search">Slika</th> 
				<th class="search">Ime</th>
				<th class="search">Opis</th>
			</tr>
			@foreach($korisnici as $korisnik)
				<tr class="search" onclick="window.location='profile/{{$korisnik->idKorisnik}}';">
					<td class="search">{{$korisnik->KorisnickoIme}}</td>
					<td class="search poster"><img class="search" src="IMG/img_profile/profile{{$korisnik->idKorisnik}}.jpg"></td> 
					<td class="search"><b>{{$korisnik->Ime}}</b></td>
					<td class="search"><b>{{$korisnik->Opis}}</b></td> 
				</tr>
			@endforeach
		</table>

@endsection