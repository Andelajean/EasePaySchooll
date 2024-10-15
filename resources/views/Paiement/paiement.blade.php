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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
  <div class="max-w-3xl mx-auto p-6">
    <!-- Barre de recherche -->
    <div class="mb-6">
        <input type="text" id="search" placeholder="Rechercher une école..." class="border p-2 w-full" autocomplete="off">
        <ul id="result-list" class="mt-2 border p-2 w-full hidden"></ul> <!-- Résultats de recherche -->
    </div>

    <form id="schoolForm" class="hidden" method="POST" action="{{ route('payer') }}">
    @csrf
    <!-- Section 1: Informations sur l'école -->
    <h2 class="text-lg font-bold mb-4">Informations sur l'école</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <label for="nom_ecole">Nom de l'école</label>
            <input type="text" id="nom_ecole" name="nom_ecole" class="border p-2 w-full" readonly>
        </div>
        <div>
            <label for="telephone">Téléphone</label>
            <input type="text" id="telephone" name="telephone" class="border p-2 w-full" readonly>
        </div>
        <div>
            <label for="ville">Ville</label>
            <input type="text" id="ville" name="ville" class="border p-2 w-full" readonly>
        </div>
        <div>
            <label for="banque">Banque de paiement</label>
            <select id="banque" name="banque" class="border p-2 w-full" required></select>
        </div>
    </div>

    <!-- Section 2: Informations de l'étudiant -->
    <h2 class="text-lg font-bold mb-4">Informations de l'étudiant</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <label for="nom_complet">Nom complet de l'élève</label>
            <input type="text" id="nom_complet" name="nom_complet" class="border p-2 w-full" placeholder="Exemple : NGA NGA Benoit" required>
        </div>
        <div>
            <label for="classe">Classe</label>
            <input type="text" id="classe" name="classe" class="border p-2 w-full" placeholder="Exemple : CM2" required>
        </div>
        <div>
            <label for="niveau">Niveau</label>
            <select id="niveau" name="niveau" class="border p-2 w-full" required>
                <option value="primaire">Primaire</option>
                <option value="secondaire">Secondaire</option>
                <option value="université">Université</option>
            </select>
        </div>
        <!-- Champs pour l'université -->
        <div id="university-fields" class="hidden md:col-span-2">
            <label for="filiere">Filière</label>
            <input type="text" id="filiere" name="filiere" class="border p-2 w-full" placeholder="Exemple : Génie logiciel" required>
            <label for="niveau_universite">Niveau Universitaire</label>
            <input type="text" id="niveau_universite" name="niveau_universite" class="border p-2 w-full" placeholder="Exemple : Niveau 1" required>
        </div>
    </div>

    <!-- Section 3: Paiement -->
    <h2 class="text-lg font-bold mb-4">Détails du paiement</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <label for="montant">Montant</label>
            <input type="text" id="montant" name="montant" class="border p-2 w-full" placeholder="Exemple : 100 000" required>
        </div>
        <div>
            <label for="montant_total">Montant Total</label>
            <input type="text" id="montant_total" name="montant_total" class="border p-2 w-full" readonly>
        </div>
        <div>
            <label for="motif">Motif</label>
            <input type="text" id="motif" name="motif" class="border p-2 w-full" value="Frais de scolarité" readonly>
        </div>
        <div>
            <label for="details">
                Détails 
                <span class="text-red-700">*indiquez s'il s'agit d'une tranche de la scolarité ou de la totalité</span>
            </label>
            <textarea id="details" name="details" class="border p-2 w-full" placeholder="Exemple première tranche, deuxième tranche..." required></textarea>
        </div>
        <div>
            <label for="date_paiement">Date de paiement</label>
            <input type="date-local" id="date_paiement" name="date_paiement" class="border p-2 w-full" value="{{ date('Y-m-d\TH:i') }}" readonly>
        </div>
        <div>
            <label for="heure_paiement">Heure de paiement</label>
            <input type="text" id="heure_paiement" name="heure_paiement" class="border p-2 w-full" value="{{ date('H:i') }}" readonly>
        </div>
    </div>

    <!-- Boutons -->
    <div class="flex justify-between mt-4">
        <button type="button" id="annuler" class="bg-red-500 text-white px-4 py-2 rounded">Annuler</button>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Payer</button>
    </div>
</form>
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
                    for (var i = 1; i <= 6; i++) {
                        if (data['nom_banque' + i]) {
                            banqueSelect.append('<option value="' + data['nom_banque' + i] + '">' + data['nom_banque' + i] + '</option>');
                        }
                    }

                    // Masquer la liste des suggestions et afficher le formulaire
                    $('#result-list').empty().addClass('hidden');
                    $('#schoolForm').removeClass('hidden');

                    // Remplir automatiquement la date et l'heure actuelles
                    var now = new Date();
                    var date = now.toISOString().split('T')[0]; // Format YYYY-MM-DD
                    var time = now.toTimeString().split(' ')[0]; // Format HH:MM:SS
                    $('#date_paiement').val(date);
                    $('#heure_paiement').val(time);
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

    // Bouton Annuler
    $('#annuler').on('click', function() {
        $('#form-container').addClass('hidden');
        $('#search').val('');
    });
});

    </script>
<script>
    // Empêche la saisie d'espaces dans le champ montant
    document.getElementById('montant').addEventListener('keydown', function(e) {
        if (e.key === ' ') {
            e.preventDefault();  // Empêche l'utilisateur de saisir un espace
        }
    });

    // Calcul du montant total en fonction du montant saisi
    document.getElementById('montant').addEventListener('input', function() {
        const montant = parseFloat(this.value) || 0; // Si vide ou invalide, montant = 0
        let montantTotal = montant;

        if (montant <= 50000) {
            montantTotal += 500;  // Ajoute 500 si montant < 50 000
        } else {
            montantTotal += 1000; // Ajoute 1 000 si montant >= 50 000
        }

        document.getElementById('montant_total').value = montantTotal;
    });
</script>
<script>
    // Fonction pour définir la date et l'heure actuelles
    document.addEventListener('DOMContentLoaded', function() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');

        const currentDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
        document.getElementById('date_paiement').value = currentDateTime;
    });
</script>

 <script src="/jscript/style.js">
  </script>
 

</body>
</html>
