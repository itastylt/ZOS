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
    Registracija
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
      <form method="post" enctype="multipart/form-data" action="{{ URL('register/validateForm1') }}">
          <div class="form-group">
              @csrf
              <label for="username">Naudotojo vardas:</label>
              <input type="text" class="form-control" name="username"/>
          </div>
          <div class="form-group">
              <label for="password">Slaptažodis:</label>
              <input type="password" class="form-control" name="password"/>
          </div>
          <div class="form-group">
              <label for="email">El. paštas:</label>
              <input type="email" class="form-control" name="email"/>
          </div>
          <div class="form-group">
              <label for="image_url">Paveikslėlis</label>
              <input type="file" class="w-100" name="image_url"/>
          </div>
          <button type="submit" class="btn btn-block btn-danger">Registruotis</button>
      </form>
      <a href="/">Atgal į pradžią</a>
	</div>
  </div>
</div>
@endsection