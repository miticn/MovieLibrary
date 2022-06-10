<!-- Autori: Momcilo Milic 2019/0377, Mateja Milojevic 2019/0382 -->
@extends('template')
@section('content')
<form name='login_form' action="{{route('login_submit')}}" method='POST'>
    @csrf
    <table class="login_form box">
        <tr>
            <td class="levo top">Korisnicko ime: </td>
            <td class="levo top desno"><input type="text" placeholder="Korisnicko ime ili email" name="KorisnickoIme" value="{{old('KorisnickoIme')}}"></td>
        </tr>
        <tr>
            <td class="levo"></td>
            @error('KorisnickoIme')
                <td class="error">{{$message}}</td>
            @enderror
        </tr>
        <tr>
            <td class="levo">Korisnicka sifra: </td>
            <td class="levo desno"><input type="password" placeholder="********" name="Sifra"></td>
        </tr>
        <tr>
            <td class="levo"></td>
            @error('Sifra')
                <td class="error">{{$message}}</td>
            @enderror
            @if(session('status'))
                <td class="error">{{session('status')}}</td>
            @endif
        </tr>
        <tr id="prijavi_se">
            <td class="levo bottom"><a href="{{route('register')}}">Registruj se</td>
            <td class="bottom"><input type="submit" value="Prijavi se"></td>
        </tr>
    </table>
</form>
@endsection