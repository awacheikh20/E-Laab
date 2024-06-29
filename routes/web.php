<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('/')->controller(App\Http\Controllers\Elaab::class)->group(function(){
    Route::get('/','accueil')->name('accueil');
    Route::get('/connexion','login')->name('login');
    Route::post('/connexion','seconnect');
    Route::delete('/deconnexion','logout')->name('logout');

    Route::middleware(['auth'])->group(function () {
        Route::prefix('/joueur')->controller(App\Http\Controllers\Etudiant::class)->group(function(){
            Route::get('/dashboard','dashboard')->name('EtudiantDashboard');
            Route::get('/evaluations','EtudiantEvaluation')->name('EtudiantEvaluations');
            Route::get('/evaluation/avenir/','EvaluationAvenir')->name('EvaluationAvenir');
            Route::get('/evaluation/traitement/{id}','traitementEvaluation')->name('traitementEvaluation');
            Route::post('/evaluation/traitement/{id}','postTraitementEvaluation')->name('postTraitementEvaluation');
            // Route::get('/Evaluation','Evaluation')->name('EvaluationEvaluation');
            // Route::get('/planning','planning')->name('planning');
            Route::get('/planning','planning')->name('EvaluationPlanning');
    //         Route::get('/layout','layout')->name('Evaluationlayout');


        });
    });
    Route::middleware(['auth'])->group(function () {
        Route::prefix('/enseignant')->controller(App\Http\Controllers\Enseignant::class)->group(function(){
            Route::get('/dashboard','dashboard')->name('EnseignantDashboard');
            Route::get('/test','test')->name('test');
            Route::get('/evaluation','evaluations')->name('EnseignantEvaluations');
            Route::get('/evaluation/{id}','evaluation')->where('id', '[0-9]+')->name('EnseignantEvaluation');
            Route::get('/evaluation/ajouter','EnseignantCreeEvaluation')->name('EnseignantCreeEvaluation');
            Route::post('/evaluation/ajouter','EnseignantPostCreeEvaluation')->name('EnseignantPostCreeEvaluation');
            Route::get('/evaluation/bilan','EnseignantBilanEvaluation')->name('EnseignantBilanEvaluation');
            Route::post('/evaluation/bilan','EnseignantPostBilanEvaluation')->name('EnseignantPostBilanEvaluation');
            Route::get('/evaluation/validation','EnseignantValidationEvaluation')->name('EnseignantValidationEvaluation');
            Route::get('/planning','planning')->name('EnseignantPlanning');
    //         Route::get('/etudiants','etudiants')->name('EnseignantEvaluations');
            Route::get('/classes','classes')->name('EnseignantClasses');
            Route::get('/classes/{id}','classesEvalu')->where('id', '[0-9]+')->name('classesEvalu');
            Route::get('/classes/etudiants/{idEval}/{idClasse}','classesEtu')->name('classesEtu');
            Route::get('/classes/etudiants/evaluation/{idEvaluation}/{idEtudiant}','evaluEtudiant')->name('evaluEtudiant');
        });
    });

});
