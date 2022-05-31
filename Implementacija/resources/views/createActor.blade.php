@extends('template')
@section('css')
    <link rel='stylesheet' href='{{ URL::asset('css/style-old.css') }}'>
	<link rel='stylesheet' href='{{ URL::asset('css/tempStyle-old.css') }}'>
@endsection

@section('content')
@auth
    @if (auth()->user()->isAdmin())

    <form method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($uspeh))
            <p style="color:greenyellow;">{{$uspeh}}</p>
        @endif
        <table>
            <tr><td>Ime glumca:</td><td><input type='text' name="ime" placeholder="Ime glumca" required></input></td></tr>
            <tr><td>Datum rođenja:</td><td><input type="date" name="datum" required></td></tr>
            <tr><td>Opis:</td><td><input type="textarea" name="opis" required></td></tr>
            <tr><td>Slike glumca:</td><td><input type="file" id="poster" name="poster" accept="image/jpeg"></tr>
            <tr><td colspan="2" align="center"><input type="submit" value="Napravi stranicu glumca"></td></tr>
        </table>
    </form>
    @endif
@endauth
@endsection