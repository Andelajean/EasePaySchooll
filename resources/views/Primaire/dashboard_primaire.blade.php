<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Dashboard Ecole</title>
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
        Invité 
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
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>dashboard</span></a>
                                <ul class="collapse">
                                    <li class="active"><a href="{{route('dashboard_ecole')}}">Paiement D'Aujourd'hui</a></li>
                                    <li><a href="{{route('classe')}}">Paiement Par Classe</a></li>
                                    <li><a href="{{route('banque')}}">Paiement Par Banque</a></li>
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
                                <li><a href="{{route('dashboard_ecole')}}"> Home</a></li>
                                <li><span>Accueil</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown">
    @if(Session::has('ecole'))
        {{ Session::get('ecole')->nom_ecole }}  
    @else
        Invité 
    @endif
    <i class="fa fa-angle-down"></i>
</h4>
                            <div class="dropdown-menu">
                                
                                <a class="dropdown-item" href="{{route('logoute')}}">Se Deconnecter</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
   <div class="main-content-inner">
                <!-- sales report area start -->
                <div class="sales-report-area mt-5 mb-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="single-report mb-xs-30">
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                    <div class="icon"><i class="fa fa-btc"></i></div>
                                     <div class="s-report-title d-flex justify-content-between">
                                         <h4 class="header-title mb-0">Paiements d'aujourd'hui</h4>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h2>{{ $nombrePaiementsAujourdhui }}</h2>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single-report mb-xs-30">
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                    <div class="icon"><i class="fa fa-btc"></i></div>
                                     <div class="s-report-title d-flex justify-content-between">
                        <h4 class="header-title mb-0">Paiements d'hier</h4>
                    </div>
                    <div class="d-flex justify-content-between pb-2">
                        <h2>{{ $nombrePaiementsHier }}</h2> <!-- Affichage du nombre de paiements -->
                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single-report">
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                    <div class="icon"><i class="fa fa-eur"></i></div>
                                     <div class="s-report-title d-flex justify-content-between">
                        <h4 class="header-title mb-0">Tous les paiements</h4>
                    </div>
                    <div class="d-flex justify-content-between pb-2">
                        <h2>{{ $totalNombrePaiements }}</h2> <!-- Affichage du nombre de paiements -->
                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

              
                <div class="row mt-5 mb-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <h4 class="header-title mb-0">Paiements D'Aujourd'hui</h4>
                                </div>
                                <div class="market-status-table mt-4">
                                    <div class="table-responsive">
                                        <table class="dbkit-table">
                                            <tr class="heading-td">
                                                <td class="mv-icon">Nom Etudiant/Eleve</td>
                                                <td class="coin-name">Classe</td>
                                                <td class="buy">Banque de Paiement</td>
                                                <td class="sell">Date Paiement</td>
                                                <td class="trends">Heure Paiement</td>
                                               
                                            </tr>
                                            @forelse($paiementsAujourdhui as $paiement)
            <tr>
                <td>{{ $paiement->nom_complet }}</td>
                <td>{{ $paiement->classe }}</td>
                <td>{{ $paiement->banque }}</td>
                <td>{{ $paiement->created_at->format('d/m/Y') }}</td>
                <td>{{ $paiement->created_at->format('H:i') }}</td>
               
            </tr>
            @empty
            <tr>
                <td colspan="7">Aucun paiement effectué aujourd'hui.</td>
            </tr>
            @endforelse
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
        <p>© Copyright <?php echo date('Y'); ?>. All rights reserved. Develop By <a href="https://colorlib.com/wp/">Smart Tech Engineering</a>.</p>
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
     <script src="/jscript/search_paiement.js"></script>
    <!-- all line chart activation -->
    <script src="/assets/js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="/assets/js/pie-chart.js"></script>
    <!-- others plugins -->
    <script src="/assets/js/plugins.js"></script>
    <script src="/assets/js/scripts.js"></script>
</body>

</html>
