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
<div class="card push-top">
  <div class="card-header">
  Patvirtinti statymą
  </div>
  <div class="card-body">
	<div class="container">
      <form method="post" enctype="multipart/form-data" action="{{ URL('/BetPage/checkConfirm/') }}">
          <div class="form-group">
              @csrf
              <h5>Komanda {{$bet->fk_Teamid}}</h5>
              <h5>Statymas {{$bet->placed_sum}}</h5>
              <h5>Laimėtina suma {{$bet->winning_sum}}</h5>
              <h5>Koefficientas {{$bet->winning_sum/$bet->placed_sum-1}}</h5>
          </div>
          <input type="hidden" name="team" value="{{$bet->fk_Teamid}}">
          <input type="hidden" name="placed_sum" value="{{$bet->placed_sum}}">
          <input type="hidden" name="winning_sum" value="{{$bet->winning_sum}}">
          <button type="submit" class="btn btn-block btn-danger">Patvirtinti</button>
      </form>
	</div>
  </div>
</div>
@endsection