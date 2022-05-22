@extends('template')
@section('content')
<h1>Aktuelni Filmovi:</h1>
		<ul class="new-popular-movies">
			@foreach ($filmovi as $film)
				@php
					$score = round($film->BrojLajk/($film->BrojLajk+$film->BrojDislajk)*100);
					if($score<50){
						$trophy = 'fa-recycle trash';
					}else if ($score>=50 && $score<66){
						$trophy = 'fa-trophy bronze-trophy';
					}else if ($score>=66 && $score<82){
						$trophy = 'fa-trophy silver-trophy';
					}else if ($score>=82){
						$trophy = 'fa-trophy gold-trophy';
					}
				@endphp
				
				<li class="new-popular-movies"><a class="new-popular-movies" href="movie/{{$film->idFilm}}"><img class="movie-banner" src="IMG/Batman-2022.jpg"><br><b>{{$film->Naziv}}</b><br> <i class="fa {{$trophy}}"></i> {{$score}}% </a></li>
			@endforeach
		</ul>

@endsection