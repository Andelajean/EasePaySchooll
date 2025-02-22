<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Rapport des Paiements pour la : {{ $banque }} </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="/assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/themify-icons.css">
    <link rel="stylesheet" href="/assets/css/metisMenu.css">
    <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/css/slicknav.min.css">
     <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('image/site.webmanifest') }}">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="/assets/css/typography.css">
    <link rel="stylesheet" href="/assets/css/default-css.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="/assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
   
    <div id="preloader">
        <div class="loader"></div>
    </div>
   
    <div class="page-container">
       
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                                          <h4 class="user-name dropdown-toggle" data-toggle="dropdown">
    @if(Session::has('ecole'))
        {{ Session::get('ecole')->nom_ecole }}  
    @else
        Invité <!-- Si aucune école n'est connectée, afficher 'Invité' -->
    @endif
    <i class="fa fa-angle-down"></i>
</h4>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li class="active">
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>Paiement</span></a>
                                <ul class="collapse">
                                    <li><a href="{{route('dashboard_ecole')}}">Paiement D'Aujourd'hui</a></li>
                                    <li><a href="{{route('classe')}}">Paiement Par Classe</a></li>
                                    <li ><a href="{{route('banque')}}">Paiement Par Banque</a></li>
                                    <li class="active"><a href="{{route('tranche')}}">Paiement Par Tranche</a></li>
                                    <li ><a href="{{route('banque_classe')}}">Paiement Par Classe et Par Banque</a></li>
                                    <li ><a href="{{route('classe_tranche')}}">Paiement Par Classe et Par Tranche</a></li>
                                    <li><a href="{{route('tout')}}">Tous les Paiements</a></li>
                                </ul>
                            </li>
                           <li >
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-layout-sidebar-left"></i><span>Materiel</span></a>
                                <ul class="collapse">
                                <li ><a href="{{route('reception')}}">Receptionner le Materiel</a></li>
                                <li ><a href="/materiel/ecole/recu">Materiel Recu</a></li>
                                </ul>
                            </li>
                            <li >
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-slice"></i><span>Uniforme Scolaire</span></a>
                                <ul class="collapse">
                                <li ><a href="{{route('distribution')}}">Distribution Des Uniformes Scolaires</a></li>
                                <li><a href="{{route('distribuer')}}">Liste Des Uniformes Distribués</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                                          <div class="search-box pull-left">
    <form action="#">
        <input type="text" id="search-input" name="search" placeholder="Rechercher un élève, entrez son Nom" required>
        <i class="ti-search"></i>
    </form>
    <ul id="suggestions" class="list-group" style="display: none;"></ul>
</div>
        
                    </div>
                  </div> 
            </div>
            <!-- header area end -->
           <!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Dashboard</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('dashboard_ecole') }}">Home</a></li>
                    <li><span>Paiement Par Tranche</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            <!-- Sélection de la Banque -->
            <form action="{{ route('tranche') }}" method="GET">
                <div class="form-group">
                    <label for="classe">Choisissez la Tranche :</label>
                    <select id="classe" name="classe" class="form-control" onchange="this.form.submit()">
                        @if ($classes->isNotEmpty())
                            @foreach ($classes as $classe)
                                <option value="{{ $classe }}" {{ $classe == $classeSelectionnee ? 'selected' : '' }}>
                                    {{ $classe }}
                                </option>
                            @endforeach
                        @else
                            <option value="">Aucune Tranche disponible</option>
                        @endif
                    </select>
                </div>
            </form>
            <!-- Sélection de la Date -->
            <div class="form-group mb-2">
    <label for="date" class="mr-2">Date:</label>
    <form action="{{ route('tranche') }}" method="GET">
        <input type="date" class="form-control" id="date" name="date" required>
        <button type="submit" class="btn btn-primary mt-2">Rechercher</button>
    </form>
</div>

        </div>
        <!-- Sélection Période de Paiement -->
        <div class="col-sm-6 clearfix">
            <form action="{{ route('tranche') }}" method="GET">
                <div class="form-group">
                    <label for="periode">Choisissez la Période de Paiement :</label>
                    <select id="periode" name="periode" class="form-control" onchange="this.form.submit()">
                        <option value="today" {{ request('periode') == 'today' ? 'selected' : '' }}>Paiements Aujourd'hui</option>
                        <option value="yesterday" {{ request('periode') == 'yesterday' ? 'selected' : '' }}>Paiements Hier</option>
                        <option value="all" {{ request('periode') == 'all' ? 'selected' : '' }}>Tous les Paiements</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- main content start -->
<div class="main-content-inner">
    <!-- Sales report area -->
   <div class="sales-report-area mt-5 mb-5">
    <div class="row">
        <!-- Paiements Aujourd'hui -->
        <div class="col-md-4">
            <div class="single-report mb-xs-30">
                <div class="s-report-inner pr--20 pt--30 mb-3">
                    <div class="icon"><i class="fa fa-btc"></i></div>
                    <div class="s-report-title d-flex justify-content-between">
                        <h4 class="header-title mb-0">Paiements Aujourd'hui</h4>
                    </div>
                    <div class="d-flex justify-content-between pb-2">
                        <h2>{{ count($paiementsAujourdhui) }}</h2>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Paiements Hier -->
        <div class="col-md-4">
            <div class="single-report mb-xs-30">
                <div class="s-report-inner pr--20 pt--30 mb-3">
                    <div class="icon"><i class="fa fa-btc"></i></div>
                    <div class="s-report-title d-flex justify-content-between">
                        <h4 class="header-title mb-0">Paiements Hier</h4>
                    </div>
                    <div class="d-flex justify-content-between pb-2">
                        <h2>{{ count($paiementsHier) }}</h2>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Total Paiements -->
        <div class="col-md-4">
            <div class="single-report">
                <div class="s-report-inner pr--20 pt--30 mb-3">
                    <div class="icon"><i class="fa fa-eur"></i></div>
                    <div class="s-report-title d-flex justify-content-between">
                        <h4 class="header-title mb-0">Total Paiements</h4>
                    </div>
                    <div class="d-flex justify-content-between pb-2">
                        <h2>{{ count($paiementsTotal) }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



    <!-- Tableau des Paiements -->
<div class="row mt-5 mb-5">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-center">
                    <h4 class="header-title mb-0" id="table-header">
                        @if(request('periode') == 'yesterday')
                            Paiements d'Hier
                        @elseif(request('date'))  <!-- Vérifie si une date est sélectionnée -->
                            Paiements du {{ request('date') }}
                        @elseif(request('periode') == 'all')
                            Tous les Paiements
                        @else
                            Paiements d'Aujourd'hui
                        @endif
                       
                    </h4>
                    
                    <!-- Bouton Imprimer -->
                    <button class="btn btn-primary" onclick="printTable()">Imprimer</button>
                </div>

                

                <div class="market-status-table mt-4">
                    <div class="table-responsive">
                        <table class="dbkit-table">
                            <tr class="heading-td">
                                <td class="mv-icon">Nom Étudiant/Élève</td>
                                <td class="coin-name">Classe</td>
                                <td class="buy">Banque de Paiement</td>
                                <td class="sell">Date Paiement</td>
                                <td class="trends">Heure Paiement</td>
                               
                                 <td class="stats-chart">Detail</td>
                            </tr>

                            <!-- Paiements Aujourd'hui ou Date Sélectionnée -->
                            @if(request('periode') == 'today' || request('date'))
                                @forelse($paiementsAujourdhui as $paiement)
                                    <tr>
                                        <td>{{ $paiement->nom_complet }}</td>
                                        <td>{{ $paiement->classe }}</td>
                                        <td>{{ $paiement->banque }}</td>
                                        <td>{{ $paiement->date_paiement }}</td>
                                        <td>{{ $paiement->heure_paiement }}</td>
                                        
                                        <td>{{ $paiement->details }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">Aucun paiement pour la période sélectionnée.</td>
                                    </tr>
                                @endforelse
                                <div class="pagination mt-4">
                                    {{ $paiementsAujourdhui->links() }}
                                </div>
                            @endif

                            <!-- Paiements Hier -->
                            @if(request('periode') == 'yesterday')
                                @forelse($paiementsHier as $paiement)
                                    <tr>
                                        <td>{{ $paiement->nom_complet }}</td>
                                        <td>{{ $paiement->classe }}</td>
                                        <td>{{ $paiement->banque }}</td>
                                        <td>{{ $paiement->date_paiement }}</td>
                                        <td>{{ $paiement->heure_paiement }}</td>
                                       
                                        <td>{{ $paiement->details }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">Aucun paiement effectué hier.</td>
                                    </tr>
                                @endforelse
                                <div class="pagination mt-4">
                                    {{ $paiementsHier->links() }}
                                </div>
                            @endif

                            <!-- Tous les Paiements -->
                            @if(request('periode') == 'all')
                                @forelse($paiementsTotal as $paiement)
                                    <tr>
                                        <td>{{ $paiement->nom_complet }}</td>
                                        <td>{{ $paiement->classe }}</td>
                                        <td>{{ $paiement->banque }}</td>
                                        <td>{{ $paiement->date_paiement }}</td>
                                        <td>{{ $paiement->heure_paiement }}</td>
                                        
                                        <td>{{ $paiement->details }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">Aucun paiement disponible.</td>
                                    </tr>
                                @endforelse
                                <div class="pagination mt-4">
                                    {{ $paiementsTotal->links() }}
                                </div>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- main content end -->

<!-- main content end -->
<div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- En-tête de la modale avec la croix rouge pour fermer -->
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalLabel">Détails de l'élève</h5>
                <button type="button" class="btn-close"  id="close-modal-btn"data-bs-dismiss="modal" aria-label="Fermer" style="color: red; font-size: 1.5rem;">&times;</button>
            </div>
            <!-- Corps de la modale avec le tableau de détails -->
            <div class="modal-body">
                <table id="student-details-table" class="table table-striped">
                    <!-- Les détails de l'élève seront insérés ici via JavaScript -->
                </table>
            </div>
            <!-- Pied de page de la modale avec un bouton rouge pour fermer -->
            <div class="modal-footer">
                <button type="button" id="close-modal-btn" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>



        <footer>
    <div class="footer-area">
        <p>© Copyright <?php echo date('Y'); ?>. All rights reserved. Develop By <a href="#">Smart Tech Engineering</a>.</p>
    </div>
</footer>

        <!-- footer area end-->
    </div>
   
    <script src="/assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/owl.carousel.min.js"></script>
    <script src="/assets/js/metisMenu.min.js"></script>
    <script src="/assets/js/jquery.slimscroll.min.js"></script>
    <script src="/assets/js/jquery.slicknav.min.js"></script>
 <script src="/jscript/search_paiement.js"></script>
    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <!-- all line chart activation -->
    <script src="/assets/js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="/assets/js/pie-chart.js"></script>
    <!-- others plugins -->
    <script src="/assets/js/plugins.js"></script>
    <script src="/assets/js/scripts.js"></script>
    <script src="/jscript/banque_impression.js"></script>
</body>
</html>
