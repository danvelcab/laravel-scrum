@extends('template')

@section('title', 'Sprint Backlog')

@section('content')
    <div class="page-content-wrapper" id="page-content-wrapper">
        <h2>Sprint Backlog de {{$project_name}} </h2>

        <script src="{!! asset('js/Chart.js') !!}"></script>
        <canvas id="myChart" width="400px"></canvas>
        <script>
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [@foreach($labels as $label)'{{$label}}',@endforeach
                ],
                datasets: [{
                    label: 'PH estimados',
                    data: [@foreach($totalPH as $ph)'{{$ph}}',@endforeach],
                    backgroundColor: [
                        'rgba(74, 214, 116, 0.2)'
                    ],
                    borderColor: [
                        'rgba(74,214,116,1)'

                    ],
                    borderWidth: 1
                },{
                    label: 'PH alcanzados',
                    lineTension: 0.1,
                    data: [@foreach($currentPH as $ph)'{{$ph}}',@endforeach],
                    backgroundColor: [
                        'rgba(74,95,214,0.2)'
                    ],
                    borderColor: [
                        'rgba(74,95,214,1)'

                    ],
                    borderWidth: 1
                }

                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
        </script>
    </div>
@endsection