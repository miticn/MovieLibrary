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
                    @auth    
                    <td style="text-align: right; width:50px;">
                        @if ($profile->idKorisnik == Auth::id())
                        izmeni
                        @else
                        <form name="sacuvaj" action="{{route('sacuvaj_korisnika', ['id' => $profile->idKorisnik])}}"
                            method="GET"><input type="submit" value="sacuvaj"></form>
                        @endif
                    </td>
                    @endauth
                </tr>
                <tr id="profile_opis"> 
                    <td colspan='2'>
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
        @auth
        @if($profile->idKorisnik == Auth::id())
        <tr>
            <form name="napravi_listu" action="{{route('napravi_listu')}}" method="GET">
                <td>
                    <input type="submit" value="Napravi listu">
                </td>
                <td>
                    <input type="text" name="Ime">
                </td>
            </form>
        </tr>
        @endif
        @endauth
        @foreach ($profile->liste as $lista)
        <tr>@auth
            <td style="text-align: center;">
                @if($profile->idKorisnik == Auth::id())
                <form name="zaboravi" action="{{route('zaboravi_listu', ['id' => $lista->idLista])}}"
                    method="GET"><input type="submit" value="zaboravi"></form>
                @else
                <form name="sacuvaj" action="{{route('sacuvaj_listu', ['id' => $lista->idLista])}}"
                     method="GET"><input type="submit" value="sacuvaj"></form>
                @endif
            </td>
            @endauth
            <td style="width: 100%;">
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
        <table>
        @foreach ($profile->sacuvani as $sacuvan)
        <tr>
            <td><a id="sacuvani_link" href="{{route('profile', ['id' => $sacuvan->idKorisnik])}}">
                <img class="sacuvani_slika" src="{{URL::asset('IMG/img_profile/profile'.$sacuvan->idKorisnik.'.png')}}"
                onerror="this.onerror=null; this.src='{{URL::asset('IMG/img_profile/profile_def.jpg')}}'">
                {{$sacuvan->Ime}}</a>
            </td>
            @if($profile->idKorisnik == Auth::id())
            <td>
                <form name="zaboravi" action="{{route('zaboravi_korisnika', ['id' => $sacuvan->idKorisnik])}}"
                    method="GET"><input type="submit" value="x">
                </form>
            </td>
            @endif
        </tr>
        @endforeach 
        </table>
    </td>
</tr></table>

@endsection