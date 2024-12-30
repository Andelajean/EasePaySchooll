<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Matériel</title>
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
@php
    $materiel = session('materiel');
@endphp
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Détails du Matériel pour {{ $materiel->nom_eleve }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('materiel.update', ['id' => $materiel->id]) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="materiel">État du matériel :</label>
                        <select name="materiel" id="materiel" class="form-control">
                            <option value="ok" {{ $materiel->materiel === 'ok' ? 'selected' : '' }}>OK</option>
                            <option value="non_ok" {{ $materiel->materiel === 'non_ok' ? 'selected' : '' }}>NON OK</option>
                        </select>
                    </div>

                    <div class="form-group" id="materiel_restante_group" style="{{ $materiel->materiel === 'non_ok' ? '' : 'display:none;' }}">
                        <label for="reste">Liste du matériel manquant :</label>
                        <input type="text" name="reste" value="{{ $materiel->reste }}" class="form-control" placeholder="Matériel manquant">
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
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
     <script src="/jscript/reception.js"></script>

    <!-- Script pour afficher/cacher le champ "materiel_restante_group" en fonction de l'option sélectionnée -->
    <script>
       document.getElementById('materiel').addEventListener('change', function () {
            var resteGroup = document.getElementById('materiel_restante_group');
            var resteField = document.getElementById('reste');

            // Affiche ou cache le champ "reste" en fonction de la sélection
            if (this.value === 'non_ok') {
                resteGroup.style.display = 'block';
                resteField.setAttribute('required', 'required'); // Rend le champ obligatoire
            } else {
                resteGroup.style.display = 'none';
                resteField.removeAttribute('required'); // Supprime l'obligation du champ
            }
        });
    </script>
</body>
</html>
