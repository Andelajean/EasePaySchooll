<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Rapport De Distribution des uniformes pour la classe:{{$classeSelectionnee}} </title>
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
                            <li >
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>Paiement</span></a>
                                <ul class="collapse">
                                    <li><a href="{{route('dashboard_ecole')}}">Paiement D'Aujourd'hui</a></li>
                                    <li ><a href="{{route('classe')}}">Paiement Par Classe</a></li>
                                    <li ><a href="{{route('banque')}}">Paiement Par Banque</a></li>
                                    <li ><a href="{{route('tout')}}">Tous les Paiements</a></li>
                                </ul>
                            </li>
                            <li >
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-layout-sidebar-left"></i><span>Materiel</span></a>
                                <ul class="collapse">
                                <li ><a href="{{route('reception')}}">Receptionner le Materiel</a></li>
                                <li ><a href="/materiel/ecole/recu">Materiel Recu</a></li>
                                </ul>
                            </li>
                             <li class="active">
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-slice"></i><span>Uniforme Scolaire</span></a>
                                <ul class="collapse">
                                <li ><a href="{{route('distribution')}}">Distribution Des Uniformes Scolaires</a></li>
                                <li class="active"><a href="{{route('distribuer')}}">Liste Des Uniformes Distribués</a></li>
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
                    <li><a href="{{ route('dashboard_ecole') }}">Uniforme</a></li>
                    <li><span>Distribution par classe</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">  
 <form action="{{ route('distribuer') }}" method="GET" id="classeForm">
    <div class="form-group mb-2">
        <label for="classe">Choisissez une Classe :</label>
        <select id="classe" name="classe" class="form-control" onchange="document.getElementById('classeForm').submit();">
            @if ($classes->isNotEmpty())
                @foreach ($classes as $classe)
                    <option value="{{ $classe }}" {{ request('classe') == $classe ? 'selected' : '' }}>
                        {{ $classe }}
                    </option>
                @endforeach
            @else
                <option value="">Aucune Classe disponible</option>
            @endif
        </select>
    </div>
     <button type="submit" class="btn btn-primary mt-3">Chercher</button>
</form>


</div>
</div>
<!-- main content start -->
<div class="main-content-inner">
    <!-- Sales report area -->
   <div class="sales-report-area mt-5 mb-5">
    <!-- Tableau des Paiements -->
<div class="row mt-5 mb-5">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-center">
                    <h4 class="header-title mb-0" id="table-header">
                        Liste des uniformes distribués par classe
                    </h4>
                    <!-- Bouton Imprimer -->
                    <button class="btn btn-primary" onclick="printTable()">Imprimer</button>
                </div>

                <div class="market-status-table mt-4">
                    <div class="table-responsive">
                        @if(!empty($materiels) && $materiels->isNotEmpty())
    <table class="dbkit-table">
        <thead>
            <tr class="heading-td">
                <td class="mv-icon">Nom Étudiant/Élève</td>
                <td class="coin-name">Classe</td>
                <td class="buy">Date Distribution</td>
                <td class="sell">Statut </td>
                <td class="trends">Reste</td>
            </tr>
        </thead>
        <tbody>
            @foreach($materiels as $materiel)
                <tr>
                    <td>{{ $materiel->nom_eleve }}</td>
                    <td>{{ $materiel->classe }}</td>
                    <td>{{ $materiel->created_at }}</td>
                    <td>{{ $materiel->uniforme }}</td>
                    <td>{{ $materiel->reste }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Aucun matériel trouvé pour cette classe.</p>
@endif
                    </div>
                </div>
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
   