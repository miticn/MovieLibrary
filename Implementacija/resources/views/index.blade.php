@extends('template')
@section('content')
<h1>Aktuelni Filmovi:</h1>
		<ul class="new-popular-movies">
			@for ($i = 0; $i < count($filmovi); $i++)
				<li class="new-popular-movies"><a class="new-popular-movies" href="movie/{{$filmovi[$i]->idFilm}}"><img class="movie-banner" src="IMG/Batman-2022.jpg"><br><b>{{$filmovi[$i]->Naziv}}</b><br> <i class="fa {{$trophies[$i]}}"></i> {{$scores[$i]}}% </a></li>
			@endfor	
		</ul>

@endsection