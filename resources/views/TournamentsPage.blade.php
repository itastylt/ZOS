
@extends('layout')
@section('content')
    <style>
        .push-top {
            margin-top: 50px;
        }
    </style>
    <div class="container">
        @if($is_organisator)

        @endif
        <div class="push-top">
            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div><br />
            @endif
            <a href="/TournamentCreationPage">Sukurti turnyrą...</a>
            <h1>Turnyrų sąrašas</h1>
            <table class="table">
                <thead>
                <tr class="table-warning">
                    <td>Žaidimas</td>
                    <td>Žaidimo rėžimas</td>
                    <td>Registracijos pradžia</td>
                    <td>Registracijos pabaiga</td>
                    <td>Žaidėjai</td>
                    <td class="text-center">Veiksmai</td>
                </tr>
                </thead>
                <tbody>
                @foreach($tournaments as $tournament)
                    <tr>
                        <td>{{$tournament->game_name}}</td>
                        <td>{{$tournament->game_mode}}</td>
                        <td>{{$tournament->registration_start}}</td>
                        <td>{{$tournament->registration_end}}</td>
                        <td>{{$tournament->playercount}}/{{$tournament->player_count}}</td>
                        <td class="text-center">
                            <a href="TournamentPage/{{$tournament->id}}" class="btn btn-primary btn-sm">Informacija</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
