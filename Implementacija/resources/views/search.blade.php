@extends('template')
@section('content')
<h1>Rezultati pretrage "Batman":</h1>
		
		<table class="search">
			<tr><th class="search">Ocena</th> <th class="search">Poster</th> <th class="search">Naziv i opis</th></tr>
			<tr class="search "onclick="window.location='movie.html';"><td class="search ocena"><i class="fa fa-trophy gold-trophy"></i> 89%</td> <td class="search poster"><img class="search" src="IMG/Batman-2022.jpg"></td> <td class="search title"><b>THE BATMAN (2022)</b></td> </tr>

		</table>

@endsection