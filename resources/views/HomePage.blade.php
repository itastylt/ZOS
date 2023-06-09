@extends('layout')
 
@section('content')
    @if($logged_in)
    <div class="container">
    @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                    
                </div><br />
                {{session()->forget('success')}}
    @endif
    @if (session()->get('errors'))
        <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
          </ul>
        </div><br />
      @endif
    </div>
    <div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>Pagrindinis puslapis</h1>
            <h3>Administravimo posistemis</h3>
            <a href="{{ route('UsersPage.renderUsersPage')}}">Peržiūrėti naudotojus</a>

            </br>

            <div class="most-popular-games">
                <h3>Most Popular Games</h3>
                <ul>
                    @foreach($mostPopularGames as $game)
                    <li>{{ $game->name }} {{ $game->quantity }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>




        @push('js')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
            document.addEventListener('DOMContentLoaded', function () {
            var labels = [];
            var quantities = [];

            @foreach($mostPopularGames as $game)
                labels.push("{{ $game->name }}");
                quantities.push({{ $game->quantity }});
            @endforeach

            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Populiariausi dienos žaidimai',
                        data: quantities,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(255, 205, 86, 0.5)',
                            'rgba(153, 102, 255, 0.5)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 205, 86, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Populiariausi dienos žaidimai'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.raw;
                                    label += ' žaidėjų';
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });

        </script>
    @endpush
    @else
    <div class="container d-flex align-items-center justify-content-center">
        <div class="card w-50 d-flex align-items-center justify-content-center">
            <div class="card-body ">
                <a href="/login" class="btn btn-primary">Prisijungti</a>
                <a href="/register" class="btn btn-danger">Registruotis</a>
                    
            </div>
        </div>
    </div>
    @endif


@endsection