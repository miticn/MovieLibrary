<!-- Autor: Momcilo Milic, Mateja Milojevic-->
@extends('template')
@section('registerStyles')
<link rel="stylesheet" href="{{URL::asset('css/tempStyle-old.css')}}">
@endsection

@section('content')
<form>
    <table class = "register">
        <tr>
            <td>Unesite korisnicko ime: </td>
            <td>
                <input type='text' placeholder="Korisnicko ime" required>
            </td>
        </tr>
        <tr>
            <td>Unesite lozinku: </td>
            <td>
                <input type='password' placeholder="Lozinka" required>
            </td>
        </tr>
        <tr>
            <td>Ponovite lozinku: </td>
            <td>
                <input type='password' placeholder="Ponovite lozinku" required>
            </td>
        </tr>
        <tr>
            <td>Unesite adresu e-poste: </td>
            <td>
                <input type='text' placeholder="Korisnicko ime" required>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="checkbox" id="terms"required>
                <label for="terms">Prihvatam uslove koriscenja.</label>
            </td>
        </tr>
        <tr>
            <td align="center">
                <input type="submit" value="Registruj se">
            </td>
            <td align="center">
                <a href=login.html><input type="button" class="boring" value="Vec imam nalog"></input></a>
            </td>
        </tr>
    </table>
</form>
@endsection
