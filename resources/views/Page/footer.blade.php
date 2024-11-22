<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <!-- Footer -->
    <footer class="bg-white text-gray-800 py-8">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 px-4">
            <!-- Adresse -->
            <div>
                <h3 class="text-lg font-bold mb-4">Adresse</h3>
                <p>123 Rue Principale</p>
                <p>Yaoundé, Cameroun</p>
                <p>Code Postal: 12345</p>
            </div>

            <!-- Service Client -->
            <div>
                <h3 class="text-lg font-bold mb-4">Service Client</h3>
                <ul>
                    <li><a href="{{route('help')}}" class="hover:text-blue-500">FAQ</a></li>
                    <li>Disponible 24/24 7/7</li>
                   
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-lg font-bold mb-4">Contact</h3>
                <p>Téléphone : +237 673 429 591 / 679 091 819 / 659 454 737</p>
                <p>Email : <a href="mailto:easepayschool@gmail.com" class="hover:text-blue-500">easepayschool@gmail.com</a></p>
                <p>Disponible : Lun - Ven, 9h - 18h</p>
            </div>

            <!-- Follow Us -->
            <div>
                <h3 class="text-lg font-bold mb-4">Suivez-nous</h3>
                <div class="flex space-x-4">
                    <!-- Facebook -->
                    <a href="#" class="hover:text-blue-600">
                        <div class="flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.99 3.66 9.12 8.44 9.88v-6.99h-2.54v-2.89h2.54V9.88c0-2.49 1.49-3.89 3.78-3.89 1.1 0 2.24.2 2.24.2v2.48h-1.26c-1.24 0-1.63.77-1.63 1.56v1.86h2.78l-.44 2.89h-2.34v6.99C18.34 21.12 22 16.99 22 12z"/>
                            </svg>
                        </div>
                    </a>
                    <!-- Twitter/X -->
                    <a href="#" class="hover:text-black">
    <div class="flex items-center justify-center w-10 h-10 bg-black text-white rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M24 0L14.4 11.13 24 24H19.2L12 14.4 4.8 24H0l9.6-12.87L0 0h4.8L12 9.6 19.2 0H24Z"/>
        </svg>
    </div>
</a>


                    <!-- Telegram -->
                    <a href="#" class="hover:text-blue-500">
                        <div class="flex items-center justify-center w-10 h-10 bg-blue-500 text-white rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22 3L2 11.5l4 1.5 2 7.5L22 3zM7 11l5 2 7.5-7-10 13H7v-2z"/>
                            </svg>
                        </div>
                    </a>
                    <!-- Instagram -->
                    <a href="#" class="hover:text-pink-500">
                        <div class="flex items-center justify-center w-10 h-10 bg-pink-500 text-white rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7 2c-2.76 0-5 2.24-5 5v10c0 2.76 2.24 5 5 5h10c2.76 0 5-2.24 5-5V7c0-2.76-2.24-5-5-5H7zm3 3h4c1.11 0 2 .89 2 2v4c0 1.11-.89 2-2 2h-4c-1.11 0-2-.89-2-2V7c0-1.11.89-2 2-2zm8 5c.55 0 1 .45 1 1s-.45 1-1 1h-4c-.55 0-1-.45-1-1s.45-1 1-1h4z"/>
                            </svg>
                        </div>
                    </a>
                    <!-- WhatsApp -->
                   <a href="#" class="hover:text-green-500">
    <div class="flex items-center justify-center w-10 h-10 bg-green-500 text-white rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M20.52 3.48A11.8 11.8 0 0 0 12 0a11.8 11.8 0 0 0-8.52 3.48A11.8 11.8 0 0 0 0 12a11.93 11.93 0 0 0 1.66 6.1l-1.1 4.03a.74.74 0 0 0 .9.9l4.03-1.1A11.93 11.93 0 0 0 12 24a11.8 11.8 0 0 0 8.52-3.48A11.8 11.8 0 0 0 24 12a11.8 11.8 0 0 0-3.48-8.52ZM12 22.03a10.21 10.21 0 0 1-5.2-1.42.76.76 0 0 0-.57-.07l-3.38.92.92-3.38a.76.76 0 0 0-.07-.57A10.23 10.23 0 0 1 1.98 12a10.32 10.32 0 0 1 3.04-7.37A10.32 10.32 0 0 1 12 1.98a10.32 10.32 0 0 1 7.37 3.04A10.32 10.32 0 0 1 22.02 12a10.32 10.32 0 0 1-3.04 7.37A10.32 10.32 0 0 1 12 22.02ZM17.68 15.75c-.42-.21-2.48-1.23-2.87-1.37-.38-.14-.65-.21-.91.22-.26.42-1.05 1.37-1.28 1.64-.24.26-.48.28-.9.07-.42-.21-1.77-.65-3.37-2.07a12.53 12.53 0 0 1-2.31-2.86c-.24-.42 0-.64.18-.85.17-.18.38-.48.57-.71.2-.24.26-.42.4-.7.13-.27.07-.52-.04-.74-.11-.22-.92-2.2-1.26-3.03-.33-.82-.66-.7-.91-.71h-.78c-.26 0-.7.1-1.06.5-.36.4-1.4 1.37-1.4 3.34s1.44 3.88 1.64 4.16c.2.27 2.83 4.33 6.89 6.06 2.64 1.15 3.69 1.25 5 .92.79-.18 2.48-1.01 2.83-1.98.35-.97.35-1.8.24-1.98-.1-.18-.39-.29-.81-.5Z"/>
        </svg>
    </div>
</a>

                    <!-- LinkedIn -->
                    <a href="#" class="hover:text-blue-700">
                        <div class="flex items-center justify-center w-10 h-10 bg-blue-700 text-white rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.23 22.23H17.85V15.5c0-1.6-.57-2.69-1.99-2.69-1.09 0-1.73.73-2.02 1.43-.1.24-.13.58-.13.92v7.04H9.92V9.19h3.78v1.86h.05c.5-.96 1.61-1.76 3.15-1.76 2.38 0 4.17 1.55 4.17 4.92v6.12zM2.77 6.46c0-.79.65-1.44 1.44-1.44s1.44.65 1.44 1.44c0 .79-.65 1.44-1.44 1.44-.79 0-1.44-.65-1.44-1.44zM4.21 22.23H1.32V9.19h2.89v13.04zM22 1.32c-.79 0-1.44.65-1.44 1.44 0 .79.65 1.44 1.44 1.44s1.44-.65 1.44-1.44c0-.79-.65-1.44-1.44-1.44z"/>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
