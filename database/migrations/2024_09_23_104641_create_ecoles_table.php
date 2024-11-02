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
        Schema::create('ecoles', function (Blueprint $table) {
            $table->id();
            $table->string('nom_ecole')->unique();
            $table->string('email')->unique();
            $table->string('identifiant', 11)->unique();
            $table->string('ville');
            $table->string('niveau');
            $table->string('telephone')->unique();
            $table->string('nom_banque1');
            $table->string('numero_banque1');
            $table->string('nom_banque2')->nullable();
            $table->string('numero_banque2')->nullable();
            $table->string('nom_banque3')->nullable();
            $table->string('numero_banque3')->nullable();
            $table->string('nom_banque4')->nullable();
            $table->string('numero_banque4')->nullable();
            $table->string('nom_banque5')->nullable();
            $table->string('numero_banque5')->nullable();
            $table->string('nom_banque6')->nullable();
            $table->string('numero_banque6')->nullable();
            $table->string('nom_banque7')->nullable();
            $table->string('numero_banque7')->nullable();
            $table->string('nom_banque8')->nullable();
            $table->string('numero_banque8')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecoles');
    }
};
