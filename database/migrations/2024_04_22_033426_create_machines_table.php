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
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->integer('TIM')->default(0); // Temps en millisecondes pour la colonne TIM
            $table->integer('TDG')->default(0); // Temps en millisecondes pour la colonne TDG
            $table->integer('TP')->default(0);  // Temps en millisecondes pour la colonne TP
            $table->integer('TI')->default(0);  // Temps en millisecondes pour la colonne TI
            $table->integer('TO')->default(0);  // Temps en millisecondes pour la colonne TO
            $table->timestamps(); // Ajoute les colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
