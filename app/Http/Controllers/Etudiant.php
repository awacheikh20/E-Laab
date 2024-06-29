<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\Question;
use App\Models\Proposition;
use App\Models\Evaluclasses;
use App\Models\Reponse;
use App\Models\Resultat;
use Carbon\Carbon;

class Etudiant extends Controller
{
   public function layout(){
    return view('etudiant.layout');
   }
   public function dashboard(){
      $evaluation = Evaluation::where('dateDebut','>',now())
        ->get();
        $nbevaluation = $evaluation->count();

        $totalEvaluation = Evaluation::where('dateDebut','<=',now())
        ->get();
        $totalEvaluationAchevee = $totalEvaluation->count();

        $totalEvaluationCree = Evaluation::count();

      $evaluation = Evaluation::get();
      $attente= $evaluation->count();

      $plans = Evaluation::orderBy('dateDebut')
      ->where('dateDebut', '>=', now())
      ->paginate(6);

      $planElems = Evaluation::orderBy('dateDebut')
      ->where('dateDebut', '>=', now())
      ->get();

      $planningJour=[];
      $planningMoisAnnee=[];
      foreach ($plans as $key => $plan) {
         $planningJour[$key] = Carbon::parse($plan['dateDebut'])->translatedFormat('j');
         $planningMoisAnnee[$key] = Carbon::parse($plan['dateDebut'])->translatedFormat('F Y');
      }
    return view('etudiant.dashboard',[
         'planElems' => $planElems,
          'plans' => $plans,
          'planningJour' => $planningJour,
          'planningMoisAnnee' => $planningMoisAnnee,
          'enattente' => $nbevaluation,
            'totalEvaluation' => $totalEvaluationCree,
            'totalEvaluationAchevee' => $totalEvaluationAchevee
    ]);
   }
   public function EtudiantEvaluation(){
      $resultatExists = Resultat::where('etudiant',auth()->id())->distinct()->pluck('evaluation');
      // dd($resultatExists);
      $evaluation=[];
      $note=[];
      $appreciation=[];
      foreach ($resultatExists as $key => $resultatExist) {
         $evaluation[$key] = Evaluation::where('id', $resultatExist)->first();
         $note[$key] = Resultat::where('etudiant',auth()->id())
         ->where('evaluation',$resultatExist)
         ->value('score');

         $appreciation[$key] = Resultat::where('etudiant',auth()->id())
         ->where('evaluation',$resultatExist)
         ->value('appreciation');
      }
      // dd($appreciation);
      return view('etudiant.evaluations',[
         'evaluations' => $evaluation,
         'note' => $note,
         'appreciation' => $appreciation
      ]);
   }

  
   public function  evaluationAvenir(){
      $evaluation = Evaluation::where('dateDebut','>=', now())->get();
      return view('etudiant.evaluationAvenir',[
         'evaluations' => $evaluation,
      ]);
   }

   public function traitementEvaluation($id){
      $evaluation = Evaluation::where('id',$id)->first();
      $resultat = Resultat::where('etudiant',auth()->id())
      ->where('evaluation',$evaluation->id)
      ->count();
      if ($resultat !== 0) {
         return redirect()->route('EvaluationAvenir')->with('message', 'Vous avez déjà effectué à cette évaluation!');
     } elseif ($evaluation->dateDebut > now()) {
         return redirect()->route('EvaluationAvenir')->with('message', 'Vous ne pouvez pas encore effectuer à cette évaluation!');
     } elseif ($evaluation->dateDebut <= now()) {
         $questions = Question::where('evaluation', $id)->get();
         $propositions = [];
         foreach ($questions as $question) {
             $propositions[] = Proposition::where('question', $question->id)->get();
         }
         // dd($evaluation, $questions, $propositions);
         return view('etudiant.traitementEvaluation', [
             'evaluation' => $evaluation,
             'propositions' => $propositions,
             'questions' => $questions
         ]);
     }
      
   }

   public function postTraitementEvaluation(Request $request, $id){
      $evaluation = Evaluation::where('id',$id)->get();
      $questions = Question::where('evaluation',$id)->get();
      $reponse = $request->input('reponses'); // Tableau des réponses
      $totalTrouve=0;
      $points=0;
      foreach ($questions as $index => $question) {
         foreach ($reponse[$index] as $reponseText) {
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
      $appreciation = ' ';
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
      }elseif($totalTrouve>=18) {
         $appreciation="EXCELLENT";
      }
      $resultat = Resultat::create([
         'score'=> $totalTrouve,
         'appreciation' => $appreciation,
         'etudiant' => auth()->id(),
         'evaluation' => $id

      ]);
      return redirect()->route('EtudiantEvaluations')->with('success','L\'évaluation  a été effectuée avec succès!');
   }
   public function planning(){
      $plans = Evaluation::orderBy('dateDebut')
      ->where('dateDebut', '>=', now())
      ->paginate(6);

      $planElems = Evaluation::orderBy('dateDebut')
      ->where('dateDebut', '>=', now())
      ->get();

      $planningJour=[];
      $planningMoisAnnee=[];
      foreach ($plans as $key => $plan) {
         $planningJour[$key] = Carbon::parse($plan['dateDebut'])->translatedFormat('j');
         $planningMoisAnnee[$key] = Carbon::parse($plan['dateDebut'])->translatedFormat('F Y');
      }
      

      return view('etudiant.planning',[
          'planElems' => $planElems,
          'plans' => $plans,
          'planningJour' => $planningJour,
          'planningMoisAnnee' => $planningMoisAnnee,
      ]);

  }


   
}