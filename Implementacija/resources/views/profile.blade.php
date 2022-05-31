@extends('template')
@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/profile.css') }}">
<table class="profile">
    <tr class="border">
        <td class="profile_slika">
            <div>
                <img class="profile_slika" src="{{URL::asset('IMG/img_profile/profile'.$profile->idKorisnik.'.jpg')}}"
            onerror="this.onerror=null; this.src='{{URL::asset('IMG/img_profile/profile_def.jpg')}}'">
            </div>
        </td>
        <td>
            <table id="ime_opis">
                <tr id="profile_ime">
                    <td>
                        &nbsp;&nbsp;&nbsp;{{$profile->Ime}}
                    </td>
                    @auth    
                    <td style="text-align: right; width:50px;">
                        @if ($profile->idKorisnik == Auth::id())
                        <form name="izmeni" action="{{route('izmeni')}}" method="POST">
                        @csrf
                        <input type="submit" value="izmeni"></form>
                        @else
                        <form name="sacuvaj" action="{{route('sacuvaj_korisnika', ['id' => $profile->idKorisnik])}}"
                            method="POST"><input type="submit" value="sacuvaj">@csrf</form>
                        @endif
                    </td>
                    @endauth
                </tr>
                <tr id="profile_opis"> 
                    <td colspan='2' style="">
                        <i>  "{{$profile->Opis}}" </i>      
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
        <tr style="background-color: #2f2f2f">
            <form name="napravi_listu" action="{{route('napravi_listu')}}" method="POST">
                @csrf
                <td>
                    <input type="submit" value="Napravi listu">
                </td>
                <td id="input_lista">
                    <input type="text" name="Ime">
                </td>
            </form>
        </tr>
        @endif
        @endauth
        @foreach ($profile->liste as $lista)
        <tr class="listic"><td class="listic" colspan="2">
        <a href="{{route('lista', ['id' => $lista->idLista])}}">
        
        <div class="listcard" style="overflow-y: hidden;">
            <div class="listborder">
                <p><b>{{$lista->Ime}}</b></p>
            </div>
            <div>@auth
                @if($profile->idKorisnik == Auth::id())
                <form name="zaboravi" action="{{route('zaboravi_listu', ['id' => $lista->idLista])}}"
                    method="POST"><input type="submit" value="zaboravi">@csrf</form>
                @else
                <form name="sacuvaj" action="{{route('sacuvaj_listu', ['id' => $lista->idLista])}}"
                    method="POST"><input type="submit" value="sacuvaj">@csrf</form>
                @endif
                <form name="oceni" action="{{route('oceni_listu', ['indikator' => '3', 'lokacija' => $lista->idLista, 'vrsta' => '1'])}}" method="POST">
                    <input type="submit" value="oceni">@csrf</form>
                @endauth
                <form style="color: white; font-size: 20px;"> {{$lista->BrojLajk - $lista->BrojDislajk}} @csrf</form>
            </div>
            </div>
        </a>
        </td></tr>
        @endforeach
        </table>
        </div>
    </td>
    <td>
        <div id="profili">
        <table id="profili_sacuvani">
        @foreach ($profile->sacuvani as $sacuvan)
        <tr class="profili">
            <td colspan="2"><a href="{{route('profile', ['id' => $sacuvan->idKorisnik])}}">
                <img class="sacuvani_slika" src="{{URL::asset('IMG/img_profile/profile'.$sacuvan->idKorisnik.'.jpg')}}"
                onerror="this.onerror=null; this.src='{{URL::asset('IMG/img_profile/profile_def.jpg')}}'">
                {{$sacuvan->Ime}}</a>
            </td>
            <td>
                @auth
                @if($profile->idKorisnik == Auth::id())
                <form name="zaboravi" action="{{route('zaboravi_korisnika', ['id' => $sacuvan->idKorisnik])}}"
                    method="POST"><input type="submit" value="x">@csrf
                </form>
                @endif
                @endauth
            </td>
        </tr>
        @endforeach 
        </table>
        </div>
    </td>
</tr></table>

@endsection