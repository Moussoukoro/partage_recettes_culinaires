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
        Schema::create('recettes', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->text('ingredient');
            $table->text('instruction');
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->dateTime('dateCreation');
            $table->time('heureCreation');
            $table->foreignId('visiteur_id')->constrained('visiteurs')->onDelete('cascade');
            $table->integer('tempsPreparation');
            $table->timestamps();
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recettes');
    }
};
