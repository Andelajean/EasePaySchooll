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
        Schema::create('paiements', function (Blueprint $table) {
            $table->string('id_paiement', 11)->primary(); // ID unique pour le paiement
            $table->string('nom_ecole');
            $table->string('telephone');
            $table->string('ville');
            $table->string('banque');
            $table->string('nom_complet');
            $table->string('classe');
            $table->string('niveau');
            $table->string('filiere')->nullable();
            $table->string('niveau_universite')->nullable();
            $table->decimal('montant', 10, 2);
            $table->text('details');
            $table->string('qr_code')->nullable(); // Champ pour le QR code
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};