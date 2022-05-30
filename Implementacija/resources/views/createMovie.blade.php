@extends('template')
@section('content')
@auth
    @if (auth()->user()->isAdmin())

    <form>
        <table class="createmovie">
					<tr> <td>Naziv filma: </td><td><input type='text' placeholder="Naziv filma" required></input></td> </tr>
					<tr> <td>Poster filma:</td> <td><input type="file" id="poster" name="Izaberi sliku"></input></td></tr>
					<tr> <td>Datum objavljivanja:</td> <td><input type="date" required></td></tr>
					<tr> <td>Trajanje filma:</td><td><input type="time" value="00:00" required></td> </tr>
					<tr> <td>Režiseri:</td> <td><input type='text' placeholder="Imena režisera" required></input></td></tr>
					<tr> <td>Pisci:</td> <td><input type='text' placeholder="Imena pisaca" required> </input></td></tr>
					<tr> <td>Opis filma:</td> <td><input type='textarea' placeholder="Opis filma" required> </input></td></tr>
					<tr> <td>Žanrovi filma:</td> <td><input type='text' placeholder="žanrovi" required> </input></td></tr>
					<tr> <td>Video platforme:</td></tr>
					<tr>
						<td><input type='checkbox' value="Netflix">Netflix</input></td>
						<td><input type='checkbox' value="HBO GO">HBO GO</input></td>
					</tr>
					<tr>
						<td><input type='checkbox' value="Amazon Prime">Amazon Prime</input></td>
						<td><input type='checkbox' value="Disney Plus">Disney Plus</input></td>
					</tr>
					<tr> <td>Bioskopi:</td></tr>
					<tr>
						<td><input type='checkbox' value="Cineplex">Cineplex</input></td>
						<td><input type='checkbox' value="CineStar">CineStar</input></td>
					</tr>
					<tr>
						<td><input type='checkbox' value="Tuckwood">Tuckwood</input></td>
					</tr>
          <tr><td colspan="2" align="center"><a href=movie-loggedin.html><input type="button" value="Napravi film"></a></td></tr>

        </table>
    </form>
    @endif
@endauth
@endsection