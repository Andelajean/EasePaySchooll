<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <title>Gérer Votre Profil</title>
</head>
<body class="bg-gray-100 h-screen">
  <div class="flex h-full">
    <!-- Sidebar -->
    <div class="w-1/4 bg-gray-800 text-white flex flex-col p-4 space-y-4">
      <h1 class="text-2xl font-bold mb-6">Gestion Du Profil</h1>
      <button id="btn-school-info" class="w-full bg-gray-700 hover:bg-blue-600 py-2 px-4 rounded">Informations de l'école</button>
      <button id="btn-bank-management" class="w-full bg-gray-700 hover:bg-blue-600 py-2 px-4 rounded">Gestion des banques</button>
      <button id="btn-class-management" class="w-full bg-gray-700 hover:bg-blue-600 py-2 px-4 rounded">Gestion des classes</button>
      <button id="btn-filiere-management" class="w-full bg-gray-700 hover:bg-blue-600 py-2 px-4 rounded">Gestion des Filières</button>
      <button id="btn-security" class="w-full bg-gray-700 hover:bg-blue-600 py-2 px-4 rounded">Sécurité</button>
        <a href="{{route('dashboard_ecole')}}"class="w-full bg-gray-700 hover:bg-blue-600 text-center py-2 px-4 rounded">Retour</a>
    </div>

    <!-- Main content -->
    <div id="content" class="flex-1 bg-white p-6 overflow-y-auto">
      <!-- Content dynamically injected here -->
       
<div class="messages-container">
  @if(session('success'))
  <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {!! session('success') !!}
    </div>
  @endif
  @if(session('error'))
    <div class="text-red-500 font-bold mb-4 p-3 bg-red-100 border border-red-300 rounded">
      {{ session('error') }}
    </div>
  @endif
  @if ($errors->any())
    <div class="text-red-500 font-bold mb-4 p-3 bg-red-100 border border-red-300 rounded">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
</div>
    </div>
  </div>

 <!-- Modal for adding a bank -->
<!-- Modal for adding a bank -->
<div id="bank-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
  <div class="bg-white p-6 rounded shadow-lg w-1/3">
    <h3 class="text-lg font-semibold mb-4">Ajouter une banque</h3>
    <form method="POST" action="{{ route('ecoles.add-bank', $ecole->id) }}">
      @csrf
      <input type="hidden" name="ecole_id" value="{{ $ecole->id }}"> <!-- ID de l'école -->
      <div class="mb-4">
        <label for="nom_banque" class="block text-sm font-medium text-gray-700">Nom de la banque</label>
        <input type="text" id="nom_banque" name="nom_banque" class="w-full border border-gray-300 p-2 rounded" required>
      </div>
      <div class="mb-4">
        <label for="numero_banque" class="block text-sm font-medium text-gray-700">Numéro de compte</label>
        <input type="text" id="numero_banque" name="numero_banque" class="w-full border border-gray-300 p-2 rounded" required>
      </div>
      <div class="mb-4">
        <label for="banque_index" class="block text-sm font-medium text-gray-700">Index de la banque</label>
        <select id="banque_index" name="banque_index" class="w-full border border-gray-300 p-2 rounded" required>
          @for ($i = 1; $i <= 8; $i++)
            <option value="{{ $i }}">Banque {{ $i }}</option>
          @endfor
        </select>
      </div>
      <div class="flex justify-end">
        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded mr-2" onclick="toggleModal('bank-modal')">Annuler</button>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Confirmer</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal for adding a filiere -->
<div id="filiere-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
  <div class="bg-white p-6 rounded shadow-lg w-1/3">
    <h3 class="text-lg font-semibold mb-4">Ajouter une Filière</h3>
    <form method="POST" action="{{ route('ecoles.add-bank', $ecole->id) }}">
      @csrf
      <input type="hidden" name="ecole_id" value="{{ $ecole->id }}"> <!-- ID de l'école -->
      <div class="mb-4">
        <label for="nom_banque" class="block text-sm font-medium text-gray-700">Nom de la Filière</label>
        <input type="text" id="nom_banque" name="nom_filiere" class="w-full border border-gray-300 p-2 rounded" required>
      </div>
      <div class="flex justify-end">
        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded mr-2" onclick="toggleModal('filiere-modal')">Annuler</button>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Confirmer</button>
      </div>
    </form>
  </div>
</div>


  <!-- Modal for class management -->
  <div id="class-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
  <div class="bg-white p-6 rounded shadow-lg w-2/3">
    <h3 class="text-lg font-semibold mb-4">Ajouter une classe</h3>
    <form action="{{ route('classes.store') }}" method="POST">
  @csrf
  <input type="hidden" name="id_ecole" value="{{ $ecole->id}}">
      <div class="mb-4">
        <label for="nom_classe" class="block text-sm font-medium text-gray-700">Nom de la classe</label>
        <input type="text" id="nom_classe" name="nom_classe" class="w-full border border-gray-300 p-2 rounded" required>
      </div>
      <div class="grid grid-cols-3 gap-4 mb-4">
        <div>
          <label for="premiere_tranche" class="block text-sm font-medium text-gray-700">Première tranche</label>
          <input type="number" id="premiere_tranche" name="premiere_tranche" class="w-full border border-gray-300 p-2 rounded tranche" min="0">
        </div>
        <div>
          <label for="deuxieme_tranche" class="block text-sm font-medium text-gray-700">Deuxième tranche</label>
          <input type="number" id="deuxieme_tranche" name="deuxieme_tranche" class="w-full border border-gray-300 p-2 rounded tranche" min="0">
        </div>
        <div>
          <label for="troisieme_tranche" class="block text-sm font-medium text-gray-700">Troisième tranche</label>
          <input type="number" id="troisieme_tranche" name="troisieme_tranche" class="w-full border border-gray-300 p-2 rounded tranche" min="0">
        </div>
        <div>
          <label for="quatrieme_tranche" class="block text-sm font-medium text-gray-700">Quatrième tranche</label>
          <input type="number" id="quatrieme_tranche" name="quatrieme_tranche" class="w-full border border-gray-300 p-2 rounded tranche" min="0">
        </div>
        <div>
          <label for="cinquieme_tranche" class="block text-sm font-medium text-gray-700">Cinquième tranche</label>
          <input type="number" id="cinquieme_tranche" name="cinquieme_tranche" class="w-full border border-gray-300 p-2 rounded tranche" min="0">
        </div>
        <div>
          <label for="sixieme_tranche" class="block text-sm font-medium text-gray-700">Sixième tranche</label>
          <input type="number" id="sixieme_tranche" name="sixieme_tranche" class="w-full border border-gray-300 p-2 rounded tranche" min="0">
        </div>
        <div>
          <label for="septieme_tranche" class="block text-sm font-medium text-gray-700">Septième tranche</label>
          <input type="number" id="septieme_tranche" name="septieme_tranche" class="w-full border border-gray-300 p-2 rounded tranche" min="0">
        </div>
        <div>
          <label for="huitieme_tranche" class="block text-sm font-medium text-gray-700">Huitième tranche</label>
          <input type="number" id="huitieme_tranche" name="huitieme_tranche" class="w-full border border-gray-300 p-2 rounded tranche" min="0">
        </div>
      </div>
      <div class="mb-4">
        <label for="totalite" class="block text-sm font-medium text-gray-700">Totalité</label>
        <input type="text" id="totalite" name="totalite" class="w-full border border-gray-300 p-2 rounded" readonly>
      </div>
      <div class="flex justify-end">
        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded mr-2" onclick="toggleModal('class-modal')">Annuler</button>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Enregistrer</button>
      </div>
    </form>
  </div>
</div>


  <!-- Modal for security -->
  <div id="security-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded shadow-lg w-1/3">
      <h3 class="text-lg font-semibold mb-4">Générer un nouvel identifiant</h3>
      <form action="{{ route('ecoles.generateIdentifiant') }}" method="POST">
    @csrf
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Numéro de téléphone</label>
        <input type="tel" name="telephone" class="w-full border border-gray-300 p-2 rounded" required>
    </div>
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" class="w-full border border-gray-300 p-2 rounded" required>
    </div>
    <div class="flex justify-end">
        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded mr-2" onclick="toggleModal('security-modal')">Annuler</button>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Confirmer</button>
    </div>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
  const trancheInputs = document.querySelectorAll('.tranche');
  const totalInput = document.getElementById('totalite');

  trancheInputs.forEach(input => {
    input.addEventListener('input', () => {
      let total = 0;
      trancheInputs.forEach(tranche => {
        total += parseFloat(tranche.value) || 0; // Si le champ est vide, considérer 0
      });
      totalInput.value = total.toFixed(2); // Mettre à jour le champ total
    });
  });
});

    const content = document.getElementById('content');

    const toggleModal = (id) => {
      const modal = document.getElementById(id);
      modal.classList.toggle('hidden');
    };

    const sections = {
      schoolInfo: `
        <section class="p-6">
          <h2 class="text-xl font-semibold text-gray-700 mb-4">Informations de l'école</h2>
          <form class="grid grid-cols-2 gap-4" method ="POST" action ="/ecole/{{$ecole->id}}">
           @csrf
            <div>
              <label class="block text-sm font-medium text-gray-700">Nom de l'établissement</label>
              <input type="text" name="nom_ecole" value="{{ $ecole->nom_ecole }}" class="w-full border border-gray-300 p-2 rounded mt-1">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Ville</label>
              <input type="text" name="ville" value="{{ $ecole->ville }}" class="w-full border border-gray-300 p-2 rounded mt-1">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Téléphone</label>
              <input type="text" name="telephone" value="{{ $ecole->telephone }}" class="w-full border border-gray-300 p-2 rounded mt-1">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Email</label>
              <input type="email" name="email" value="{{ $ecole->email }}" class="w-full border border-gray-300 p-2 rounded mt-1">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Niveau</label>
              <input type="text" name="niveau" value="{{ $ecole->niveau }}" class="w-full border border-gray-300 p-2 rounded mt-1">
            </div>
            <div class="col-span-2 flex justify-end">
              <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Mettre à jour</button>
            </div>
          </form>
        </section>
      `,
      bankManagement: `
        <section class="p-6">
          <h2 class="text-xl font-semibold text-gray-700 mb-4">Gestion des banques</h2>
          <table class="w-full border-collapse border border-gray-300">
            <thead>
              <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2">Nom de la banque</th>
                <th class="border border-gray-300 px-4 py-2">Numéro de compte</th>
                <th class="border border-gray-300 px-4 py-2">Action</th>
              </tr>
            </thead>
           <tbody>
  @for ($i = 1; $i <= 8; $i++)
        @php
          $nomBanque = "nom_banque$i";
          $numeroBanque = "numero_banque$i";
        @endphp
        @if ($ecole->$nomBanque && $ecole->$numeroBanque)
          <tr>
            <td class="px-4 py-2 border" data-nom="{{ $ecole->$nomBanque }}">{{ $ecole->$nomBanque }}</td>
            <td class="px-4 py-2 border" data-numero="{{ $ecole->$numeroBanque }}">{{ $ecole->$numeroBanque }}</td>
            <td class="px-4 py-2 border text-center">
              <a href="#" class="text-blue-600" onclick="openEditModal(this)"data-index="{{ $i }}">
                <i class="fas fa-edit"></i>
              </a>
          |
          <!-- Icône Supprimer -->
          <form action="{{ route('ecoles.deleteBank', ['ecole' => $ecole->id, 'index' => $i]) }}" method="POST" class="inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette banque ?')">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>

        </td>
      </tr>
    @endif
  @endfor
</tbody>

          </table>
          <!-- Modal -->
  <div id="edit-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded shadow-md w-96">
      <h3 class="text-lg font-semibold mb-4">Modifier les informations de la banque</h3>
      <form  method ="POST" action ="/ecoles/{{$ecole->id}}/banques">
       @csrf
        <div class="mb-4">
         <input type="hidden" id="edit-index" name="banque_index">
          <label for="edit-nom" class="block text-gray-700">Nom de la banque</label>
          <input type="text" id="edit-nom" name="nom_banque" class="w-full border px-3 py-2 rounded">
        </div>
        <div class="mb-4">
          <label for="edit-numero" class="block text-gray-700">Numéro de compte</label>
          <input type="text" id="edit-numero" name="numero_banque" class="w-full border px-3 py-2 rounded">
        </div>
        <div class="flex justify-end">
          <button type="button" class="bg-red-600 text-white px-4 py-2 rounded mr-2" onclick="closeEditModal()">Annuler</button>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Mettre à jour</button>
        </div>
      </form>
    </div>
  </div>
          <div class="flex justify-end mt-4">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" onclick="toggleModal('bank-modal')">Ajouter une banque</button>
          </div>
        </section>
      `,
      filiereManagement: `
        <section class="p-6">
          <h2 class="text-xl font-semibold text-gray-700 mb-4">Gestion des Filières</h2>
          <div class="flex justify-end mt-4">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" onclick="toggleModal('filiere-modal')">Ajouter une Filière</button>
          </div>
          <table class="w-full border-collapse border border-gray-300">
            <thead>
              <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2">Nom de la Filière</th>
                
                <th class="border border-gray-300 px-4 py-2">Action</th>
              </tr>
            </thead>
           <tbody>
          <tr>
            <td class="px-4 py-2 border" data-nom=""></td>
            
            <td class="px-4 py-2 border text-center">
              <a href="#" class="text-blue-600" onclick="openEditModal(this)"data-index="{{ $i }}">
                <i class="fas fa-edit"></i>
              </a>
          |
          <!-- Icône Supprimer -->
          <form action="{{ route('ecoles.deleteBank', ['ecole' => $ecole->id, 'index' => $i]) }}" method="POST" class="inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette banque ?')">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>

        </td>
      </tr>
  
</tbody>

          </table>
          <!-- Modal -->
  <div id="edit-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded shadow-md w-96">
      <h3 class="text-lg font-semibold mb-4">Modifier les informations de la banque</h3>
      <form  method ="POST" action ="/ecoles/{{$ecole->id}}/banques">
       @csrf
        <div class="mb-4">
         <input type="hidden" id="edit-index" name="banque_index">
          <label for="edit-nom" class="block text-gray-700">Nom de la banque</label>
          <input type="text" id="edit-nom" name="nom_banque" class="w-full border px-3 py-2 rounded">
        </div>
        <div class="mb-4">
          <label for="edit-numero" class="block text-gray-700">Numéro de compte</label>
          <input type="text" id="edit-numero" name="numero_banque" class="w-full border px-3 py-2 rounded">
        </div>
        <div class="flex justify-end">
          <button type="button" class="bg-red-600 text-white px-4 py-2 rounded mr-2" onclick="closeEditModal()">Annuler</button>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Mettre à jour</button>
        </div>
      </form>
    </div>
  </div>
          
        </section>
      `,
      classManagement: `
        <section class="p-6">
          <h2 class="text-xl font-semibold text-gray-700 mb-4">Gestion des classes</h2>
          <table class="w-full border-collapse border border-gray-300">
          <thead class="bg-gray-200">
        <tr>
          <th class="px-4 py-2 border">Nom de la Classe</th>
          <th class="px-4 py-2 border">Première Tranche</th>
          <th class="px-4 py-2 border">Deuxième Tranche</th>
          <th class="px-4 py-2 border">Troisième Tranche</th>
          <th class="px-4 py-2 border">Quatrième Tranche</th>
          <th class="px-4 py-2 border">Cinquième Tranche</th>
          <th class="px-4 py-2 border">Sixième Tranche</th>
          <th class="px-4 py-2 border">Septième Tranche</th>
          <th class="px-4 py-2 border">Huitième Tranche</th>
          <th class="px-4 py-2 border">Totalité</th>
          <th class="px-4 py-2 border">Actions</th>
        </tr>
      </thead>
      <tbody>
     @foreach ($classes as $classe)
  <tr>
    <td class="px-4 py-2 border">{{ $classe->nom_classe }}</td>
    <td class="px-4 py-2 border">{{ $classe->premiere_tranche ?? '-' }}</td>
    <td class="px-4 py-2 border">{{ $classe->deuxieme_tranche ?? '-' }}</td>
    <td class="px-4 py-2 border">{{ $classe->troisieme_tranche ?? '-' }}</td>
    <td class="px-4 py-2 border">{{ $classe->quatrieme_tranche ?? '-' }}</td>
    <td class="px-4 py-2 border">{{ $classe->cinquieme_tranche ?? '-' }}</td>
    <td class="px-4 py-2 border">{{ $classe->sixieme_tranche ?? '-' }}</td>
    <td class="px-4 py-2 border">{{ $classe->septieme_tranche ?? '-' }}</td>
    <td class="px-4 py-2 border">{{ $classe->huitieme_tranche ?? '-' }}</td>
    <td class="px-4 py-2 border">{{ $classe->totalite ?? '-' }}</td>
    <td class="px-4 py-2 border text-center">
     <a href="{{ route('classes.edit', ['id' => $classe->id]) }}" class="text-blue-600 hover:text-blue-800 ">
    <i class="fas fa-edit"></i>
  </a>
  
  |
  <form action="{{ route('classes.destroy', $classe->id) }}" method="POST" class="inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?')">
      <i class="fas fa-trash-alt"></i>
    </button>
  </form>
</td>
          </tr>
        @endforeach
      </tbody>
          </table>
          <div class="flex justify-end mt-4">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" onclick="toggleModal('class-modal')">Ajouter une classe</button>
             
          </div>
          <div class="flex justify-end mt-4">
           
             <a href="/ecole/compte/classe/universite/{{$ecole->id}}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ajouter Plusieurs Classes</a>
          </div>
        </section>
      `,
      security: `
        <section class="p-6">
          <h2 class="text-xl font-semibold text-gray-700 mb-4">Sécurité</h2>
          <div class="flex justify-end">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" onclick="toggleModal('security-modal')">Générer un nouvel identifiant</button>
          </div>
        </section>
      `,
    };

    document.getElementById('btn-school-info').addEventListener('click', () => {
      content.innerHTML = sections.schoolInfo;
    });
    document.getElementById('btn-filiere-management').addEventListener('click', () => {
      content.innerHTML = sections.filiereManagement;
    });

    document.getElementById('btn-bank-management').addEventListener('click', () => {
      content.innerHTML = sections.bankManagement;
    });

    document.getElementById('btn-class-management').addEventListener('click', () => {
      content.innerHTML = sections.classManagement;
    });

    document.getElementById('btn-security').addEventListener('click', () => {
      content.innerHTML = sections.security;
    });
//infos ecole
    function openEditModal(element) {
    const row = element.closest('tr');
    const nom = row.querySelector('td[data-nom]').dataset.nom;
    const numero = row.querySelector('td[data-numero]').dataset.numero;
    const index = element.getAttribute('data-index'); // Récupérer l'index de la banque

    document.getElementById('edit-nom').value = nom;
    document.getElementById('edit-numero').value = numero;
    document.getElementById('edit-index').value = index; // Assurez-vous que le champ caché pour l'index existe

    document.getElementById('edit-modal').classList.remove('hidden');
}
function closeEditModal() {
    document.getElementById('edit-modal').classList.add('hidden');
  }
//infos classe


  </script>

</body>
</html>
