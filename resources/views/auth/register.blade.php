<x-guest-layout>
    <head>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                display: flex;
                justify-content: center;
                align-items: flex-start; /* Formulaire positionné en haut */
                min-height: 100vh; /* Prend 100% de la hauteur de l'écran */
                width: 100%; /* Prend 100% de la largeur de l'écran */
                background-color: #f3f3f3; /* Fond clair */
                padding: 10px; /* Ajoute des marges internes */
            }

            .form-container {
                width: 90vw; /* Largeur relative à l'écran */
                max-width: 350px; /* Limite maximale sur grands écrans */
                padding: 15px; /* Espacement interne */
                background: white;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .input-group {
                margin-bottom: 1.2rem; /* Espacement réduit pour une meilleure visibilité */
            }

            .material-icons {
                font-size: 20px; /* Réduction de la taille des icônes */
                color: #555;
                margin-right: 5px;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"] {
                width: 100%; /* Prend toute la largeur du conteneur */
                padding: 8px; /* Réduction de l'espacement */
                border: 1px solid #ccc;
                border-radius: 5px;
                margin-top: 5px;
                background-color: #f9f9f9;
                font-size: 14px; /* Réduction de la taille du texte */
            }

            label {
                display: flex;
                align-items: center;
                font-weight: bold;
                color: #000;
                font-size: 14px; /* Réduction de la taille du texte */
            }

            button {
                margin-top: 10px;
                padding: 8px 15px; /* Taille réduite pour les boutons */
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 13px; /* Réduction de la taille du texte */
                color: white;
            }

            .bg-blue-500 {
                background-color: #007bff;
            }

            .bg-red-500 {
                background-color: #dc3545;
            }
        </style>
    </head>

    <body>
        <div class="form-container">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="input-group">
                    <label for="name">
                        <span class="material-icons">person</span>
                        Name
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                </div>

                <!-- Email Address -->
                <div class="input-group">
                    <label for="email">
                        <span class="material-icons">email</span>
                        Email
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                </div>

                <!-- Password -->
                <div class="input-group">
                    <label for="password">
                        <span class="material-icons">lock</span>
                        Password
                    </label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" />
                </div>

                <!-- Confirm Password -->
                <div class="input-group">
                    <label for="password_confirmation">
                        <span class="material-icons">check_circle</span>
                        Confirm Password
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                <!-- Children Names -->
                <div class="input-group">
                    <label for="children_names">
                        <span class="material-icons">child_care</span>
                        Noms des Enfants
                    </label>
                    <div id="children-names-container">
                        <div class="input-group">
                            <input type="text" name="children_names[]" placeholder="Nom de l'enfant" autocomplete="off" />
                        </div>
                    </div>
                    <button type="button" id="add-child-name" class="bg-blue-500">Ajouter un enfant</button>
                    <button type="button" id="remove-child-name" class="bg-red-500">Retirer un enfant</button>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        Already registered?
                    </a>
                    <x-primary-button class="ms-4">
                        S'enregistrer
                    </x-primary-button>
                </div>
            </form>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const addChildButton = document.getElementById('add-child-name');
                const removeChildButton = document.getElementById('remove-child-name');
                const childrenNamesContainer = document.getElementById('children-names-container');

                addChildButton.addEventListener('click', function () {
                    const newChildNameEntry = document.createElement('div');
                    newChildNameEntry.classList.add('input-group');
                    newChildNameEntry.innerHTML = `
                        <input type="text" name="children_names[]" placeholder="Nom de l'enfant" autocomplete="off" />
                    `;
                    childrenNamesContainer.appendChild(newChildNameEntry);
                });

                removeChildButton.addEventListener('click', function () {
                    const childNameEntries = childrenNamesContainer.querySelectorAll('.input-group');
                    if (childNameEntries.length > 1) {
                        childNameEntries[childNameEntries.length - 1].remove();
                    }
                });
            });
        </script>
    </body>
</x-guest-layout>
