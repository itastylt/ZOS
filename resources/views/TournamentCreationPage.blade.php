@extends('layout')
@section('content')
<style>
    .container {
      max-width: 450px;
    }
    .push-top {
      margin-top: 50px;
    }
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
</style>
@if($is_organisator)
  <div class="card push-top">
    <div class="card-header">
    Sukurti turnyrą
    </div>
    <div class="card-body">
    <div class="container">
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
          </ul>
        </div><br />
      @endif
        <form method="post" enctype="multipart/form-data" action="{{ URL('TournamentCreationPage/validateForm') }}">
            <div class="form-group">
                @csrf
                <label for="game">Žaidimas:</label>
                <select class="form-control" name="game">
                  <option value="" selected>Pasirinkti žaidimą...</option>
                  @foreach($games as $game)
                    <option value="{{ $game->id }}">{{$game->name}}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="game_mode">Rėžimas:</label>
                <input class="form-control" type="text" name="game_mode">
            </div>
            <div class="form-group">
                <label for="max_team_count">Maksimalus komandų skaičius:</label>
                <select class="form-control" name="max_team_count">
                  <option value="" selected>Pasirinkti komandų skaičių...</option>
                  <option value="8">8</option>
                  <option value="16">16</option>
                  <option value="32">32</option>
                  <option value="64">64</option>
                </select>
            </div>
            <div class="form-group">
                <label for="player_count">Žaidėjų kiekis:</label>
                <input class="form-control" type="number" name="player_count">
        
              </div>
            <div class="form-group">
                <label for="price_pool">Aukso puodas:</label>
                <input class="form-control" type="number" name="price_pool">
            </div>
            <div class="form-group">
                <label for="join_price">Prisijungimo kaina::</label>
                <input class="form-control" type="number" name="join_price">
            </div>
            <div class="form-group">
                <label for="registration_start">Registracijos pradžia:</label>
                <input class="form-control" type="date" name="registration_start">
            </div>
            <div class="form-group">
                <label for="registration_end">Registracijos pabaiga:</label>
                <input class="form-control" type="date" name="registration_end">
            </div>
            <div class="form-group">
                <label for="tournament_start">Turnyro pradžia:</label>
                <input class="form-control" type="date" name="tournament_start">
            </div>
            <span>* Pastaba: Žaidėjų kiekis turi lygiai dalintis iš komandų skaičiaus</span>
            <button type="submit" class="btn btn-block btn-danger">Sukurti</button>
        </form>
    </div>
    </div>
  </div>
@else
    <div class="container">
      <h1>Būtų neblogai, ane?</h1>
    </div>

@endif
@endsection