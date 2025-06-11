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
        Schema::create('management_finances', function (Blueprint $table) {
            $table->id();
            // Coordonnées du candidat
            $table->string('nom');
            $table->string('prenom');
            $table->enum('sexe', ['M', 'F']);
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->string('nationalite');
            $table->string('region_origine');
            $table->string('adresse');
            $table->string('telephone');
            $table->string('lycee');
            $table->string('email')->unique();
            // Information sur le bac
            $table->boolean('titulaire_bac')->default(false);
            $table->string('diplome_bac_path')->nullable();
            // Chemins des fichiers
            $table->string('bulletin_seconde_path');
            $table->string('bulletin_premiere_path');
            $table->string('bulletin_terminale_path');
            $table->string('diplome_probatoire_path');
            $table->string('piece_identite_recto_path');
            $table->string('piece_identite_verso_path');
            $table->string('certificat_scolarite_path');
            $table->string('fiche_inscription_path');
            $table->string('photo_path');
            $table->string('exam_room')->nullable();
            $table->integer('exam_seat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('management_finances');
    }
};
