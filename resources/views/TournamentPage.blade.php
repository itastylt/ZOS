
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
            <a href="/TournamentsPage">Atgal į sąrašą</a>

            <h1>Turnyrinė lentelė</h1>
            <div class="round r-of-4">
  <div class="bracket-game">
    <div class="player top win">
      Snute
      <div class="score">
        3
      </div>
    </div>
    <div class="player bot loss">
      TLO
      <div class="score">
        1
      </div>
    </div>
  </div>
  <div class="bracket-game cont">
    <div class="player top loss">
      Komanda1
      <div class="score">
        0
      </div>
    </div>
    <div class="player bot win">
      Komanda2
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
      Snute
      <div class="score">
        2
      </div>
    </div>
    <div class="player bot win">
      MC
      <div class="score">
        3
      </div>
    </div>
  </div>
</div>
        </div>
    </div>
@endsection
