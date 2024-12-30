<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function generateSitemap()
    {
$filePath = public_path('sitemap.xml');

    if (file_exists($filePath)) {
        unlink($filePath); // Supprimez l'ancien fichier si nécessaire
    }
        Sitemap::create()
            ->add(Url::create('/')->setLastModificationDate(\Carbon\Carbon::now()))
            ->add(Url::create('/about')->setLastModificationDate(\Carbon\Carbon::now()))
            ->add(Url::create('/help')->setLastModificationDate(\Carbon\Carbon::now()))
            ->add(Url::create('/paiement')->setLastModificationDate(\Carbon\Carbon::now()))
            ->add(Url::create('/register')->setLastModificationDate(\Carbon\Carbon::now()))
            ->add(Url::create('/login')->setLastModificationDate(\Carbon\Carbon::now()))
            ->add(Url::create('/ecole/contactadmin')->setLastModificationDate(\Carbon\Carbon::now()))
             ->writeToFile($filePath);

    if (file_exists($filePath)) {
        return response()->json(['message' => 'Sitemap generated successfully!', 'path' => $filePath]);
    }

    return response()->json(['message' => 'Failed to generate sitemap!', 'path' => $filePath], 500);    }
}
