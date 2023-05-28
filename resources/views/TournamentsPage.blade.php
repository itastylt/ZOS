
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
                {{session()->forget('success')}}
            @endif
            @if (isset($errors) && sizeof($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br />
            @endif
            @if($is_organisator)
                <a href="/TournamentCreationPage">Sukurti turnyrą...</a>
            @endif
            <h1>Turnyrų sąrašas</h1>
            <table class="table">
                <thead>
                <tr class="table-warning">
                    <td>Žaidimas</td>
                    <td>Žaidimo rėžimas</td>
                    <td>Registracijos pradžia</td>
                    <td>Registracijos pabaiga</td>
                    <td>Žaidėjai</td>
                    <td>Turnyro pradžia</td>
                    @if(session()->get('is_administrator') || session()->get('is_organisator'))
                        <td>Turnyro statusas</td>
                    @endif
                    <td class="text-center">Veiksmai</td>
                </tr>
                </thead>
                <tbody>
                @foreach($tournaments as $tournament)
                    @if(session()->get('is_administrator') || session()->get('is_organisator') || $tournament->status == 'confirmed')
                        <tr>
                            <td>{{$tournament->game_name}}</td>
                            <td>{{$tournament->game_mode}}</td>
                            <td>{{$tournament->registration_start}}</td>
                            <td>{{$tournament->registration_end}}</td>
                            <td>{{$tournament->playercount}}/{{$tournament->player_count}}</td>
                            <td>{{$tournament->tournament_start}}</td>
                            @if(session()->get('is_administrator') || session()->get('is_organisator'))
                                <td>{{$tournament->status}}</td>
                            @endif
                            <td class="text-center">
                                <div>
                                    <a href="TournamentPage/{{$tournament->id}}" class="btn btn-primary btn-sm">Informacija</a>
                                </div>
                                @if(session()->get('is_administrator') && $tournament->status == 'sent_to_admin')
                                    <div class="p-2">
                                        <button class="btn btn-success btn-sm p-2" onclick="showConfirmation({{ $tournament->id }})">Patvirtinti</button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endif

                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function showConfirmation(id) {
            if (confirm("Ar tikrai norite patvirtinti turnyrą?")) {
                confirmTournament(id);
            }
        }
        function confirmTournament(id) {
            window.location.href = '/confirmTournament/' + id;
        }
    </script>
@endpush
