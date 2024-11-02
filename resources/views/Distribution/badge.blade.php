<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Rapport de distribution de polo pour la classe de :</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('image/site.webmanifest') }}">

    <!-- CSS Stylesheets -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/themify-icons.css">
    <link rel="stylesheet" href="/assets/css/metisMenu.css">
    <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/css/slicknav.min.css">
    <link rel="stylesheet" href="/assets/css/typography.css">
    <link rel="stylesheet" href="/assets/css/default-css.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />

    <!-- Modernizr JS -->
    <script src="/assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body>

    <!-- Preloader -->
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <!-- Page Container -->
    <div class="page-container">
        <!-- Sidebar Menu -->
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
                            <!-- Paiement Menu -->
                            <li >
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>Paiement</span></a>
                                <ul class="collapse">
                                    <li><a href="{{route('dashboard_ecole')}}">Paiement D'Aujourd'hui</a></li>
                                    <li><a href="{{route('classe')}}">Paiement Par Classe</a></li>
                                    <li ><a href="{{route('niveau')}}">Paiement Par Niveau</a></li>
                                    <li ><a href="{{route('filiere')}}">Paiement Par Filiere</a></li>
                                    <li ><a href="{{route('banque')}}"> Paiement Par Banque</a></li>
                                     <li class="active"><a href="{{route('banque_classe')}}">Paiement Par Classe et Par Banque</a></li>
                                    <li ><a href="{{route('classe_filiere')}}">Paiement Par Classe et Par Filiere</a></li>
                                    <li ><a href="{{route('classe_tranche')}}">Paiement Par Classe et Par Tranche</a></li>
                                    <li><a href="{{route('tranche')}}">Paiement Par Tranche</a></li>
                                    <li><a href="{{route('tout')}}">Tous les Paiements</a></li>
                                </ul>
                            </li>
                            <!-- Uniforme Menu -->
                            <li class="active">
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-layout-sidebar-left"></i><span>Uniforme</span></a>
                                <ul class="collapse">
                                    <li><a href="{{route('fac.distribuer_polo')}}">Distribuer Les Polo</a></li>
                                    <li><a href="{{route('fac.distribuer_badge')}}">Distribuer Les Badges</a></li>
                                    <li class="active"><a href="{{route('fac.badge')}}">Liste des Badges Distribués</a></li>
                                    <li ><a href="{{route('fac.polo')}}">Liste des Polo Distribués</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header-area">
                <div class="row align-items-center">
                    <!-- Navigation and Search -->
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

            <!-- Page Title Area -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Uniforme</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="{{ route('dashboard_ecole') }}">Distribution</a></li>
                                <li><span>Badge</span></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Class Selection Form -->
                    <div class="col-sm-6 clearfix">
                        <form action="{{ route('fac.badge') }}" method="GET">
                            <div class="form-group">
                                <label for="classe">Choisissez la classe :</label>
                                <select name="classe" id="classe" class="form-control" onchange="this.form.submit()">
                                    @foreach ($classes as $classe)
                                        <option value="{{ $classe }}" {{ $classe == request('classe') ? 'selected' : '' }}>{{ $classe }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Rechercher</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Payment Table -->
            <div class="row mt-5 mb-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-center">
                                <h4 class="header-title mb-0" id="table-header">Liste des Badges recu par classe !!</h4>
                                <button class="btn btn-primary" onclick="printTable()">Imprimer</button>
                            </div>
                            <div class="market-status-table mt-4">
                                <div class="table-responsive">
                                    <table class="dbkit-table">
                                        <tr class="heading-td">
                                            <td class="mv-icon">Nom Étudiant/Élève</td>
                                            <td class="coin-name">Classe</td>
                                            <td class="buy">Banque de Paiement</td>
                                            <td class="sell">Date Distribution</td>
                                            <td class="attachments">Filière</td>
                                            <td class="stats-chart">Niveau</td>
                                        </tr>
                                        @foreach ($paiement as $paiements)
                                            <tr>
                                                <td>{{ $paiements->nom_etudiant }}</td>
                                                <td>{{ $paiements->classe }}</td>
                                                <td>{{ $paiements->banque }}</td>
                                                <td>{{ $paiements->created_at }}</td>
                                                <td>{{ $paiements->filiere }}</td>
                                                <td>{{ $paiements->niveau_université }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <!-- Pagination -->
                                    {{ $paiement->links() }}
                                </div>
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


        <!-- Footer -->
        <footer>
            <div class="footer-area">
                <p>© Copyright <?php echo date('Y'); ?>. All rights reserved. Develop By <a href="https://colorlib.com/wp/">Smart Tech Engineering</a>.</p>
            </div>
        </footer>
    </div>

    <!-- JavaScript Files -->
    <script src="/assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/owl.carousel.min.js"></script>
    <script src="/assets/js/metisMenu.min.js"></script>
    <script src="/assets/js/jquery.slimscroll.min.js"></script>
    <script src="/assets/js/jquery.slicknav.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/"; ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];</script>
    <script src="/assets/js/line-chart.js"></script>
    <script src="/assets/js/pie-chart.js"></script>
    <script src="/assets/js/plugins.js"></script>
    <script src="/assets/js/scripts.js"></script>
    <script src="/jscript/banque_impression.js"></script>
     <script src="/jscript/search_badge.js"></script>
</body>
</html>
