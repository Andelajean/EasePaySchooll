<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Children Names -->
        <div class="mt-4">
            <x-input-label for="children_names" :value="__('Noms des Enfants')" />
            <div id="children-names-container">
                <div class="child-name-entry mb-2">
                    <x-text-input class="child-name block mt-1 w-full" type="text" name="children_names[]" placeholder="Nom de l'enfant" autocomplete="off" />
                    <ul class="child-name-list mt-2 border border-gray-300 rounded-md"></ul>
                </div>
            </div>
            <button type="button" id="add-child-name" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Ajouter un enfant</button>
            <button type="button" id="remove-child-name" class="mt-2 px-4 py-2 bg-red-500 text-white rounded">Retirer un enfant</button>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addChildButton = document.getElementById('add-child-name');
            const removeChildButton = document.getElementById('remove-child-name');
            const childrenNamesContainer = document.getElementById('children-names-container');

            addChildButton.addEventListener('click', function () {
                const newChildNameEntry = document.createElement('div');
                newChildNameEntry.classList.add('child-name-entry', 'mb-2');

                newChildNameEntry.innerHTML = `
                    <x-text-input class="child-name block mt-1 w-full" type="text" name="children_names[]" placeholder="Nom de l'enfant" autocomplete="off" />
                    <ul class="child-name-list mt-2 border border-gray-300 rounded-md"></ul>
                `;

                childrenNamesContainer.appendChild(newChildNameEntry);

                const childNameInputs = document.querySelectorAll('.child-name');
                childNameInputs[childNameInputs.length - 1].addEventListener('input', handleChildNameInput);
            });

            removeChildButton.addEventListener('click', function () {
                const childNameEntries = document.querySelectorAll('.child-name-entry');
                if (childNameEntries.length > 1) {
                    childNameEntries[childNameEntries.length - 1].remove();
                }
            });

            function handleChildNameInput(event) {
                const input = event.target;
                const list = input.nextElementSibling;

                if (input.value.length > 0) {
                    fetch(`/search-children?q=${input.value}`)
                        .then(response => response.json())
                        .then(data => {
                            list.innerHTML = '';
                            data.forEach(child => {
                                const li = document.createElement('li');
                                li.textContent = child.nom_complet;
                                li.classList.add('cursor-pointer', 'p-2', 'hover:bg-gray-200');
                                li.addEventListener('click', function () {
                                    input.value = child.nom_complet;
                                    list.innerHTML = '';
                                });
                                list.appendChild(li);
                            });
                        });
                } else {
                    list.innerHTML = '';
                }
            }

            const childNameInputs = document.querySelectorAll('.child-name');
            childNameInputs.forEach(input => {
                input.addEventListener('input', handleChildNameInput);
            });
        });
    </script>
</x-guest-layout>
