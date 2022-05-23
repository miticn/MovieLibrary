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
                <tr id="profile_ime">
                    <td>
                        {{$profile->Ime}}
                    </td>
                    <td>
                        @if ($profile->idKorisnik == Auth::id())
                            izmeni
                        @else
                        <form name="sacuvaj" action="{{route('sacuvaj_korisnika', ['id' => $profile->idKorisnik])}}"
                            method="GET"><input type="submit" value="sacuvaj"></form>
                        @endif
                    </td>
                </tr>
                <tr id="profile_opis"> 
                    <td>
                        {{$profile->Opis}}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table class="profile" id="bez_margine"><tr>
    <td id="liste">
        <div>
        <table>
        @foreach ($profile->liste as $lista)
        <tr>
            <td>
                <form name="sacuvaj" action="{{route('sacuvaj_listu', ['id' => $lista->idLista])}}"
                     method="GET"><input type="submit" value="sacuvaj"></form>
                <form name="zaboravi" action="{{route('zaboravi_listu', ['id' => $lista->idLista])}}"
                     method="GET"><input type="submit" value="zaboravi"></form>
            </td>
            <td>
                <a href="{{route('lista', ['id' => $lista->idLista])}}">
                <p class="lista" style="background-image: url('{{URL::asset('IMG/img_lista/lista'.$lista->idLista.'.jpg')}}')">
                    {{$lista->Ime}}
                </p>
                </a>
            </td>
            <td>
                lajkovi
            </td>
        </tr>
        @endforeach
        </table>
        </div>
    </td>
    <td id="profili">
        <div>
            @foreach ($profile->sacuvani as $sacuvan)
                <p><a id="sacuvani_link" href="{{route('profile', ['id' => $sacuvan->idKorisnik])}}">
                    <img class="sacuvani_slika" src="{{URL::asset('IMG/img_profile/profile'.$sacuvan->idKorisnik.'.png')}}"
                onerror="this.onerror=null; this.src='{{URL::asset('IMG/img_profile/profile_def.jpg')}}'">
                    {{$sacuvan->Ime}}
                </a></p>
            @endforeach 
        </div>
    </td>
</tr></table>

@endsection