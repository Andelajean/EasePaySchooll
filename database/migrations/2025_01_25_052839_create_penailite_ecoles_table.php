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
        Schema::create('penailite_ecoles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ecole_id')->constrained('ecoles')->onDelete('cascade'); // Référence à la table des écoles
            $table->string('classe'); // Classe associée à la pénalité
            $table->date('date_debut'); // Date de début
            $table->string('tranche'); // Tranche (ex: Première tranche)
            $table->string('frequence'); // Fréquence (Jour, Semaine, Mois)
            $table->decimal('montant', 10, 2); // Montant de la pénalité
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penailite_ecoles');
    }
};
