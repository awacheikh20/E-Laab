<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Question;
use App\Models\Proposition;
use App\Models\Evaluclasse;
use App\Models\Reponse;
use App\Models\Resultat;
use Carbon\Carbon;

class Etudiant extends Controller
{
   public function layout(){
    return view('etudiant.layout');
   }
   public function dashboard(){
      $evaluation = Evaluation::where('dateDebutheure', '>', now())->get();
      $attente= $evaluation->count();
    return view('etudiant.dashboard');
   }
   public function evaluations(){
      $resultatExist = Resultat::where('etudiant',auth()->id())->value('evaluation');
      $note = Resultat::where('etudiant',auth()->id())->value('note');
      $appreciation = Resultat::where('etudiant',auth()->id())->value('appreciation');
      $evaluation = Evaluation::where('id', $resultatExist)->get();
      // dd($resultatExist);
      return view('etudiant.evaluations',[
         'evaluations' => $evaluation,
         'note' => $note,
         'appreciation' => $appreciation
      ]);
   }

  
   public function  evaluationAvenir(){
      $evaluation = Evaluation::where('dateDebutHeure','>=', now())->get();
      return view('etudiant.evaluationsAvenir',[
         'evaluations' => $evaluation,
      ]);
   }

   public function traitementEvaluation($id){
      $evaluation = Evaluation::where('id',$id)->first();
      $questions = Question::where('evaluation',$id)->get();
      foreach ($questions as $question) {  
         $propositions[] = Proposition::where('question',$question->id)->get();
      }
      // dd($evaluation, $questions, $propositions);
      return view('etudiant.traitementEvaluation',[
         'evaluation' => $evaluation ,
         'propositions' => $propositions ,
         'questions' => $questions
      ]);
   }

   public function postTraitementEvaluation(Request $request, $id){
      $evaluation = Evaluation::where('id',$id)->get();
      $questions = Question::where('evaluation',$id)->get();
      $reponses = $request->input('reponses'); // Tableau des réponses
      // dd($reponses);
      $totalTrouve=0;
      $points=0;
      foreach ($questions as $index => $question) {
         foreach ($reponses[$index] as $reponseText) {
             // Récupérer l'ID de la proposition à partir du libellé de la réponse
             $proposition = Proposition::where('libelle', $reponseText)->latest()->first();
             $propos = Proposition::where('libelle', $reponseText)->value('id');
             //  dd($proposition);
             if ($proposition) {
                 Reponse::create([
                     'etudiant' => auth()->id(),
                     'proposition' => $propos
                 ]);

                 if ($proposition->estCorrecte) {
                     $points++;
                 }
             }
         }
         $pointQuestion = $question->nombrePoint;
         $countPropo = Proposition::where('estCorrecte',1)
         ->where('question',$question->id)
         ->count();
         $totalTrouve=$totalTrouve + ($points * $pointQuestion)/$countPropo;
         $points=0;
      }
      //   dd($totalTrouve);
      $appreciation = '';
      if($totalTrouve<10){
         $appreciation="FAIBLE";
      }elseif($totalTrouve>=10 && $totalTrouve<12) {
         $appreciation="PASSABLE";
      }elseif($totalTrouve>=12 && $totalTrouve<14) {
         $appreciation="ABIEN";
      }elseif($totalTrouve>=14 && $totalTrouve<16) {
         $appreciation="BIEN";
      }elseif($totalTrouve>=16 && $totalTrouve<18) {
         $appreciation="TRES BIEN";
      }elseif($totalTrouve>=18 && $totalTrouve<20) {
         $appreciation="EXCELLENT";
      }
      $resultat = Resultat::create([
         'note'=> $totalTrouve,
         'appreciation' => $appreciation,
         'etudiant' => auth()->id(),
         'evaluation' => $id

      ]);
      return redirect()->route('EtudiantEvaluations')->with('success','L\'évaluation  a été effectuée avec succès!');
   }

   
}
