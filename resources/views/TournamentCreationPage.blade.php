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
	Pridėti žaidimą
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
              <label for="name">Pavadinimas:</label>
              <input type="text" class="form-control" name="name"/>
          </div>
          <div class="form-group">
              <label for="description">Aprašymas:</label>
              <textarea class="form-control" name="description"></textarea>
          </div>
          <div class="form-group">
              <label for="image">Paveikslėlis</label>
              <input type="file" class="w-100" name="image_url"/>
          </div>
          <button type="submit" class="btn btn-block btn-danger">Sukurti</button>
      </form>
	</div>
  </div>
</div>
@endsection