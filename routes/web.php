<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Elaab;
use App\Http\Controllers\Enseignant;
use App\Http\Controllers\Etudiant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Livewire\Counter;

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

    Route::middleware(['auth','etudiant'])->group(function () {
        Route::prefix('/etudiant')->controller(App\Http\Controllers\Etudiant::class)->group(function(){
            Route::get('/dashboard','dashboard')->name('EtudiantDashboard');
            Route::get('/evaluations','evaluations')->name('EtudiantEvaluations');
            Route::get('/evaluations/avenir/','evaluationAvenir')->name('evaluationAvenir');
            Route::get('/evaluation/traitement/{id}','traitementEvaluation')->name('traitementEvaluation');
            Route::post('/evaluation/traitement/{id}','postTraitementEvaluation')->name('postTraitementEvaluation');
            Route::get('/evaluation','evaluation')->name('EtudiantEvaluation');
            Route::get('/planning','planning')->name('EtudiantPlanning');
            Route::get('/layout','layout')->name('Etudiantlayout');


        });
    });
    Route::middleware(['auth','enseignant'])->group(function () {
        Route::prefix('/enseignant')->controller(App\Http\Controllers\Enseignant::class)->group(function(){
            Route::get('/dashboard','dashboard')->name('EnseignantDashboard');
            Route::get('/evaluations','evaluations')->name('EnseignantEvaluations');
            Route::get('/evaluation/{id}','evaluation')->where('id', '[0-9]+')->name('EnseignantEvaluation');
            Route::get('/evaluation/ajouter','EnseignantCreeEvaluation')->name('EnseignantCreeEvaluation');
            Route::post('/evaluation/ajouter','EnseignantPostCreeEvaluation')->name('EnseignantPostCreeEvaluation');
            Route::get('/evaluation/bilan','EnseignantBilanEvaluation')->name('EnseignantBilanEvaluation');
            Route::post('/evaluation/bilan','EnseignantPostBilanEvaluation')->name('EnseignantPostBilanEvaluation');
            Route::get('/evaluation/validation','EnseignantValidationEvaluation')->name('EnseignantValidationEvaluation');
            Route::get('/planning','planning')->name('EnseignantPlanning');
            Route::get('/etudiants','etudiants')->name('EnseignantEtudiants');
            Route::get('/classes','classes')->name('EnseignantClasses');

        });
    });

});
