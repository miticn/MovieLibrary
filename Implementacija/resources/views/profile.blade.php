@extends('template')
@section('content')

<table class="profile">
    <tr>
        <td>
            <div>
                <img src="{{URL::asset('IMG/img_profile/profile'.$profile->idKorisnik.'.png')}}"
            onerror="this.onerror=null; this.src='{{URL::asset('IMG/img_profile/profile_def.jpg')}}'">
            </div>
        </td>
        <td>
            <table>
                <tr><td>
                    <p id="up">{{$profile->Ime}}</p>
                </td></tr>
                <tr><td>
                    <p id="down">{{$profile->Opis}}</p>
                </td></tr>
            </table>
        </td>
    </tr>
</table>

@endsection