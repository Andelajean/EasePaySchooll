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

        <h3>Filtrer les Paiements</h3>
        <form method="GET" action="{{ route('statistics.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <label for="date">Date :</label>
                    <input type="date" id="date" name="date" class="form-control" value="{{ $selectedDate }}">
                </div>
                <div class="col-md-4">
                    <label for="ecole">École :</label>
                    <select id="ecole" name="ecole" class="form-control" onchange="updateBanques()">
                        <option value="">Toutes les écoles</option>
                        @foreach($ecoles as $ecole)
                            <option value="{{ $ecole->id }}" {{ $selectedEcole == $ecole->id ? 'selected' : '' }}>{{ $ecole->nom_ecole }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="banque">Banque :</label>
                    <select id="banque" name="banque" class="form-control">
                        <option value="">Toutes les banques</option>
                        @foreach($banques as $banque)
                            <option value="{{ $banque->banque }}" {{ $selectedBanque == $banque->banque ? 'selected' : '' }}>{{ $banque->banque }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                </div>
            </div>
        </form>

        <h3>Paiements quotidiens par École</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>École</th>
                    <th>Date</th>
                    <th>Nombre de Paiements</th>
                    <th>Montant Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dailyPaymentsBySchool as $payment)
                    <tr>
                        <td>{{ $payment->nom_ecole }}</td>
                        <td>{{ $payment->date }}</td>
                        <td>{{ $payment->total }}</td>
                        <td>{{ $payment->total_amount }}</td>
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

    document.getElementById('ecole').addEventListener('change', updateBanques);
    document.getElementById('date').addEventListener('change', updateStatistics);
    document.getElementById('banque').addEventListener('change', updateStatistics);
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

function updateBanques() {
    var ecoleId = document.getElementById('ecole').value;
    var banqueSelect = document.getElementById('banque');

    if (ecoleId) {
        fetch(`/statistics/banques/${ecoleId}`)
            .then(response => response.json())
            .then(data => {
                banqueSelect.innerHTML = '<option value="">Toutes les banques</option>';
                data.forEach(function(banque) {
                    var option = document.createElement('option');
                    option.value = banque.banque;
                    option.text = banque.banque;
                    banqueSelect.appendChild(option);
                });
                updateStatistics();
            })
            .catch(error => console.error('Error fetching banques:', error));
    } else {
        banqueSelect.innerHTML = '<option value="">Toutes les banques</option>';
        updateStatistics();
    }
}

function updateStatistics() {
    var date = document.getElementById('date').value;
    var ecole = document.getElementById('ecole').value;
    var banque = document.getElementById('banque').value;

    var url = `/statistics?date=${date}&ecole=${ecole}&banque=${banque}`;
    fetch(url)
        .then(response => response.text())
        .then(html => {
            var parser = new DOMParser();
            var doc = parser.parseFromString(html, 'text/html');
            var newContent = doc.querySelector('.container').innerHTML;
            document.querySelector('.container').innerHTML = newContent;
            // Reinitialize charts after updating the content
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
        })
        .catch(error => console.error('Error updating statistics:', error));
}
</script>


@endsection
