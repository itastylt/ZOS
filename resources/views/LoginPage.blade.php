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
    Prisijungti
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
      <form method="post" enctype="multipart/form-data" action="{{ URL('login/validateForm') }}">
          <div class="form-group">
              @csrf
              <label for="username">Naudotojo vardas:</label>
              <input type="text" class="form-control" name="username"/>
          </div>
          <div class="form-group">
              <label for="password">Slaptažodis:</label>
              <input type="password" class="form-control" name="password"/>
          </div>
          <button type="submit" class="btn btn-block btn-primary">Prisijungti</button>
      </form>
      <a href="/">Atgal į pradžią</a>
	</div>
  </div>
</div>
@endsection