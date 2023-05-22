@extends('layout')
@section('content')
<style>
    .container {
      max-width: 450px;
    }
    .push-top {
      margin-top: 50px;
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