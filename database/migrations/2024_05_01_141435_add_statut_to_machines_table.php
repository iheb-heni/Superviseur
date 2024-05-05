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
            Schema::table('machines', function (Blueprint $table) {
                $table->unsignedTinyInteger('statut')->default(0)->comment('0: Statut 0, 1: Statut 1, 2: Statut 2, 3: Statut 3');
            });
        }
        

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('machines', function (Blueprint $table) {
            //
        });
    }
};
