@extends('layout')
@section('content')
    <style>
        .round {
            float: left;
        }
        .round.r-of-4 {

        }
        .round.r-of-2 {
            margin-top: 25px;
        }
        .bracket-game {
            max-width: 125px;
            margin: 10px 0;
        }
        .player {
            min-width: 100px;
            border: 1px solid #AAA;
            padding-left: 10px;
        }
        .player.top {
            border-radius: 3px 3px 0 0;
        }
        .player.bot {
            border-radius: 0 0 3px 3px;
        }
        .player .score {
            display: inline;
            float: right;
            border-left: 1px solid #AAA;
            padding-left: 10px;
            padding-right: 10px;
            background: #EEE;
        }
        .player.win {
            background-color: #B8F2B8;
        }
        .player.loss {
            background-color: #F2B8B8;
        }
        .connectors {
            float: left;
            min-width: 35px;
        }
        .connectors.r-of-2 .top-line {
            position: relative;
            top: 30px;
            width: 17px;
            border: 1px solid #AAA;
        }
        .connectors.r-of-2 .bottom-line {
            position: relative;
            top: 81px;
            width: 17px;
            border: 1px solid #AAA;
        }
        .connectors.r-of-2 .vert-line {
            position: relative;
            top: 26px;
            left: -16px;
            height: 55px;
            border-right: 2px solid #AAA;
        }
        .connectors.r-of-2 .next-line {
            position: relative;
            top: -4px;
            left: 17px;
            width: 17px;
            border: 1px solid #AAA;
        }
        .clear {
            clear: both;
        }
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
                <a href="/TournamentsPage">Atgal į sąrašą</a>
                @foreach ($tournamentExtended as $tournament)
                    <h1>Turnyras {{$tournament->game_name}} {{$tournament->game_mode}}</h1>
                <p>Prizinis fondas - {{$tournament->prize_pool}}</p>
                @if($tournament->playercount<=$tournament->player_count) @endif
                    <p>Šiuo metu prie turnyro prisijungę {{$tournament->playercount}}/{{$tournament->player_count}} žaidėjų</p>
                    
                    @if(!$isRegistered)
                        <form method="post" action="{{route('joinTournament', $tournament->id)}}">
                            @csrf
                            <p>Prisijungimo mokestis - {{$tournament->join_price}}</p><button class="btn btn-primary btn-sm" type="submit">Jungtis</button>
                        </form>
                    @else <p>Jūs jau dalyvaujate šiame turnyre</p>
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
                <div class="round r-of-4">
                    <div class="bracket-game">
                        <div class="player top win">
                            Komanda1
                            <div class="score">
                                3
                            </div>
                        </div>
                        <div class="player bot loss">
                            Komanda2
                            <div class="score">
                                1
                            </div>
                        </div>
                    </div>
                    <div class="bracket-game cont">
                        <div class="player top loss">
                            Komanda3
                            <div class="score">
                                0
                            </div>
                        </div>
                        <div class="player bot win">
                            Komanda4
                            <div class="score">
                                3
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="connectors r-of-2">
                    <div class="top-line"></div>
                    <div class="clear"></div>
                    <div class="bottom-line"></div>
                    <div class="clear"></div>
                    <div class="vert-line"></div>
                    <div class="clear"></div>
                    <div class="next-line"></div>
                    <div class="clear"></div>
                    </div>
                    <div class="round r-of-2">
                    <div class="bracket-game">
                        <div class="player top loss">
                            Komanda1
                            <div class="score">
                                2
                            </div>
                        </div>
                        <div class="player bot win">
                            Komanda3
                            <div class="score">
                                3
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
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
                                <td>Komanda {{$team->id}}</td>
                                <td>{{$team->coefficient}}</td>
                                <td><a href="/BetPage/{{$team->id}}">Statyti</a></td>
                            </tr>
                        @endforeach
                    </tbody>
            </table>
            </div>



    @endsection
