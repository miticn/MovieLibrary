@extends('template')
@section('content')

<form name='login_form' action="{{route('login_submit')}}" method='POST'>

    <table class="login_form">
        <tr>
            <td>Korisnicko ime: </td>
            <td><input type="text" placeholder="Korisnicko ime ili email" name="KorisnickoIme"></td>
        </tr>
        <tr>
            <td>Sifra: </td>
            <td><input type="password" placeholder="********" name="Sifra"></td>
        </tr>
        <tr id="prijavi_se">
            <td	colspan="2"><input type="submit" value="Prijavi se"></td>
        </tr>
    </table>

</form>

@endsection