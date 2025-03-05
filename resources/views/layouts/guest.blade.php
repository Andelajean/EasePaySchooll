<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Styles -->
        <style>
            /* Ajout d'une gestion responsive et overflow */
            * {
                box-sizing: border-box;
            }

            body {
                font-family: 'Figtree', sans-serif;
                background: #ffffff; /* Fond blanc */
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0;
                overflow-x: hidden; /* Empêche le défilement horizontal */
            }

            /* Style pour l'animation SVG */
            .background-svg {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
            }

            .content-container {
                background-color: rgba(255, 255, 255, 0.95); /* Fond blanc semi-transparent */
                padding: 20px;
                border-radius: 15px;
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                text-align: center;
                animation: fadeIn 2s ease-in-out;
                width: 100%; /* Adaptabilité à l'écran */
                max-width: 600px; /* Largeur maximale du conteneur */
            }

            @keyframes fadeIn {
                0% { opacity: 0; transform: scale(0.95); }
                100% { opacity: 1; transform: scale(1); }
            }

            /* Ajout de styles pour les petits écrans */
            @media (max-width: 768px) {
                .content-container {
                    padding: 10px; /* Réduction du padding sur les petits écrans */
                    border-radius: 10px; /* Ajustement du coin arrondi */
                }
            }
        </style>
    </head>
    <body>
        <!-- SVG animée en arrière-plan -->
        <svg class="background-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 600" preserveAspectRatio="xMidYMid slice">
            <rect fill="#ffffff" width="800" height="600" />
            <circle cx="200" cy="150" r="50" fill="#FFCDD2">
                <animate attributeName="cx" from="200" to="600" dur="4s" repeatCount="indefinite" />
            </circle>
            <circle cx="600" cy="450" r="40" fill="#BBDEFB">
                <animate attributeName="cy" from="450" to="150" dur="4s" repeatCount="indefinite" />
            </circle>
            <circle cx="400" cy="300" r="60" fill="#FFF9C4">
                <animate attributeName="r" from="60" to="90" dur="3s" repeatCount="indefinite" />
            </circle>
        </svg>

        <!-- Contenu principal -->
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-6">
                <a href="/">
                    <x-application-logo class="w-24 h-24 fill-current text-blue-500" />
                </a>
            </div>

            <div class="content-container w-full sm:max-w-md mt-6 px-6 py-4">
                <h1 class="text-2xl font-bold text-gray-700 mb-4">Bienvenue</h1>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
