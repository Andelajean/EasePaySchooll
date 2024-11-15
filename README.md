<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).









Pour réaliser un tableau de bord d'administration dans Laravel qui affiche en temps réel le nombre de paiements effectués pour chaque école, le nombre total de paiements et le nombre d'écoles inscrites, vous pouvez suivre ces étapes en utilisant les fonctionnalités de Laravel, telles que les routes, les contrôleurs, les vues et l'utilisation de WebSockets ou de l'actualisation périodique avec JavaScript.

Étape 1 : Modèle de données

Assurez-vous d’avoir les modèles nécessaires, par exemple Payment et School.

1. Modèle Payment (pour gérer les paiements) :



class Payment extends Model
{
    protected $fillable = [
        'school_id',
        'amount',
        'paid_at',  // Si vous avez une date de paiement
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}

2. Modèle School (pour gérer les écoles) :



class School extends Model
{
    protected $fillable = ['name'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}

Étape 2 : Contrôleur

Créez un contrôleur pour gérer l’affichage des données.

php artisan make:controller AdminDashboardController

Dans ce contrôleur, nous allons récupérer les données nécessaires et les passer à la vue.

use App\Models\School;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Récupérer le nombre total de paiements
        $totalPayments = Payment::count();

        // Récupérer le nombre d'écoles inscrites
        $totalSchools = School::count();

        // Récupérer le nombre de paiements par école
        $paymentsBySchool = School::withCount('payments')->get();

        return view('admin.dashboard', compact('totalPayments', 'totalSchools', 'paymentsBySchool'));
    }
}

Étape 3 : Route

Définissez une route pour afficher le tableau de bord.

use App\Http\Controllers\AdminDashboardController;

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

Étape 4 : Vue (Blade)

Créez une vue resources/views/admin/dashboard.blade.php pour afficher les informations sur le tableau de bord. Vous pouvez utiliser un tableau ou d'autres éléments pour afficher les données.

@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Tableau de bord Administrateur</h1>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Total des Paiements</div>
                    <div class="card-body">
                        <p>{{ $totalPayments }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Total des Écoles Inscrites</div>
                    <div class="card-body">
                        <p>{{ $totalSchools }}</p>
                    </div>
                </div>
            </div>
        </div>

        <h3>Paiements par École</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>École</th>
                    <th>Nombre de Paiements</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentsBySchool as $school)
                    <tr>
                        <td>{{ $school->name }}</td>
                        <td>{{ $school->payments_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

Étape 5 : Actualisation en temps réel

Pour que les données soient mises à jour en temps réel, vous pouvez utiliser une approche par polling avec JavaScript ou bien des WebSockets si vous avez besoin de plus de réactivité.

Solution avec JavaScript (Polling)

Vous pouvez utiliser JavaScript pour rafraîchir les données toutes les quelques secondes.

Dans la vue Blade, ajoutez le script suivant pour interroger le serveur toutes les 5 secondes et mettre à jour les données :

<script>
    function fetchData() {
        fetch('{{ route('admin.dashboard') }}')
            .then(response => response.text())
            .then(html => {
                // Vous pouvez utiliser un innerHTML pour remplacer le contenu de certaines sections ou autres méthodes de mise à jour
                document.querySelector('.container').innerHTML = html;
            });
    }

    setInterval(fetchData, 5000); // Rafraîchissement toutes les 5 secondes
</script>

Cela permettra de mettre à jour le tableau de bord toutes les 5 secondes. Si vous avez besoin d'une mise à jour en temps réel plus avancée, vous pouvez implémenter une solution avec Laravel Echo et Pusher ou Redis pour envoyer des événements en temps réel.

Étape 6 : (Optionnel) Laravel Echo et Pusher pour une mise à jour en temps réel

1. Installer Laravel Echo et Pusher :



composer require pusher/pusher-php-server
npm install --save laravel-echo pusher-js

2. Configurer Pusher dans .env :



BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-app-key
PUSHER_APP_SECRET=your-app-secret
PUSHER_APP_CLUSTER=your-app-cluster

3. Configurer Laravel Echo et les événements en temps réel pour envoyer des mises à jour lors de l’ajout d’un paiement, par exemple.



Cela serait plus complexe, mais vous garantiriez que le tableau de bord s’actualise en temps réel sans avoir besoin de faire des appels de polling réguliers.

Conclusion

Avec cette approche, vous avez un tableau de bord d'administration Laravel qui affiche les statistiques en temps réel, avec la possibilité d'ajouter des fonctionnalités de mise à jour dynamique via JavaScript ou des WebSockets pour des mises à jour plus instantanées.





