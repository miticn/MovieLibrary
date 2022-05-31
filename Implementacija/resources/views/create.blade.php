@extends('template')
@section('css')
    <link rel='stylesheet' href='{{ URL::asset('css/style-old.css') }}'>
    <link rel='stylesheet' href='{{ URL::asset('css/tempStyle-old.css') }}'>
@endsection

@section('content')
@auth
    @if (auth()->user()->isAdmin())

    <table>
        <tr>
            <td align="center">
                <a href={{route('createPageMovie')}}><input type="button" value="Kreiraj stranicu filma"></input></a>
                <a href={{route('createPageActor')}}><input type="button" value="Kreiraj stranicu glumca"></input></a>
            </td>
        </tr>
    </table>
    @endif
@endauth
@endsection