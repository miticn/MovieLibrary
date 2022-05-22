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
        <td #test>
            <table  id="up">
                <tr id="up"><td>
                    <p>{{$profile->Ime}}</p>
                </td></tr>
                <tr><td id="down">
                    <p>{{$profile->Opis}}</p>
                </td></tr>
            </table>
        </td>
    </tr>
</table>

@endsection