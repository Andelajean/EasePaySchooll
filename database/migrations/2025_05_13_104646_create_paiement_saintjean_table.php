<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paiement_saintjean', function (Blueprint $table) {
            $table->id(); // ID auto-incrémenté
            $table->string('filiere_concours'); // Filière du concours
            $table->string('nom_concourant'); // Nom du concourant
            $table->string('id_paiement')->unique(); // ID de paiement généré
            $table->string('photo_concourant')->nullable(); // Chemin de la photo
            $table->decimal('somme_deboursee', 10, 2); // Montant déboursé
            $table->string('numero_telephone'); // Numéro de téléphone
            $table->date('date_paiement'); // Date du paiement
            $table->time('heure_paiement'); // Heure du paiement
            $table->string('qr_code_path')->nullable(); // Chemin du QR Code généré
            $table->timestamps(); // Colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiement_saintjean');
    }
};
