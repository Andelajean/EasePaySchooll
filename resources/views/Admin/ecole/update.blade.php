@extends('layouts.admin')

@section('content')
   
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            @if (Session::has('success'))
            <div class="alert alert-warning"> {{ Session::get('success') }} </div>
            @endif
            @if (Session::has('update'))
            <div class="alert alert-success"> {{ Session::get('update') }} </div>
            @endif
            @if (Session::has('delete'))
            <div class="alert alert-danger"> {{ Session::get('delete') }} </div>
            @endif
            @if (Session::has('ajoute'))
            <div class="alert alert-success"> {{ Session::get('ajoute') }} </div>
            @endif
            @if (Session::has('error'))
            <div class="alert alert-warning"> {{ Session::get('error') }} </div>
            @endif
            </div>
        <div class="row mb-2">
          <div class="col-sm-6">
          
            <h1>Modifier Une Ecole</h1>
           
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Information sur l'ecole</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
                 <div class="col-md-6">
                  <form  action="{{ route('update.ecole') }}" method="POST" >

                     @csrf
                     
                       <div class="form-group">
                          <label>Email</label>
                          <input type="email" name="email" class="form-control" value="{{ $ecoles->email }}">
                        </div>
                        <!-- /.form-group -->
                         <div class="form-group">
                            <label>Nom ecole</label>
                            <input type="name" name="nom_ecole" class="form-control" value="{{ $ecoles->nom_ecole }}">
                          </div>
                        <!-- /.form-group -->
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Banque1</label>
                          <input type="text" name="nom_banque1" class="form-control " value="{{ $ecoles->nom_banque1 }}">
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Numero1</label>
                            <input type="text" name="numero_banque1" class="form-control " value="{{ $ecoles->numero_banque1 }}">
                          </div>
                        <!-- /.form-group -->
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Banque2</label>
                          <input type="text" name="nom_banque2" class="form-control " value="{{ $ecoles->nom_banque2 }}">
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Numero2</label>
                            <input type="text" name="numero_banque2" class="form-control " value="{{ $ecoles->numero_banque2 }}">
                          </div>
                        <!-- /.form-group -->
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Banque3</label>
                          <input type="text" name="nom_banque3" class="form-control " value="{{ $ecoles->nom_banque3 }}">
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Numero3</label>
                            <input type="text" name="numero_banque3" class="form-control " value="{{ $ecoles->numero_banque3 }}">
                          </div>
                        <!-- /.form-group -->
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Banque4</label> 
                          <input type="text" name="nom_banque4" class="form-control " value="{{ $ecoles->nom_banque4 }}">
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Numero4</label>
                            <input type="text" name="numero_banque4" class="form-control " value="{{ $ecoles->numero_banque4 }}">
                          </div>
                        <!-- /.form-group -->
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Banque5</label>
                          <input type="text" name="nom_banque5" class="form-control " value="{{ $ecoles->nom_banque5 }}">
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Numero5</label>
                            <input type="text" name="numero_banque5" class="form-control " value="{{ $ecoles->numero_banque5 }}">
                          </div>
                        <!-- /.form-group -->
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Banque6</label>
                          <input type="text" name="nom_banque6" class="form-control " value="{{ $ecoles->nom_banque6 }}">
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Numero6</label>
                            <input type="text" name="numero_banque6" class="form-control " value="{{ $ecoles->numero_banque6 }}" >
                          </div>
                        <!-- /.form-group -->
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Banque7</label>
                          <input type="text" name="nom_banque7" class="form-control " value="{{ $ecoles->nom_banque7 }}">
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Numero7</label>
                            <input type="text" name="numero_banque7" class="form-control " value="{{ $ecoles->numero_banque7 }}" >
                          </div>
                        <!-- /.form-group -->
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Banque8</label>
                          <input type="text" name="nom_banque8" class="form-control " value="{{ $ecoles->nom_banque8 }}">
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Numero8</label>
                            <input type="text" name="numero_banque8" class="form-control " value="{{ $ecoles->numero_banque8 }}" >
                          </div>
                        <!-- /.form-group -->
                      </div>
                
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Numero de Telephone</label>
                            <input type="text" name="tel" class="form-control" value="{{ $ecoles->telephone }}">
                          </div>
                          <div class="form-group">
                            <label>Ville</label>
                            <input type="text" name="ville" class="form-control" value="{{ $ecoles->ville }}">
                          </div>
                        <!-- /.form-group -->
                    
                        <!-- /.form-group -->
                      </div>
                            
                      <input type="hidden" name="id" value="{{ $ecoles->id }}">
                      <input type="submit" value="Modifier" class="btn btn-primary">        
                  </form>      
  

              
            </div>

          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      
      
      
      </div>

      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->



  @endsection