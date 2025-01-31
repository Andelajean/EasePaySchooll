<!--<aside class="main-sidebar sidebar-dark-primary elevation-4">-->
   <!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

          
  <div class="toggle-sidebar">
    <!-- Sidebar user panel (optional) -->
    

    <!-- SidebarSearch Form -->
    <br>
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        
        <!--  gestion des etudiant -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Banque
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route("show.all.bank") }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Liste Des Banques</p>
              </a>
            </li>
            <li class="nav-item">
            <a href="{{ route("add.bank") }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ajouter une Banque</p>
              </a>
            </li>
            
          </ul>
        </li>
        <!-- Gestion des Ecole -->

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Ecoles
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route("show.all.Ecole") }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Liste Des Ecoles</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route("add.Ecole") }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ajouter une Ecole</p>
              </a>
            </li>
            
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
               Paiements 
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
            @foreach($ecoles as $ecole)
                @if(isset($ecole->id))
                    <a href="{{ route('show.paiement.parEcole', $ecole->id) }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>  
                        <p>{{ $ecole->nom_ecole }}</p>
                    </a>
                @endif
            @endforeach

            </li>
            <li class="nav-item">
              <a href="{{ route("show.all.paiement") }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Listes des paiements</p>
              </a>
            </li>
             
           
            
          </ul>
        </li>

        <li class="nav-item">
        <a href="{{ route("show.all.Contact") }}" class="nav-link"> 
                <i class="far fa-circle nav-icon"></i>  
                <p>Personnes Contactees</p>
        </a>
        </li>

        <li class="nav-item">
        <a href="{{ route("sql") }}" class="nav-link"> 
                <i class="far fa-circle nav-icon"></i>  
                <p>SQL REQUEST</p>
        </a>
        </li>

        <li class="nav-item">
        <a href="{{ route("statistics.index") }}" class="nav-link"> 
                <i class="far fa-circle nav-icon"></i>  
                <p>Statistiques du site</p>
        </a>
        </li>
       

       
       
        
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>

  <!-- /.sidebar -->
</aside>
