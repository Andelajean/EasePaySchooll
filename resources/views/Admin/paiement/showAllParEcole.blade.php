@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            @foreach($ecoles as $ecole)
             @if  ($ecole->id == $id)
              <h1>Gestion des Paiements pour {{ $ecole->nom_ecole }}</h1>
             @endif
            @endforeach 
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    @if (Session::has('success'))
         <div class="alert alert-success"> {{ Session::get('success') }} </div>
        @endif
        @if (Session::has('update'))
         <div class="alert alert-warning"> {{ Session::get('update') }} </div>
        @endif
        @if (Session::has('delete'))
         <div class="alert alert-danger"> {{ Session::get('delete') }} </div>
        @endif
      <div class="container-fluid">
       
        <div class="row">
          <div class="col-12">
            <div class="card">
              
              <!-- /.card-header -->
              <div class="card-body">
                 <!-- Ajout de la barre de recherche -->
                    <div class="form-group">
                        <label for="searchInput">Rechercher:</label>
                        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher...">
                    </div>
                    <!-- Ajout des balises select pour le tri -->
                    <div class="form-group">
                        <label for="bankFilter">Filtrer par banque:</label>
                        <select id="bankFilter" class="form-control">
                            <option value="">Toutes les banques</option>
                            <!-- Ajoutez ici les options pour chaque banque -->
                            @isset($banques)
                             @foreach ($banques as $banque)
                              <option value="{{ $banque->nom }}">{{ $banque->nom }}</option>
                             @endforeach
                            @endisset 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dateFilter">Filtrer par date:</label>
                        <input type="date" id="dateFilter" class="form-control">
                    </div>

                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>id_paiement</th>
                            <th>nom_ecole</th>
                            <th>telephone</th>
                            <th>ville</th>
                            <th>banque</th>
                            <th>nom_complet</th>
                            <th>classe</th>
                            <th>niveau</th>
                            <th>filiere</th>
                            <th>niveau_universite</th>
                            <th>montant</th>
                            <th>details</th>
                            <th>qr_code</th>
                            <th>date_paiement</th>
                            <th>heure_paiement</th>
                        </tr>
                        </thead>
                        <tbody>
                            @isset($paiements)
                            @foreach ($paiements as $paiement)
                            <tr>
                                <td>{{ $paiement->id}}</td>
                                <td>{{ $paiement->id_paiement}}</td>
                                <td>{{ $paiement->nom_ecole}}</td>
                                <td>{{ $paiement->telephone}}</td>
                                <td>{{ $paiement->ville}}</td>
                                <td>{{ $paiement->banque}}</td>
                                <td>{{ $paiement->nom_complet}}</td>
                                <td>{{ $paiement->classe}}</td>
                                <td>{{ $paiement->niveau}}</td>
                                <td>{{ $paiement->filiere}}</td>
                                <td>{{ $paiement->niveau_universite}}</td>
                                <td>{{ $paiement->montant}}</td>
                                <td>{{ $paiement->details}}</td>
                                <td>{{ $paiement->qr_code}}</td>
                                <td>{{ $paiement->date_paiement}}</td>
                                <td>{{ $paiement->heure_paiement}}</td>
                                
                            
                              
                            </tr>
                            @endforeach
                        @endisset                
                        </tbody>
                    </table>
                </div>

              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  <script>
    ///***Nous permet de filtrer par banque et par date***///
    document.getElementById('bankFilter').addEventListener('change', filterTable);
    document.getElementById('dateFilter').addEventListener('change', filterTable);

    function filterTable() {
        var bankFilter = document.getElementById('bankFilter').value;
        var dateFilter = document.getElementById('dateFilter').value;
        var table = document.getElementById('example2');
        var tr = table.getElementsByTagName('tr');

        for (var i = 1; i < tr.length; i++) {
            var tdBank = tr[i].getElementsByTagName('td')[2];
            var tdDate = tr[i].getElementsByTagName('td')[13];
            if (tdBank && tdDate) {
                var bankValue = tdBank.textContent || tdBank.innerText;
                var dateValue = tdDate.textContent || tdDate.innerText;
                if ((bankValue.indexOf(bankFilter) > -1 || bankFilter === "") &&
                    (dateValue.indexOf(dateFilter) > -1 || dateFilter === "")) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }       
        }
    }

    ///***Nous permet de faire des recherches***///
        document.getElementById('searchInput').addEventListener('keyup', function() {
        var input = document.getElementById('searchInput');
        var filter = input.value.toLowerCase();
        var table = document.getElementById('example2');
        var tr = table.getElementsByTagName('tr');

        for (var i = 1; i < tr.length; i++) {
            var tdArray = tr[i].getElementsByTagName('td');
            var match = false;
            for (var j = 0; j < tdArray.length; j++) {
                if (tdArray[j]) {
                    var txtValue = tdArray[j].textContent || tdArray[j].innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }
            }
            if (match) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }); 
   </script> 

@endsection