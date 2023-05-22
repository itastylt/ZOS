@extends('layout')
 
@section('content')
	<div class="container">
		<h1>Pagrindinis puslapis</h1>
		<h3>Administravimo posistemis</h3>
		<a href="/GameManagmentPage">Valdyti žaidimus</a></br>
		<a href="{{ route('UsersPage.renderUsersPage')}}">Peržiūrėti naudotojus</a>
	</div>
@endsection
 
@push('js')
@endpush