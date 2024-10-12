<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paiement</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css?family=Exo:400,700" rel="stylesheet">
  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('image/site.webmanifest') }}">
  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="/style/style.css" rel="stylesheet">
  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body >
  @include('navbar')
  <!-- Loader  -->
  <div id="loader" class="fixed inset-0 bg-white z-50 flex items-center justify-center">
    <div class="loader"></div>
  </div>
 
  <!-- Section d'animation (background fixe) -->
  <div class="area">
    <ul class="circles">
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
    </ul>
  </div>
   <div class="container mx-auto">
        <!-- Barre de recherche -->
       <div class="mb-6 relative mt-20 w-1/2 mx-auto">
         <input id="search" type="text" placeholder="Rechercher une école" class="border p-2 w-full mb-4">

        <!-- Liste des résultats -->
        <ul id="result-list" class="border hidden max-h-40 overflow-y-auto bg-white shadow-md"></ul>

       </div>


        <!-- Formulaire d'information de l'école et de l'étudiant -->
        <div id="form-container" class="p-6 hidden">
            <h2 class="text-lg font-bold mb-4">Informations de l'École</h2>
            <form id="school-form">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="nom_ecole" class="block text-sm font-medium text-gray-700">Nom de l'École</label>
                        <input type="text" id="nom_ecole" class="mt-1 block w-full p-2 border rounded" readonly>
                    </div>
                    <div>
                        <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <input type="text" id="telephone" class="mt-1 block w-full p-2 border rounded" readonly>
                    </div>
                    <div>
                        <label for="ville" class="block text-sm font-medium text-gray-700">Ville</label>
                        <input type="text" id="ville" class="mt-1 block w-full p-2 border rounded" readonly>
                    </div>
                    <div>
                        <label for="banque" class="block text-sm font-medium text-gray-700">Banque de Paiement</label>
                        <select id="banque" class="mt-1 block w-full p-2 border rounded">
                            <option value="">Sélectionnez une banque</option>
                        </select>
                    </div>
                </div>

                <!-- Autres champs du formulaire -->
                <h2 class="text-lg font-bold mt-6 mb-4">Informations de l'Étudiant</h2>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="nom_etudiant" class="block text-sm font-medium text-gray-700">Nom Complet de l'Étudiant</label>
                        <input type="text" id="nom_etudiant" class="mt-1 block w-full p-2 border rounded">
                    </div>
                    <div>
                        <label for="classe" class="block text-sm font-medium text-gray-700">Classe</label>
                        <input type="text" id="classe" class="mt-1 block w-full p-2 border rounded">
                    </div>
                    <div>
                        <label for="niveau" class="block text-sm font-medium text-gray-700">Niveau</label>
                        <select id="niveau" class="mt-1 block w-full p-2 border rounded">
                            <option value="primaire">Primaire</option>
                            <option value="seconde">Seconde</option>
                            <option value="université">Université</option>
                        </select>
                    </div>
                    <div>
                        <label for="motif" class="block text-sm font-medium text-gray-700">Motif</label>
                        <input type="text" id="motif" class="mt-1 block w-full p-2 border rounded" value="Frais de scolarité" readonly>
                    </div>
                </div>

                <!-- Champs pour l'université -->
                <div id="university-fields" class="grid grid-cols-2 gap-4 mb-4 hidden">
                    <div>
                        <label for="filiere" class="block text-sm font-medium text-gray-700">Filière</label>
                        <input type="text" id="filiere" class="mt-1 block w-full p-2 border rounded">
                    </div>
                    <div>
                        <label for="niveau_universite" class="block text-sm font-medium text-gray-700">Niveau Universitaire</label>
                        <input type="text" id="niveau_universite" class="mt-1 block w-full p-2 border rounded">
                    </div>
                </div>

                <!-- Autres informations -->
                <div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <label for="montant" class="block text-sm font-medium text-gray-700">Montant</label>
        <input type="number" id="montant" class="mt-1 block w-full p-2 border rounded">
    </div>
    <div>
        <label for="montant_total" class="block text-sm font-medium text-gray-700">Montant Total</label>
        <input type="number" id="montant_total" class="mt-1 block w-full p-2 border rounded" readonly>
    </div>
</div>

                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Payer</button>
            </form>
        </div>
    </div>

    <script>
     $(document).ready(function() {
    var delayTimer;

    // Fonction pour effectuer la recherche à chaque frappe avec un délai de 300ms
    $('#search').on('input', function() {
        clearTimeout(delayTimer); // Reset du timer

        var query = $(this).val();

        delayTimer = setTimeout(function() {
            if (query.length > 0) {
                // Requête AJAX
                $.ajax({
                    url: '/search-school',
                    method: 'GET',
                    data: { query: query },
                    success: function(data) {
                        var resultList = $('#result-list');
                        resultList.empty(); // Vider la liste des résultats avant d'ajouter les nouveaux

                        if (data.length > 0) {
                            resultList.removeClass('hidden');
                            $.each(data, function(index, school) {
                                resultList.append('<li class="p-2 cursor-pointer hover:bg-gray-200" data-id="' + school.id + '">' + school.nom_ecole + '</li>');
                            });
                        } else {
                            resultList.addClass('hidden');
                        }
                    }
                });
            } else {
                $('#result-list').empty().addClass('hidden'); // Masquer les suggestions si aucun texte
            }
        }, 300); // 300ms de délai
    });

    // Sélection d'une école dans la liste des résultats
    $(document).on('click', '#result-list li', function() {
        var schoolId = $(this).data('id');

        // Requête pour récupérer les détails complets de l'école
        $.ajax({
            url: '/school/' + schoolId,
            method: 'GET',
            success: function(data) {
                if (data) {
                    // Pré-remplir les champs avec les détails de l'école
                    $('#nom_ecole').val(data.nom_ecole);
                    $('#telephone').val(data.telephone);
                    $('#ville').val(data.ville);
                    $('#montant_total').val(data.montant_total); // Champ Montant total

                    // Remplir la liste des banques (nom uniquement)
                    var banqueSelect = $('#banque');
                    banqueSelect.empty().append('<option value="">Sélectionnez une banque</option>');
                    for (var i = 1; i <= 8; i++) {
                        if (data['nom_banque' + i]) {
                            banqueSelect.append('<option value="' + data['nom_banque' + i] + '">' + data['nom_banque' + i] + '</option>');
                        }
                    }

                    // Masquer la liste des suggestions et afficher le formulaire
                    $('#result-list').empty().addClass('hidden');
                    $('#form-container').removeClass('hidden');
                }
            }
        });
    });

    // Afficher les champs spécifiques à l'université
    $('#niveau').on('change', function() {
        if ($(this).val() === 'université') {
            $('#university-fields').removeClass('hidden');
        } else {
            $('#university-fields').addClass('hidden');
        }
    });
});

    </script>


 <script src="/jscript/style.js">
  </script>
 

</body>
</html>
