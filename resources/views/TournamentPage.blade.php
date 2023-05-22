
@extends('layout')
@section('content')
    <style>
        .push-top {
            margin-top: 50px;
        }
    </style>
    <div class="container">
        <div class="push-top">
            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div><br />
            @endif
                @foreach ($tournamentExtended as $tournament)
                    <h1>Turnyras {{$tournament->game_name}} {{$tournament->game_mode}}</h1>
                <p>Prizinis fondas - {{$tournament->prize_pool}}</p>
                @if($tournament->playercount<=$tournament->player_count) @endif
                    <p>Šiuo metu prie turnyro prisijungę {{$tournament->playercount}}/{{$tournament->player_count}} žaidėjų</p>
                    <form method="post" action="{{route('joinTournament', $tournament->id)}}">
                        @csrf
                        <p>Prisijungimo mokestis - {{$tournament->join_price}}</p><button class="btn btn-primary btn-sm" type="submit">Jungtis</button>
                    </form>
                @endforeach
        </div>
    </div>
@endsection
