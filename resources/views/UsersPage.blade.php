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
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div>
  @endif
  <h1>Vartotojų sąrašas</h1>
  <table class="table">
    <thead>
        <tr class="table-warning">
          <td>Vartotojo vardas</td>
          <td>e-paštas</td>
          <td>registracijos laikas</td>
          <td>paveikslėlio url</td>
          <td>rolė</td>
          <td>blokuotas</td>
          <td class="text-center">Veiksmai</td>
        </tr>
    </thead>
    <tbody>
        @foreach($mergedPlayers as $user)
            <tr>
                <td>{{$user->username}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->registration_date}}</td>
                <td>{{$user->image_url}}</td>
                <td>@if($user->organizer_id)
                        Organizuotojas
                    @else
                        Žaidėjas
                    @endif</td>
                <td>
                    @if(is_null($user->block_comment))
                        NE 
                    @else
                        TAIP
                    @endif</td>
                <td class="text-center">
                    <a href="{{ route('UsersPage.openUserRolePage', ['user'=>$user])}}" class="btn btn-primary btn-sm">Redaguoti rolę</a>
                </td>
            </tr>
        @endforeach
    </tbody>
  </table>
</div>
</div>
@endsection