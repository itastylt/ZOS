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
	Statyti už komandas
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
      <form method="post" enctype="multipart/form-data" action="{{ URL('/BetPage/betOnTeam/') }}">
          <div class="form-group">
              @csrf
              <h5>Komanda {{$team->id}}</h5>
              <h5>Koefficientas {{$team->coefficient}}</h5>
              <label for="bet">Statymas:</label>
              <input type="number" class="form-control" name="bet"/>
              <input type="hidden" value="{{$team->id}}" name="id"/>
          </div>
          <button type="submit" class="btn btn-block btn-danger">Statyti</button>
      </form>
	</div>
  </div>
</div>
@endsection