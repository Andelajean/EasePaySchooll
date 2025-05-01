<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription au concours - InGé</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-section {
            display: none;
        }
        .form-section.active {
            display: block;
        }
        .required-field::after {
            content: " *";
            color: red;
        }
    </style>
      <style>
    .animate-fade-in-out {
        animation: fadeInOut 3s ease-in-out forwards;
    }

    @keyframes fadeInOut {
        0% { opacity: 0; transform: translateY(-20px); }
        10% { opacity: 1; transform: translateY(0); }
        90% { opacity: 1; transform: translateY(0); }
        100% { opacity: 0; transform: translateY(-20px); }
    }
</style>
</head>
<body>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h2 class="text-center">Inscription au concours dans la filière Ingenieur Generaliste</h2>
                    </div>
                    <div x-data="{ showAlert: true }" x-show="showAlert" x-transition class="space-y-4">

                    @if(session('success'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in-out transition-all duration-300">
        <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in-out transition-all duration-300">
        <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif

</div>


                    <form id="inscriptionForm" method="POST" action="{{route('inge.store')}}" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Première partie : Coordonnées du candidat -->
                        <div id="part1" class="form-section active">
                            <div class="card-body">
                                <h4 class="mb-4 text-primary">1. Coordonnées du candidat</h4>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="nom" class="form-label required-field">Nom</label>
                                        <input type="text" class="form-control" id="nom" name="nom" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="prenom" class="form-label required-field">Prénom</label>
                                        <input type="text" class="form-control" id="prenom" name="prenom" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="sexe" class="form-label required-field">Sexe</label>
                                        <select class="form-select" id="sexe" name="sexe" required>
                                            <option value="">Sélectionner...</option>
                                            <option value="M">Masculin</option>
                                            <option value="F">Féminin</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="date_naissance" class="form-label required-field">Date de naissance</label>
                                        <input type="date" class="form-control" id="date_naissance" name="date_naissance" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="lieu_naissance" class="form-label required-field">Lieu de naissance</label>
                                        <input type="text" class="form-control" id="lieu_naissance" name="lieu_naissance" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="nationalite" class="form-label required-field">Nationalité</label>
                                        <input type="text" class="form-control" id="nationalite" name="nationalite" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="region_origine" class="form-label required-field">Région d'origine</label>
                                        <input type="text" class="form-control" id="region_origine" name="region_origine" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="adresse" class="form-label required-field">Adresse</label>
                                        <input type="text" class="form-control" id="adresse" name="adresse" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="telephone" class="form-label required-field">Téléphone</label>
                                        <input type="tel" class="form-control" id="telephone" name="telephone" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="email" class="form-label required-field">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-footer bg-light">
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" disabled>Précédent</button>
                                    <button type="button" class="btn btn-primary" onclick="nextSection('part1', 'part2')">Suivant</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Suite du formulaire après la première partie -->

<!-- Deuxième partie : Diplôme et Pièces du candidat -->
<div id="part2" class="form-section">
    <div class="card-body">
        <h4 class="mb-4 text-primary">2. Diplôme et Pièces du candidat</h4>
        
        <!-- Question sur le titulaire du bac -->
        <div class="row mb-4">
            <div class="col-md-12">
                <label class="form-label required-field">Êtes-vous titulaire du baccalauréat ?</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="titulaire_bac" id="titulaire_bac_oui" value="1" onchange="toggleBacField()">
                    <label class="form-check-label" for="titulaire_bac_oui">Oui</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="titulaire_bac" id="titulaire_bac_non" value="0" checked onchange="toggleBacField()">
                    <label class="form-check-label" for="titulaire_bac_non">Non</label>
                </div>
            </div>
        </div>

        <!-- Diplôme du baccalauréat (conditionnel) -->
        <div class="row mb-3" id="bacDiplomeField" style="display:none;">
            <div class="col-md-12">
                <label for="diplome_bac" class="form-label">Diplôme du baccalauréat (PDF)</label>
                <input type="file" class="form-control" id="diplome_bac" name="diplome_bac" accept=".pdf">
                <small class="text-muted">Format PDF uniquement (max 2MB)</small>
            </div>
        </div>

        <!-- Bulletins scolaires -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="bulletin_seconde" class="form-label required-field">Bulletin annuel de la Seconde (PDF)</label>
                <input type="file" class="form-control" id="bulletin_seconde" name="bulletin_seconde" accept=".pdf" required>
            </div>
            
            <div class="col-md-6">
                <label for="bulletin_premiere" class="form-label required-field">Bulletin annuel de la Première (PDF)</label>
                <input type="file" class="form-control" id="bulletin_premiere" name="bulletin_premiere" accept=".pdf" required>
            </div>
            
            <div class="col-md-6">
                <label for="bulletin_terminale" class="form-label required-field">Bulletin annuel de la Terminale (PDF)</label>
                <input type="file" class="form-control" id="bulletin_terminale" name="bulletin_terminale" accept=".pdf" required>
            </div>
            
            <div class="col-md-6">
                <label for="diplome_probatoire" class="form-label required-field">Diplôme du probatoire (PDF)</label>
                <input type="file" class="form-control" id="diplome_probatoire" name="diplome_probatoire" accept=".pdf" required>
            </div>
        </div>

        <!-- Pièce d'identité -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="piece_identite_recto" class="form-label required-field">Recto de la pièce d'identité (PDF ou image)</label>
                <input type="file" class="form-control" id="piece_identite_recto" name="piece_identite_recto" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>
            
            <div class="col-md-6">
                <label for="piece_identite_verso" class="form-label required-field">Verso de la pièce d'identité (PDF ou image)</label>
                <input type="file" class="form-control" id="piece_identite_verso" name="piece_identite_verso" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>
        </div>

        <!-- Autres documents -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="certificat_scolarite" class="form-label required-field">Certificat de scolarité (PDF)</label>
                <input type="file" class="form-control" id="certificat_scolarite" name="certificat_scolarite" accept=".pdf" required>
            </div>
            
            <div class="col-md-6">
                <label for="fiche_inscription" class="form-label required-field">Fiche d'inscription remplie (PDF)</label>
                <input type="file" class="form-control" id="fiche_inscription" name="fiche_inscription" accept=".pdf" required>
            </div>
        </div>

        <!-- Photo 4x4 -->
        <div class="row mb-4">
            <div class="col-md-12">
                <label class="form-label required-field">Photo 4x4 du candidat</label>
                
                <div class="d-flex flex-column flex-md-row gap-4">
                    <!-- Option 1 : Télécharger une photo -->
                    <div class="flex-grow-1">
                        <label for="photo_file" class="form-label">Téléverser une photo</label>
                        <input type="file" class="form-control" id="photo_file" name="photo_file" accept=".jpg,.jpeg,.png" capture="user">
                        <small class="text-muted">Format JPG/PNG (max 2MB)</small>
                    </div>
                    
                    <!-- Option 2 : Prendre une photo -->
                    <div class="flex-grow-1">
                        <label class="form-label">Prendre une photo maintenant</label>
                        <div>
                            <button type="button" class="btn btn-outline-primary" onclick="openCamera()">
                                <i class="bi bi-camera"></i> Prendre une photo
                            </button>
                        </div>
                        <div id="cameraContainer" class="mt-2" style="display:none;">
                            <video id="cameraPreview" width="200" height="200" autoplay></video>
                            <canvas id="photoCanvas" width="200" height="200" style="display:none;"></canvas>
                            <div class="mt-2">
                                <button type="button" class="btn btn-success btn-sm" onclick="capturePhoto()">Capturer</button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="closeCamera()">Annuler</button>
                            </div>
                        </div>
                        <input type="hidden" id="photo_data" name="photo_data">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-footer bg-light">
        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" onclick="prevSection('part2', 'part1')">Précédent</button>
            <button type="submit" class="btn btn-success">Valider l'inscription</button>
        </div>
    </div>
</div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function nextSection(current, next) {
            // Validation des champs obligatoires
            const currentSection = document.getElementById(current);
            const requiredInputs = currentSection.querySelectorAll('[required]');
            let isValid = true;
            
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                alert('Veuillez remplir tous les champs obligatoires.');
                return;
            }
            
            // Passer à la section suivante
            document.getElementById(current).classList.remove('active');
            document.getElementById(next).classList.add('active');
        }
        
        function prevSection(current, prev) {
            document.getElementById(current).classList.remove('active');
            document.getElementById(prev).classList.add('active');
        }
    </script>
    <!-- Scripts supplémentaires -->
<script>
    // Afficher/masquer le champ diplôme du bac selon le choix
    function toggleBacField() {
        const isTitulaire = document.querySelector('input[name="titulaire_bac"]:checked').value === '1';
        document.getElementById('bacDiplomeField').style.display = isTitulaire ? 'block' : 'none';
        
        if (isTitulaire) {
            document.getElementById('diplome_bac').setAttribute('required', '');
        } else {
            document.getElementById('diplome_bac').removeAttribute('required');
        }
    }

    // Gestion de la caméra
    let stream = null;

    function openCamera() {
        const cameraPreview = document.getElementById('cameraPreview');
        const cameraContainer = document.getElementById('cameraContainer');
        
        navigator.mediaDevices.getUserMedia({ video: { width: 200, height: 200 }, audio: false })
            .then(function(s) {
                stream = s;
                cameraPreview.srcObject = stream;
                cameraContainer.style.display = 'block';
            })
            .catch(function(err) {
                console.error("Erreur d'accès à la caméra: ", err);
                alert("Impossible d'accéder à la caméra. Veuillez vérifier les permissions.");
            });
    }

    function capturePhoto() {
        const cameraPreview = document.getElementById('cameraPreview');
        const photoCanvas = document.getElementById('photoCanvas');
        const context = photoCanvas.getContext('2d');
        
        // Dessiner l'image sur le canvas
        context.drawImage(cameraPreview, 0, 0, 200, 200);
        
        // Convertir en base64
        const photoData = photoCanvas.toDataURL('image/png');
        document.getElementById('photo_data').value = photoData;
        
        // Afficher un aperçu
        alert('Photo capturée avec succès!');
        closeCamera();
    }

    function closeCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
        document.getElementById('cameraContainer').style.display = 'none';
    }

    // Validation avant soumission
    document.getElementById('inscriptionForm').addEventListener('submit', function(e) {
        // Vérifier si au moins une option photo est fournie
        const photoFile = document.getElementById('photo_file').value;
        const photoData = document.getElementById('photo_data').value;
        
        if (!photoFile && !photoData) {
            e.preventDefault();
            alert('Veuillez fournir une photo 4x4 (téléversement ou capture)');
            return false;
        }
    });
</script>
</body>
</html>