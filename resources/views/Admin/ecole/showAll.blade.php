@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <center><h1>Information Relative a chaque Ecole</h1></center>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
        @if (Session::has('success'))
         <div class="alert alert-warning"> {{ Session::get('success') }} </div>
        @endif
        @if (Session::has('update'))
         <div class="alert alert-success"> {{ Session::get('update') }} </div>
        @endif
        @if (Session::has('delete'))
         <div class="alert alert-success"> {{ Session::get('delete') }} </div>
        @endif
        @if (Session::has('ajoute'))
         <div class="alert alert-success"> {{ Session::get('delete') }} </div>
        @endif
        @if (Session::has('Erreur'))
         <div class="alert alert-warning"> {{ Session::get('delete') }} </div>
        @endif
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover" style="writing-mode: vertical-lr;">
                  <thead>
                  <tr>
                  <th style="writing-mode: horizontal-tb;">id</th>  
                  <th style="writing-mode: horizontal-tb;">identifiant_unique</th>
                  <th style="writing-mode: horizontal-tb;">nom_ecole</th>
                  <th style="writing-mode: horizontal-tb;">email</th> 
                  <th style="writing-mode: horizontal-tb;">Ville</th>
                  <th style="writing-mode: horizontal-tb;">telephone</th>
                  <th style="writing-mode: horizontal-tb;">nom_banque1</th>
                  <th style="writing-mode: horizontal-tb;">numero_banque1</th>
                  <th style="writing-mode: horizontal-tb;">nom_banque2</th>
                  <th style="writing-mode: horizontal-tb;">numero_banque2</th>
                  <th style="writing-mode: horizontal-tb;">nom_banque3</th>
                  <th style="writing-mode: horizontal-tb;">numero_banque3</th>
                  <th style="writing-mode: horizontal-tb;">nom_banque4</th>
                  <th style="writing-mode: horizontal-tb;">numero_banque4</th>
                  <th style="writing-mode: horizontal-tb;">nom_banque5</th>
                  <th style="writing-mode: horizontal-tb;">numero_banque5</th>
                  <th style="writing-mode: horizontal-tb;">nom_banque6</th>
                  <th style="writing-mode: horizontal-tb;">numero_banque6</th>
                  <th style="writing-mode: horizontal-tb;">nom_banque7</th>
                  <th style="writing-mode: horizontal-tb;">numero_banque7</th>
                  <th style="writing-mode: horizontal-tb;">nom_banque8</th>
                  <th style="writing-mode: horizontal-tb;">numero_banque8</th>

                  </tr>
                  </thead>
                  <tbody>
                  @foreach($Ecole as $p)
                  <tr>

                    <td style="writing-mode: horizontal-tb;">{{ $p->id }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->identifiant }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->nom_ecole }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->email }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->ville }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->telephone }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->nom_banque1 }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->numero_banque1 }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->nom_banque2 }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->numero_banque2 }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->nom_banque3 }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->numero_banque3 }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->nom_banque4 }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->numero_banque4 }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->nom_banque5 }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->numero_banque5 }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->nom_banque6 }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->numero_banque6 }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->nom_banque7 }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->numero_banque7 }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->nom_banque8 }}</td>
                    <td style="writing-mode: horizontal-tb;">{{ $p->numero_banque8 }}</td>
                    <td style="writing-mode: horizontal-tb;"> <ul class="list-inline m-0">
                          <li class="list-inline-item">
                          <a href="{{ route('editEcole',$p->id)  }}">  <button class="btn btn-success btn-sm rounded-2" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button></a>
                          </li>
                          <li class="list-inline-item">
                            <a href="{{ route('deleteEcole',$p->id ) }}"> <button class="btn btn-danger btn-sm rounded-2" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button></a>
                          </li>  
                        </ul></td>
                  </tr>

                   @endforeach
                  
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

@endsection