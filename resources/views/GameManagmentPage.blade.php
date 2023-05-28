@extends('layout')
@section('content')
@if(!session()->get('is_administrator'))
    @php
        header("Location: /");
        exit;
    @endphp
@endif
<style>
  .push-top {
    margin-top: 50px;
  }
</style>
<div class="container">

<div class="push-top">
  @if(session()->get('completed'))
    <div class="alert alert-success">
      {{ session()->get('completed') }}
    </div><br />
  @endif
  <h1>Žaidimų sąrašas</h1>
  <a href="GameManagmentPage/create">Pridėti žaidimą</a>
  <table class="table">
    <thead>
        <tr class="table-warning">
          <td>Paveikslėlis</td>
          <td>Pavadinimas</td>
          <td>Aprašymas</td>
          <td class="text-center">Veiksmai</td>
        </tr>
    </thead>
    <tbody>
        @foreach($game as $games)
        <tr>
            <td><img src="{{ asset('storage/images/'.$games->image_url) }}" style="width:100px; height:100px"></td>
            <td>{{$games->name}}</td>
            <td>{{$games->description}}</td>
            <td class="text-center">
                <a href="{{ route('GameManagmentPage.edit', $games->id)}}" class="btn btn-primary btn-sm"">Redaguoti</a>
                <form action="{{ route('GameManagmentPage.destroy', $games->id)}}" method="post" style="display: inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm"" type="submit">Naikinti</button>
                  </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
</div>
</div>
@endsection
