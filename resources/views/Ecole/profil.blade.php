
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Gérer Votre Profil</title>
</head>
<body class="bg-gray-100 h-screen">
  <div class="flex h-full">
    <!-- Sidebar -->
    <div class="w-1/4 bg-gray-800 text-white flex flex-col p-4 space-y-4">
      <h1 class="text-2xl font-bold mb-6">Tableau de bord</h1>
      <button id="btn-school-info" class="w-full bg-gray-700 hover:bg-gray-600 py-2 px-4 rounded">Informations de l'école</button>
      <button id="btn-bank-management" class="w-full bg-gray-700 hover:bg-gray-600 py-2 px-4 rounded">Gestion des banques</button>
      <button id="btn-class-management" class="w-full bg-gray-700 hover:bg-gray-600 py-2 px-4 rounded">Gestion des classes</button>
      <button id="btn-security" class="w-full bg-gray-700 hover:bg-gray-600 py-2 px-4 rounded">Sécurité</button>
    </div>

    <!-- Main content -->
    <div id="content" class="flex-1 bg-white p-6 overflow-y-auto">
      <!-- Content dynamically injected here -->
    </div>
  </div>

  <!-- Modal for adding a bank -->
  <div id="bank-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded shadow-lg w-1/3">
      <h3 class="text-lg font-semibold mb-4">Ajouter une banque</h3>
      <form>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Nom de la banque</label>
          <input type="text" class="w-full border border-gray-300 p-2 rounded">
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Numéro de compte</label>
          <input type="text" class="w-full border border-gray-300 p-2 rounded">
        </div>
        <div class="flex justify-end">
          <button type="button" class="bg-red-500 text-white px-4 py-2 rounded mr-2" onclick="toggleModal('bank-modal')">Annuler</button>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Confirmer</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal for class management -->
  <div id="class-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded shadow-lg w-1/3">
      <h3 class="text-lg font-semibold mb-4">Modifier une classe</h3>
      <form>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Nom de la classe</label>
          <input type="text" class="w-full border border-gray-300 p-2 rounded">
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Première tranche</label>
          <input type="text" class="w-full border border-gray-300 p-2 rounded">
        </div>
        <!-- Ajoutez des champs pour les autres tranches -->
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
      <form>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Numéro de téléphone</label>
          <input type="tel" class="w-full border border-gray-300 p-2 rounded">
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" class="w-full border border-gray-300 p-2 rounded">
        </div>
        <div class="flex justify-end">
          <button type="button" class="bg-red-500 text-white px-4 py-2 rounded mr-2" onclick="toggleModal('security-modal')">Annuler</button>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Confirmer</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const content = document.getElementById('content');

    const toggleModal = (id) => {
      const modal = document.getElementById(id);
      modal.classList.toggle('hidden');
    };

    const sections = {
      schoolInfo: `
        <section class="p-6">
          <h2 class="text-xl font-semibold text-gray-700 mb-4">Informations de l'école</h2>
          <form class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Nom de l'établissement</label>
              <input type="text" class="w-full border border-gray-300 p-2 rounded mt-1">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Ville</label>
              <input type="text" class="w-full border border-gray-300 p-2 rounded mt-1">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Téléphone</label>
              <input type="tel" class="w-full border border-gray-300 p-2 rounded mt-1">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Email</label>
              <input type="email" class="w-full border border-gray-300 p-2 rounded mt-1">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Niveau</label>
              <input type="text" class="w-full border border-gray-300 p-2 rounded mt-1">
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
              <tr>
                <td class="border border-gray-300 px-4 py-2">Banque 1</td>
                <td class="border border-gray-300 px-4 py-2">123456789</td>
                <td class="border border-gray-300 px-4 py-2">
                  <button class="text-blue-500 hover:underline">Modifier</button> |
                  <button class="text-red-500 hover:underline">Supprimer</button>
                </td>
              </tr>
              <!-- Ajoutez d'autres lignes ici -->
              <tr>
                <td class="border border-gray-300 px-4 py-2">Banque 2</td>
                <td class="border border-gray-300 px-4 py-2">987654321</td>
                <td class="border border-gray-300 px-4 py-2">
                  <button class="text-blue-500 hover:underline">Modifier</button> |
                  <button class="text-red-500 hover:underline">Supprimer</button>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="flex justify-end mt-4">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" onclick="toggleModal('bank-modal')">Ajouter une banque</button>
          </div>
        </section>
      `,
      classManagement: `
        <section class="p-6">
          <h2 class="text-xl font-semibold text-gray-700 mb-4">Gestion des classes</h2>
          <table class="w-full border-collapse border border-gray-300">
            <thead>
              <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2">Nom de la classe</th>
                <th class="border border-gray-300 px-4 py-2">Première tranche</th>
                <th class="border border-gray-300 px-4 py-2">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="border border-gray-300 px-4 py-2">Classe 1</td>
                <td class="border border-gray-300 px-4 py-2">50000 FCFA</td>
                <td class="border border-gray-300 px-4 py-2">
                  <button class="text-blue-500 hover:underline">Modifier</button> |
                  <button class="text-red-500 hover:underline">Supprimer</button> |
                  <button class="text-red-500 hover:underline">Supprimer une tranche</button>
                </td>
              </tr>
              <!-- Ajoutez d'autres lignes ici -->
            </tbody>
          </table>
          <div class="flex justify-end mt-4">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" onclick="toggleModal('class-modal')">Ajouter une classe</button>
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

    document.getElementById('btn-bank-management').addEventListener('click', () => {
      content.innerHTML = sections.bankManagement;
    });

    document.getElementById('btn-class-management').addEventListener('click', () => {
      content.innerHTML = sections.classManagement;
    });

    document.getElementById('btn-security').addEventListener('click', () => {
      content.innerHTML = sections.security;
    });
  </script>
</body>
</html>
