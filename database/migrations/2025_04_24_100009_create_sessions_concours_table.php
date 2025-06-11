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
        Schema::create('sessions_concours', function (Blueprint $table) {
            $table->id();
            $table->string('nom_session');
            $table->string('nom_filiere');
            $table->date('date_debut');
            $table->date('date_concours');
            $table->date('date_fin');
            $table->enum('statut', ['ouverte', 'fermee'])->default('ouverte');
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions_concours');
    }
};
