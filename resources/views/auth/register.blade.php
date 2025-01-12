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
<<<<<<< HEAD

=======
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
<<<<<<< HEAD

=======
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
<<<<<<< HEAD

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

=======
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Ecole -->
        <div class="mt-4">
            <x-input-label for="ecole" :value="__('Ecole')" />
            <x-text-input id="ecole-search" class="block mt-1 w-full" type="text" placeholder="Rechercher une école..." />
            <x-input-error :messages="$errors->get('ecole')" class="mt-2" />
            <ul id="ecole-list" class="mt-2 border border-gray-300 rounded-md"></ul>
        </div>

        <!-- Classe -->
        <div class="mt-4">
            <x-input-label for="classe" :value="__('Classe')" />
            <select id="classe" name="classe" class="block mt-1 w-full" required>
                <option value="">{{ __('Select Classe') }}</option>
            </select>
            <x-input-error :messages="$errors->get('classe')" class="mt-2" />
        </div>

>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
<<<<<<< HEAD
=======

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ecoleSearch = document.getElementById('ecole-search');
            const ecoleList = document.getElementById('ecole-list');
            const classeSelect = document.getElementById('classe');

            ecoleSearch.addEventListener('input', function () {
                const query = ecoleSearch.value;
                if (query.length > 0) {
                    fetch(`/search-ecoles?q=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            ecoleList.innerHTML = '';
                            data.forEach(ecole => {
                                const li = document.createElement('li');
                                li.textContent = ecole.nom_ecole;
                                li.classList.add('cursor-pointer', 'p-2', 'hover:bg-gray-200');
                                li.addEventListener('click', function () {
                                    ecoleSearch.value = ecole.nom_ecole;
                                    ecoleList.innerHTML = '';
                                    loadClasses(ecole.id);
                                });
                                ecoleList.appendChild(li);
                            });
                        });
                } else {
                    ecoleList.innerHTML = '';
                }
            });

            function loadClasses(ecoleId) {
                fetch(`/get-classes?ecole_id=${ecoleId}`)
                    .then(response => response.json())
                    .then(data => {
                        classeSelect.innerHTML = '<option value="">{{ __('Select Classe') }}</option>';
                        data.forEach(classe => {
                            const option = document.createElement('option');
                            option.value = classe.id;
                            option.textContent = classe.nom_classe;
                            classeSelect.appendChild(option);
                        });
                    });
            }
        });
    </script>
>>>>>>> b610dc2e03e1e8e3ac1f8dc2b2bd7a69a7e63053
</x-guest-layout>
