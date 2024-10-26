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
        Schema::create('uniformes', function (Blueprint $table) {
            $table->id();
            $table->string('nom_eleve');
            $table->string('classe');
            $table->string('uniforme'); // 'ok' ou 'non_ok'
            $table->string('reste')->default('rien'); // Matériel
            $table->string('paiement');
            $table->string('nom_ecole');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uniformes');
    }
};
