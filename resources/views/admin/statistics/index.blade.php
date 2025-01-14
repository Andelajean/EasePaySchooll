@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Statistiques du Site</h1>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Total des Paiements</div>
                        <div class="card-body">
                            <p>{{ $totalPayments }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Total des Écoles Inscrites</div>
                        <div class="card-body">
                            <p>{{ $totalSchools }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <h3>Paiements par École</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>École</th>
                        <th>Nombre de Paiements</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paymentsBySchool as $school)
                        <tr>
                            <td>{{ $school->nom_ecole }}</td>
                            <td>{{ $school->paiements_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="lineChartDate">Sélectionner une date :</label>
                <input type="date" id="lineChartDate" class="form-control" onchange="updateChart('lineChart', this.value)">
                <canvas id="lineChart"></canvas>
            </div>
            <div class="col-md-6">
                <label for="polarAreaChartDate">Sélectionner une date :</label>
                <input type="date" id="polarAreaChartDate" class="form-control" onchange="updateChart('polarAreaChart', this.value)">
                <canvas id="polarAreaChart"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="radarChartDate">Sélectionner une date :</label>
                <input type="date" id="radarChartDate" class="form-control" onchange="updateChart('radarChart', this.value)">
                <canvas id="radarChart"></canvas>
            </div>
            <div class="col-md-6">
                <label for="barChartDate">Sélectionner une date :</label>
                <input type="date" id="barChartDate" class="form-control" onchange="updateChart('barChart', this.value)">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var lineCtx = document.getElementById('lineChart').getContext('2d');
        var polarAreaCtx = document.getElementById('polarAreaChart').getContext('2d');
        var radarCtx = document.getElementById('radarChart').getContext('2d');
        var barCtx = document.getElementById('barChart').getContext('2d');

        var initialData = {
            labels: ['Total des utilisateurs', 'Utilisateurs en ligne', 'Nouvelles inscriptions', 'Total des visites'],
            datasets: [{
                label: 'Statistiques',
                data: [{{ $totalUsers }}, {{ $onlineUsers }}, {{ $newRegistrations }}, {{ $totalVisits }}],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        };

        var lineChart = new Chart(lineCtx, {
            type: 'line',
            data: initialData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var polarAreaChart = new Chart(polarAreaCtx, {
            type: 'polarArea',
            data: initialData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var radarChart = new Chart(radarCtx, {
            type: 'radar',
            data: initialData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var barChart = new Chart(barCtx, {
            type: 'bar',
            data: initialData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });

    function updateChart(chartId, date) {
        fetch(`/statistics/data?date=${date}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.totalUsers !== undefined) {
                    var chart = Chart.getChart(chartId);
                    if (chart) {
                        chart.data.datasets[0].data = [data.totalUsers, data.onlineUsers, data.newRegistrations, data.totalVisits];
                        chart.update();
                    } else {
                        console.error(`Chart with ID ${chartId} not found.`);
                    }
                } else {
                    console.error('Data is undefined or missing properties.');
                }
            })
            .catch(error => console.error('Error fetching data:', error));
    }
    </script>
@endsection
