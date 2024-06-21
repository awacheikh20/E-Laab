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
            $table->timestamps();
        });

        Schema::create('evaluclasses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classe');
            $table->unsignedBigInteger('evaluation');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
            
            // Foreign keys
            $table->foreign('classe')
                  ->references('id')->on('classes')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');

            $table->foreign('evaluation')
                  ->references('id')->on('evaluations')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('nombrePoint');
            $table->foreignId('evaluation')->constrained('evaluations')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
        });

        Schema::create('propositions', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->boolean('estCorrecte');   
            $table->foreignId('question')->constrained('questions')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
        });

        Schema::create('reponses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant')->constrained('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('proposition')->constrained('propositions')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
        });

        Schema::create('resultats', function (Blueprint $table) {
            $table->id();
            $table->float('note');
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
        Schema::dropIfExists('evaluclasses');
        Schema::dropIfExists('propositions');
        Schema::dropIfExists('reponses');
        Schema::dropIfExists('resultats');
    }
};
