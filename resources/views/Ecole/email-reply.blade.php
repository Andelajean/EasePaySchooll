<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue à EasePaySchool</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            background-color: #fff;
            margin: 20px auto;
            padding: 20px;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #004b8d;
        }
        .email-header img {
            max-width: 150px;
        }
        .email-header h1 {
            font-size: 24px;
            color: #004b8d;
        }
        .email-content {
            padding: 20px;
            line-height: 1.6;
        }
        .email-content h2 {
            color: #004b8d;
            font-size: 22px;
        }
        .email-content p {
            font-size: 16px;
        }
        .email-footer {
            text-align: center;
            padding: 20px;
            background-color: #f4f4f4;
            border-top: 1px solid #ccc;
            margin-top: 20px;
        }
        .email-footer p {
            font-size: 12px;
            color: #777;
        }
        .cta-button {
            display: inline-block;
            background-color: #004b8d;
            color: #fff;
            padding: 10px 20px;
            margin: 20px 0;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="email-container">
    <!-- Header Section -->
    <div class="email-header">
        <img src="{{asset('image/logofin.jpg')}}" alt="EasePaySchool Logo">
        <h1>Bienvenue à EasePaySchool</h1>
    </div>

    <!-- Email Content -->
    <div class="email-content">
        <p>Bonjour <strong>{{ $email }}</strong>,</p>
        <p>{{ $message }}</p>
        <p>Avec EasePaySchool, <em>"Payer une fois et enregistrer pour toujours"</em>.</p>

        <a href="https://easepayschool.com/dasboard" class="cta-button">Accéder à votre compte</a>
    </div>

    <!-- Footer Section -->
    <div class="email-footer">
        <p>Développé par <strong>TrueSiteTechnology</strong>.</p>
        <p>Si vous avez des questions, n'hésitez pas à nous contacter à easepayschool@gmail.com.</p>
    </div>
</div>
@include('Page.footer')
</body>
</html>
