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
            $table->string('nom')->unique();
            $table->timestamps();
        });
        
        Schema::create('matieres', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->foreignId('enseignant')->constrained('users')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
        });

        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->string('duree');
            $table->dateTime('dateDebutHeure')->unique();
            $table->foreignId('enseignant')->constrained('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('matiere')->constrained('matieres')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('classe')->constrained('classes')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('nombrePoint');
            $table->foreignId('evaluation')->constrained('evaluations')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
        });

        Schema::create('correction', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->foreignId('evaluation')->constrained('evaluations')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
        });

        Schema::create('reponses', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->unique();
            $table->boolean('estCorrecte');
            $table->foreignId('etudiant')->constrained('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('question')->constrained('questions')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
        });

        Schema::create('resultats', function (Blueprint $table) {
            $table->id();
            $table->float('note')->unique();
            $table->string('appreciation');
            $table->foreignId('etudiant')->constrained('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('evaluation')->constrained('evaluations')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
        Schema::dropIfExists('matieres');
        Schema::dropIfExists('evaluations');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('correction');
        Schema::dropIfExists('reponses');
        Schema::dropIfExists('resultats');
    }
};
