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
    Schema::create('classes', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_ecole'); 
        $table->string('nom_classe');
        $table->string('premiere_tranche')->nullable();
        $table->string('deuxieme_tranche')->nullable();
        $table->string('troisieme_tranche')->nullable();
        $table->string('quatrieme_tranche')->nullable();
        $table->string('cinquieme_tranche')->nullable();
        $table->string('sixieme_tranche')->nullable();
        $table->string('septieme_tranche')->nullable();
        $table->string('huitieme_tranche')->nullable();
        $table->string('totalite')->nullable();
        $table->timestamps();
        $table->foreign('id_ecole')
              ->references('id')
              ->on('ecoles')
              ->onDelete('cascade'); 
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
