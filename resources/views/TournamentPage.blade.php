@extends('layout')
@section('content')
    <style>
        table.bracket {
            border-collapse: collapse;
            border: none;
        }

        .bracket td {
            vertical-align: middle;
            width: 40em;
            margin: 0;
            padding: 10px 0px 10px 0px;
        }

        .bracket td p {
            border-bottom: solid 1px black;
            border-top: solid 1px black;
            border-right: solid 1px black;
            margin: 0;
            padding: 5px 5px 5px 5px;
        }

        .bracket th{
            text-align:center;
        }
    </style>
    <div class="container">
        <div class="push-top">
            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                    
                </div><br />
            @endif
                <a href="/TournamentsPage">Atgal į sąrašą</a>
                @foreach ($tournamentExtended as $tournament)
                    <h1>Turnyras {{$tournament->game_name}} {{$tournament->game_mode}}</h1>
                <p>Prizinis fondas - {{$tournament->prize_pool}}</p>
                @if($tournament->playercount<=$tournament->player_count) @endif
                    <p>Šiuo metu prie turnyro prisijungę {{$tournament->playercount}}/{{$tournament->player_count}} žaidėjų</p>

                    @if (!$isRegistered)
                        @php
                            $currentDate = now(); // Get the current date and time
                            $registrationStart = $tournament->registration_start;
                            $registrationEnd = $tournament->registration_end;
                        @endphp

                        @if ($currentDate >= $registrationStart && $currentDate <= $registrationEnd && $tournament->playercount != $tournament->player_count &&$tournament->status=='confirmed')
                            <form method="post" action="{{ route('joinTournament', $tournament->id) }}">
                                @csrf
                                <p>Prisijungimo mokestis - {{ $tournament->join_price }}</p>
                                <button class="btn btn-primary btn-sm" type="submit">Jungtis</button>
                            </form>
                        @else
                            <p>Turnyro registracija neaktyvi</p>
                        @endif
                    @else
                        <p>Jūs jau dalyvaujate šiame turnyre</p>
                    @endif
                    <br>
                    <span class="p-2">Pradėti turnyrą</span><a href="/initiateTournament/{{$tournament->id}}" class="btn btn-primary btn-sm" type="submit">Pradėti turnyrą</a>
                @endforeach
        </div>
    </div>
        <div class="container w-100">

            <div class="push-top">
                @if(session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div><br />
                @endif


                <h3>Turnyrinė lentelė</h3>
                    <table class="bracket">
                        @foreach($cols as $col)
                            {!!$col!!}
                        @endforeach
                    </table>

            </div>
            </div>
        <br>
            <div class="container w-100 d-flex flex-wrap">
                <h3>Lažybų koeficientai</h3>
                <table class="table">
                    <thead>
                        <tr class="table-warning">
                            <td>Komanda</td>
                            <td>Koeficientas</td>
                            <td class="text-center">Statyti</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teams as $team)
                            <tr>
                                <td>{{$team->name}}</td>
                                <td>{{$team->coefficient}}</td>
                                <td><a href="/BetPage/{{$team->id}}">Statyti</a></td>
                            </tr>
                        @endforeach
                    </tbody>
            </table>
            </div>



    @endsection
