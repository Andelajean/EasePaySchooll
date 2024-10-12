<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nav Bar</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            padding: 10px 20px;
        }

        .logo {
            display: flex;
            align-items: center;
            color: black;
            font-size: 24px;
            font-weight: bold;
        }

        .logo-img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .nav-links {
            list-style: none;
            display: flex;
        }

        .nav-links li {
            margin: 0 15px;
        }

        .nav-links a {
            color: black;
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: blue;
        }

        .search-bar {
            display: flex;
            align-items: center;
        }

        .search-bar input {
            padding: 5px;
            border: none;
            border-radius: 5px;
            outline: none;
            background-color: black;
            color: white;
        }

        .search-bar button {
            margin-left: 10px;
            padding: 5px 10px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-bar button:hover {
            background-color: blue;
            color: white;
        }

        .burger {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .burger .line {
            width: 25px;
            height: 3px;
            background-color: black;
            margin: 4px;
        }

        @media (max-width: 768px) {
            .nav-links {
                position: absolute;
                right: 0;
                height: 100vh;
                top: 0;
                background-color: white;
                flex-direction: column;
                align-items: center;
                width: 50%;
                transform: translateX(100%);
                transition: transform 0.5s ease-in-out;
            }

            .nav-links li {
                margin: 20px 0;
            }

            .nav-links.active {
                transform: translateX(0%);
            }

            .burger {
                display: flex;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="{{ asset('image/logofin.jpg') }}" alt="Logo" class="logo-img">
        </div>
        <ul class="nav-links">
            <li><a href="/">Accueil</a></li>
            <li><a href="#">Apropos</a></li>
            <li><a href="{{route('paiement')}}">Paiement</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Aide</a></li>
        </ul>
        <div class="search-bar">
            <input type="text" placeholder="Verifier un paiement...">
            <button>Vérifier</button>
        </div>
        <div class="burger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
    </nav>

    <script>
        const burger = document.querySelector('.burger');
        const navLinks = document.querySelector('.nav-links');

        burger.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    </script>
</body>
</html>
