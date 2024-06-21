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
use App\Http\Requests\creerFormEvaluation;
use Carbon\Carbon;

class Enseignant extends Controller
{
    public function layout(){
        return view('enseignant.layout');
    }
    public function dashboard(Request $request){
        $evaluation = $request->session()->get('evaluation');
        return view('enseignant.dashboard');
    }
    public function evaluations(){
        $evaluations = Evaluation::get();
        //dd($evaluations);
        return view('enseignant.evaluations',[
            'evaluations' => $evaluations
        ]);
    }

    public function evaluation($id){
        $evaluation = Evaluation::where('id',$id)->first();
        $questions = Question::where('evaluation',$id)->get();
        $propositions = [];
    
        foreach ($questions as $question) {  
            $propositions[] = Proposition::where('question',$question->id)->get();
        }
    
        return view('enseignant.evaluation', [
            'evaluation' => $evaluation,
            'propositions' => $propositions,
            'questions' => $questions
        ]);
    }
    
    public function EnseignantCreeEvaluation(){
        Session()->forget('evaluation');
        $matieres = Matiere::where('enseignant', Auth::user()->id)->get();
        $classes = Classe::get();
        return view('enseignant.CreeEvaluation',[
            'matieres' => $matieres,
            'classes' => $classes,
        ]);
    }

    public function EnseignantPostCreeEvaluation(creerFormEvaluation $request)
{
    // Récupérer les données validées du formulaire
    $donneesValidees = $request->validated();

    // Stocker les données validées en session
    $evaluation = [
        'nom' => $donneesValidees['nom'],
        'date' => $donneesValidees['date'],
        'debut' => $donneesValidees['debut'],
        'duree' => $donneesValidees['duree'],
        'questions' => [],
        'matieres' => $donneesValidees['matieres'],
        'classes' => $donneesValidees['classes'],
    ];

    foreach ($donneesValidees['questions'] as $index => $question) {
        $evaluation['questions'][$index]['libelle'] = $question['libelle'];
        $evaluation['questions'][$index]['points'] = $question['points'];
        $evaluation['questions'][$index]['propositions'] = $donneesValidees['propositions'][$index];
    }

    // Stocker l'évaluation complète en session
    session()->put('evaluation', $evaluation);

    // Rediriger ou effectuer d'autres actions
    return to_route('EnseignantBilanEvaluation');
}
public function EnseignantPostBilanEvaluation(Request $request)
{
    // Récupérer l'évaluation depuis la session
    $evaluation = $request->session()->get('evaluation');

    // Parcourir chaque question
    foreach ($evaluation['questions'] as $key => $question) {
        // Récupérer les corrections pour cette question à partir des données soumises
        $corrections = $request->input('corrections.'. $key, []);
        
        // Mettre à jour les corrections dans le tableau d'évaluation
        $evaluation['questions'][$key]['corrections'] = $corrections;
    }

    // Afficher ou traiter les corrections pour chaque question
    foreach ($evaluation['questions'] as $key => $question) {
        echo "Corrections pour la question " . $key . ": ";
        print_r($question['corrections']);
        echo "<br>";
    }
    session()->put('evaluation', $evaluation);
    // Debug pour vérifier les données d'évaluation mises à jour
    $evaluation = $request->session()->get('evaluation');
    $datetime = $evaluation['date'].' '.$evaluation['debut'].':00';
    $newEvaluation = Evaluation::create([
        'nom' => $evaluation['nom'],
        'duree' => $evaluation['duree'],
        'dateDebutHeure' => $datetime,
        'enseignant' => Auth::user()->id,
        'matiere' => Matiere::where('nom',$evaluation['matieres'][0])->value('id')
    ]);

    $idEvaluation = Evaluation::where('nom', $evaluation['nom'])->value('id');
    foreach ($evaluation['classes'] as $classe) {
        $evaluClasse = Evaluclasse::create([
            'evaluation' => $idEvaluation,
            'classe' => Classe::where('nom',$classe)->value('id')
        ]);
        
    }
    foreach ($evaluation['questions'] as $question) {
        $questionCreate = Question::create([
            'libelle' => $question['libelle'],
            'nombrepoint' => $question['points'],
            'evaluation' => $idEvaluation
        ]);
        
        $idquestion = Question::where('libelle',$question['libelle'])->value('id');
        foreach ($question['propositions'] as $proposition) {
            $proposition = Proposition::create([
                'libelle' => $proposition,
                'question' => $idquestion,
                'estCorrecte' => 0,
            ]);

            foreach ($question['corrections'] as $key => $correct) {
                $idPropo = Proposition::where('libelle',$correct)->latest('id')->first();
               if($idPropo){
                    $idPropo->estCorrecte = 1;
                    $idPropo->save();
               }
            }

        }
    }
    return to_route('EnseignantEvaluations')->with('success','L\'évaluation '.$evaluation['nom'].' a été créée avec succès!');

}


    public function EnseignantBilanEvaluation(Request $request){
        $evaluation = $request->session()->get('evaluation');
        $evaluationJson = json_encode($evaluation);
        // dd($evaluation);
        
        return view('enseignant.bilan',[
            'evaluation'=>$evaluation
        ]);
    }
    public function EnseignantValidationEvaluation(Request $request){
        $evaluation = $request->session()->get('evaluation');
        $datetime = $evaluation['date'].' '.$evaluation['debut'];
        $newEvaluation = Evaluation::create([
            'nom' => $evaluation['nom'],
            'duree' => $evaluation['duree'],
            'dateDebutHeure' => $datetime,
            'enseignant' => Auth::user()->id,
            'matiere' => Matiere::where('nom',$evaluation['matieres'][0])->value('id')
        ]);
        $idEvaluation = Evaluation::where('nom', $evaluation['nom'])->value('id');
        foreach ($evaluation['classes'] as $classe) {
            $evaluClasse = Evaluclasse::create([
                'evaluation' => $idEvaluation,
                'classe' => Classe::where('nom',$classe)->value('id')
            ]);
            
        }
        foreach ($evaluation['questions'] as $question) {
            $question = Question::create([
                'libelle' => $question['libelle'],
                'nombrepoint' => $question['points'],
                'evaluation' => $idEvaluation
            ]);
            
            $idquestion = Question::where('libelle',$question['libelle'])->value('id');
            foreach ($question['propositions'] as $proposition) {
                $proposition = Proposition::create([
                    'libelle' => $proposition['libelle'],
                    'question' => $idquestion
                ]);
            }
        }
    }

}