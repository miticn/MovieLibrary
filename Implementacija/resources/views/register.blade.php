<!-- Autor: Momcilo Milic, Mateja Milojevic-->
@extends('template')
@section('registerStyles')
<link rel="stylesheet" href="{{URL::asset('css/tempStyle-old.css')}}">
@endsection

@section('content')
<form action="{{route('register_submit')}}" method='POST'>
    @csrf
    <table class = "register">
        <tr>
            <td>Unesite korisnicko ime: </td>
            <td>
                <input type='text' placeholder="Korisnicko ime" name="KorisnickoIme" value="{{old('KorisnickoIme')}}">
            </td>
        </tr>
        <tr class="levoReg">
            <td></td>
            @error('KorisnickoIme')
                <td class="error">{{$message}}</td>
            @enderror
        </tr>
        <tr>
            <td>Unesite lozinku: </td>
            <td>
                <input type='password' placeholder="Lozinka" name="Lozinka">
            </td>
        </tr>
        <tr class="levoReg">
            <td></td>
            @error('Lozinka')
                <td class="error">{{$message}}</td>
            @enderror
        </tr>
        <tr>
            <td>Ponovite lozinku: </td>
            <td>
                <input type='password' placeholder="Ponovite lozinku" name="PonovljenaLozinka">
            </td>
        </tr>
        <tr class="levoReg">
            <td></td>
            @error('PonovljenaLozinka')
                <td class="error">{{$message}}</td>
            @enderror
            @if(session('status'))
                <td class="error">{{session('status')}}</td>
            @endif
        </tr>
        <tr>
            <td>Unesite adresu e-poste: </td>
            <td>
                <input type='text' placeholder="exapmle@email.com" name="ePosta" value="{{old('ePosta')}}">
            </td>
        </tr>
        <tr class="levoReg">
            <td></td>
            @error('ePosta')
                <td class="error">{{$message}}</td>
            @enderror
        </tr>
        <tr>
            <td>Unesite ime i prezime: </td>
            <td>
                <input type='text' placeholder="Ime" name="Ime" value="{{old('Ime')}}">
            </td>
        </tr>
        <tr class="levoReg">
            <td></td>
            @error('Ime')
                <td class="error">{{$message}}</td>
            @enderror
        </tr>
        <tr>
            <td colspan="2">
                <input type="checkbox" id="terms" name="uslovi">
                <label for="terms">Prihvatam uslove koriscenja.</label>
            </td>
        </tr>
        <tr class="levoReg">
            <td></td>
            @error('uslovi')
                <td class="error">{{$message}}</td>
            @enderror
        </tr>
        <tr>
            <td align="center">
                <input type="submit" value="Registruj se">
            </td>
            <td align="center">
                <a href="{{route('login')}}"><input type="button" class="boring" value="Vec imam nalog"></input></a>
            </td>
        </tr>
    </table>
</form>
@endsection
