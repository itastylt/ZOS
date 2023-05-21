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
  <h1>Vartotojų sąrašas</h1>
  <table class="table">
    <thead>
        <tr class="table-warning">
          <td>Vartotojo vardas</td>
          <td>e-paštas</td>
          <td>registracijos laikas</td>
          <td>paveikslėlio url</td>
          <td>blokuotas</td>
          <td class="text-center">Veiksmai</td>
        </tr>
    </thead>
    <tbody>
        @foreach($mergedData as $user)
            <tr>
                <td>{{$user->username}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->registration_date}}</td>
                <td>{{$user->image_url}}</td>
                <td>
                    @if(is_null($user->block_comment))
                        NE 
                    @else
                        TAIP
                    @endif</td>
                <td class="text-center">
                    <a href="{{ route('UsersPage.openUserRolePage', $user)}}" class="btn btn-primary btn-sm">Redaguoti rolę</a>
                </td>
            </tr>
        @endforeach
    </tbody>
  </table>
</div>
</div>
@endsection