@extends('layouts.admin')

@section('content')

    <div class="card-body">
        <h3>Exécuter une requête SQLite</h3>
        <form id="sqlQueryForm">
            <div class="form-group">
                <label for="sqlQuery">Requête SQL:</label>
                <textarea id="sqlQuery" class="form-control" rows="4" placeholder="Entrez votre requête SQL ici..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Exécuter</button>
        </form>
        <br>
        <div id="queryResult"></div>
    </div>



    <script>
        

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('sqlQueryForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var query = document.getElementById('sqlQuery').value;

        fetch('/execute-sql', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ query: query })
        })
        .then(response => response.json())
        .then(data => {
            var resultDiv = document.getElementById('queryResult');
            if (data.error) {
                resultDiv.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
            } else {
                var table = '<table class="table table-bordered"><thead><tr>';
                for (var column in data[0]) {
                    table += `<th>${column}</th>`;
                }
                table += '</tr></thead><tbody>';
                data.forEach(row => {
                    table += '<tr>';
                    for (var column in row) {
                        table += `<td>${row[column]}</td>`;
                    }
                    table += '</tr>';
                });
                table += '</tbody></table>';
                resultDiv.innerHTML = table;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

  
});


    </script>
@endsection