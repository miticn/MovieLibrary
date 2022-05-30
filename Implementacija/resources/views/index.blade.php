@extends('template')
@section('content')
		<div class="row">
			<div class="col-sm-12">
				<h1>Aktuelni Filmovi:</h1>
			</div>
		</div>
		@for ($j =0; $j<3; $j++)
			<div class="row">
				@for ($i = $j*6; $i < ((count($filmovi)<($j+1)*6)?count($filmovi):($j+1)*6); $i++)
					<div class="col-sm-2">
						<a class="new-popular-movies" href="movie/{{$filmovi[$i]->idFilm}}">
							<img class="movie-banner" src="IMG/{{$filmovi[$i]->idFilm}}.jpg"><br>
							<b>{{$filmovi[$i]->Naziv}}</b><br> 
							<i class="fa {{$trophies[$i]}}"></i> {{$scores[$i]}}% 
						</a>
					</div>
				@endfor	
			</div>
		@endfor
		

@endsection