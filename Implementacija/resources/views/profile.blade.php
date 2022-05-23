@extends('template')
@section('content')

<table class="profile">
    <tr>
        <td class="profile_slika">
            <div>
                <img class="profile_slika" src="{{URL::asset('IMG/img_profile/profile'.$profile->idKorisnik.'.png')}}"
            onerror="this.onerror=null; this.src='{{URL::asset('IMG/img_profile/profile_def.jpg')}}'">
            </div>
        </td>
        <td>
            <table id="ime_opis">
                <tr id="profile_ime"><td>
                    {{$profile->Ime}}
                </td></tr>
                <tr id="profile_opis"><td>
                    {{$profile->Opis}}
                </td></tr>
            </table>
        </td>
    </tr>
</table>

<table class="profile" id="bez_margine"><tr>
    <td id="liste">
        <ul style="list-style-type:none;">
            <li>Coffee</li>
            <li>Tea</li>
            <li>Milk</li>
        </ul>  






    </td>
    <td id="profili">
        <div>
            bruh
        </div>
    </td>
</tr></table>

@endsection