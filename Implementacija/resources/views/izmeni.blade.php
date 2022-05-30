@extends('template')
@section('content')

<form name="izmeni" action="{{route('izmeni_submit')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <table style="margin:auto; margin-top: 300px;">
        <tr>
            <td>
                <input type="text" name="Ime" value="{{Auth::user()->Ime}}">
            </td>
        </tr>

        <tr>
            <td>
                <input type="text" name="Opis" value="{{Auth::user()->Opis}}">
            </td>
        </tr>

        <tr>
            <td>
                <input type="file" name="slika" accept="image/jpeg">
            </td>
        </tr>

        <tr>
            <td>
                <input type="submit" value="Izmeni">
            </td>
        </tr>

    </table>
</form>

@endsection