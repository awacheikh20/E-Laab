<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Evaluation;
use App\Models\User;
use App\Models\Matiere;
use App\Models\Classe;
use App\Models\Question;
use App\Models\Proposition;
use App\Models\Reponse;
use App\Models\Resultat;
use App\Models\Evaluclasse;
use App\Http\Requests\creerFormEvaluation;
use Carbon\Carbon;

class Enseignant extends Controller
{
   
    public function dashboard(Request $request){

        $evaluation = Evaluation::where('enseignant',auth()->id())
        ->where('dateDebut','>',now())
        ->get();
        $nbevaluation = $evaluation->count();

        $totalEvaluation = Evaluation::where('enseignant',auth()->id())
        ->where('dateDebut','<=',now())
        ->get();
        $totalEvaluationAchevee = $totalEvaluation->count();

        $totalEvaluationCree = Evaluation::where('enseignant',auth()->id())
        ->count();


        $plans = Evaluation::orderBy('dateDebut')
        ->where('enseignant', auth()->id())
        ->where('dateDebut', '>=', now())
        ->paginate(6);

        $planElems = Evaluation::orderBy('dateDebut')
        ->where('enseignant', auth()->id())
        ->where('dateDebut', '>=', now())
        ->get();

        $planningJour=[];
        $planningMoisAnnee=[];
        foreach ($plans as $key => $plan) {
           $planningJour[$key] = Carbon::parse($plan['dateDebut'])->translatedFormat('j');
           $planningMoisAnnee[$key] = Carbon::parse($plan['dateDebut'])->translatedFormat('F Y');
        }
        
        
        // // dd($planningJour, $planningMoisAnnee);

        return view('enseignant.dashboard',[
            'planElems' => $planElems,
            'plans' => $plans,
            'enattente' => $nbevaluation,
            'totalEvaluation' => $totalEvaluationCree,
            'totalEvaluationAchevee' => $totalEvaluationAchevee,
            'planningJour' => $planningJour,
            'planningMoisAnnee' => $planningMoisAnnee,
        ]);
    }
    public function test(Request $request){

        $evaluation = Evaluation::where('enseignant',auth()->id())
        ->where('dateDebut','>',now())
        ->get();
        $nbevaluation = $evaluation->count();

        $totalEvaluation = Evaluation::where('enseignant',auth()->id())
        ->where('dateDebut','<=',now())
        ->get();
        $totalEvaluationAchevee = $totalEvaluation->count();

        $totalEvaluationCree = Evaluation::where('enseignant',auth()->id())
        ->count();


        $plans = Evaluation::orderBy('dateDebut')
        ->where('enseignant', auth()->id())
        ->where('dateDebut', '>=', now())
        ->paginate(6);

        $planElems = Evaluation::orderBy('dateDebut')
        ->where('enseignant', auth()->id())
        ->where('dateDebut', '>=', now())
        ->get();

        $planningJour=[];
        $planningMoisAnnee=[];
        foreach ($plans as $key => $plan) {
           $planningJour[$key] = Carbon::parse($plan['dateDebut'])->translatedFormat('j');
           $planningMoisAnnee[$key] = Carbon::parse($plan['dateDebut'])->translatedFormat('F Y');
        }
        
        
        // // dd($planningJour, $planningMoisAnnee);

        return view('enseignant.test',[
            'planElems' => $planElems,
            'plans' => $plans,
            'enattente' => $nbevaluation,
            'totalEvaluation' => $totalEvaluationCree,
            'totalEvaluationAchevee' => $totalEvaluationAchevee,
            'planningJour' => $planningJour,
            'planningMoisAnnee' => $planningMoisAnnee,
        ]);
    }
    public function evaluations(){
        $evaluations = Evaluation::get();
        //dd($evaluations);
        return view('enseignant.evaluations',[
            'evaluations' => $evaluations
        ]);
    }
    public function planning(){
        $plans = Evaluation::orderBy('dateDebut')
        ->where('enseignant', auth()->id())
        ->where('dateDebut', '>=', now())
        ->paginate(6);

        $planElems = Evaluation::orderBy('dateDebut')
        ->where('enseignant', auth()->id())
        ->where('dateDebut', '>=', now())
        ->get();

        $planningJour=[];
        $planningMoisAnnee=[];
        foreach ($plans as $key => $plan) {
           $planningJour[$key] = Carbon::parse($plan['dateDebut'])->translatedFormat('j');
           $planningMoisAnnee[$key] = Carbon::parse($plan['dateDebut'])->translatedFormat('F Y');
        }
        

        return view('enseignant.planning',[
            'planElems' => $planElems,
            'plans' => $plans,
            'planningJour' => $planningJour,
            'planningMoisAnnee' => $planningMoisAnnee,
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
    
    public function enseignantCreeEvaluation(){
        Session()->forget('evaluation');
        $matieres = Matiere::where('enseignant', Auth::user()->id)->get();
        $classes = Classe::get();
        return view('enseignant.CreeEvaluation',[
            'matieres' => $matieres,
            'classes' => $classes,
        ]);
    }

    public function enseignantPostCreeEvaluation(creerFormEvaluation $request)
{
    // Récupérer les données validées du formulaire
    
    $donneesValidees = $request->validated();
    // dd($donneesValidees);
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
    return redirect()->route('EnseignantBilanEvaluation')->with('success', 'Message de succès ici');
}


public function enseignantPostBilanevaluation(Request $request)
{
    // Récupérer l'évaluation depuis la session
    $evaluation = $request->session()->get('evaluation');

    // Parcourir chaque question
    foreach ($evaluation['questions'] as $key => $question) {
        // Récupérer les corrections pour cette question à partir des données soumises
        $corrections = $request->input('corrections.' . $key, []);
        
        // Mettre à jour les corrections dans le tableau d'évaluation
        $evaluation['questions'][$key]['corrections'] = $corrections;
    }

    // Afficher ou traiter les corrections pour chaque question (pour déboguer)
    foreach ($evaluation['questions'] as $key => $question) {
        echo "Corrections pour la question " . $key . ": ";
        print_r($question['corrections']);
        echo "<br>";
    }
    
    // Mettre à jour la session avec les modifications apportées
    session()->put('evaluation', $evaluation);

    // Insérer la nouvelle évaluation dans la base de données
    $datetime = $evaluation['date'] . ' ' . $evaluation['debut'] . ':00';
    $newEvaluation = Evaluation::create([
        'nom' => $evaluation['nom'],
        'duree' => $evaluation['duree'],
        'dateDebut' => $datetime,
        'HeureDebut' => $evaluation['debut'],
        'enseignant' => Auth::user()->id,
        'matiere' => Matiere::where('nom',$evaluation['matieres'][0])->value('id')
    ]);

    // Récupérer l'ID de la evaluation nouvellement créée
    $idevaluation = $newEvaluation->id;
    $idEvaluation = Evaluation::where('nom', $evaluation['nom'])->value('id');
    foreach ($evaluation['classes'] as $classe) {
        $evaluClasse = Evaluclasse::create([
            'evaluation' => $idEvaluation,
            'classe' => Classe::where('nom',$classe)->value('id')
        ]);
        
    }
    // Insérer chaque question et ses propositions dans la base de données
    foreach ($evaluation['questions'] as $question) {
        $questionCreate = Question::create([
            'libelle' => $question['libelle'],
            'nombrepoint' => $question['points'],
            'evaluation' => $idevaluation
        ]);
        
        $idQuestion = $questionCreate->id;
        
        // Insérer chaque proposition pour la question actuelle
        foreach ($question['propositions'] as $proposition) {
            $newProposition = Proposition::create([
                'libelle' => $proposition,
                'question' => $idQuestion,
                'estCorrecte' => 0,
            ]);
        }

        // Marquer les propositions correctes pour cette question
        foreach ($question['corrections'] as $correct) {
            $idPropo = Proposition::where('libelle', $correct)->where('question', $idQuestion)->latest('id')->first();
            if ($idPropo) {
                $idPropo->estCorrecte = 1;
                $idPropo->save();
            }
        }
    }

    // Rediriger avec un message de succès
    return redirect()->route('EnseignantEvaluations')->with('success', 'L\'évaluation ' . $evaluation['nom'] . ' a été créée avec succès!');
}



    public function enseignantBilanevaluation(Request $request){
        $evaluation = $request->session()->get('evaluation');
        $evaluationJson = json_encode($evaluation);
        // dd($evaluation);
        
        return view('enseignant.bilan',[
            'evaluation'=>$evaluation
        ]);
    }
    
    public function classes(){
        $evaluations = Evaluation::where('enseignant', auth()->id())->pluck('id');

        $classes=[];
        $etudiant=[];

        foreach ($evaluations as $key => $evaluation) {
            $classes[$key] = Evaluclasse::where('evaluation', $evaluation)
            ->distinct()
            ->pluck('classe')
            ->toArray();
        }
        $lesClasses =[];
        $classeTab = collect($classes)->flatten()->unique()->values()->all();
        foreach ($classeTab as $key => $classe) {
            $lesClasses[$key] = Classe::where('id', $classe)->first();
            $etudiant[$key] = User::where('status', 'etudiant')
            ->where('classe',$classe)
            ->count();
        }

        // dd($etudiant);
       
        return view('enseignant.classes', [
            'classeList' => $lesClasses,
            'etudiant' => $etudiant,
        ]);
    }
    public function classesEvalu($id){
        $classe = Classe::where('id',$id)->first();
        $evaluationIds = Evaluclasse::where('classe',$id)->pluck('evaluation');
        $evaluations = [];
        $matieres = [];
        $dates = [];
        $evaluation=[];
        foreach ($evaluationIds as $key => $evaluationId) {
            $evaluation[$key] = Evaluation::find($evaluationId);
    
            if ($evaluation) {
                $evaluations[$key] = $evaluation[$key];
                $matieres[$key] = Matiere::find($evaluation[$key]->matiere);
                $dates[$key] = Carbon::parse($evaluation[$key]->dateDebutHeure)->translatedFormat('j F Y');
            }
        }
        // dd($matieres);
    
        return view('enseignant.classeView',[
            'classe' => $classe,
            'matieres' => $matieres,
            'evaluations' => $evaluation,
            'date' => $dates,
        ]);
    }

    public function classesEtu($idEva, $idClasse)
    {
        $resultats = Resultat::where('resultats.evaluation', $idEva)
        ->select(
            'resultats.*',
            User::raw("CONCAT(users.prenom, ' ', users.nom) AS nom"),
            'evaluations.nom as evaluation'
        )
        ->join('users', 'resultats.etudiant', '=', 'users.id')
        ->join('evaluations', 'resultats.evaluation', '=', 'evaluations.id')
        ->join('classes', 'users.classe', '=', 'classes.id') 
        ->where('classes.id', $idClasse)
        ->get();

        // dd($resultats)   ; 
        return view('enseignant.etuClasse',[
            "etudiants"=>$resultats,
            "idEva" => $idEva
        ]);
    }

    public function evaluEtudiant($idEvaluation, $idEtudiant)
{
    // Récupération de l'évaluation
    $evaluation = Evaluation::findOrFail($idEvaluation);

    // Récupération des questions de l'évaluation
    $questions = Question::where('evaluation', $idEvaluation)->get();

    // Tableau pour stocker les données à passer à la vue
    $data = [
        'evaluation' => [
            'nom' => $evaluation->nom,
            'date' => $evaluation->dateDebut,
            'debut' => $evaluation->heureDebut,
            'duree' => $evaluation->duree,
            'questions' => [],
        ],
    ];
    $proposition=[];
    $propositionsIds=[];
    $reponsesEtudiant=[];
    
    // Boucle sur chaque question
    foreach ($questions as $key=> $question) {
        // Récupération des propositions de la question
        $propositions[$key] = Proposition::where('question', $question->id)->get();

        // Tableau pour stocker les IDs des propositions associées à cette question
        $propositionsIds[$key] = $propositions[$key]->pluck('id')->toArray();

        // Récupération des réponses de l'étudiant pour les propositions de cette question
        foreach ($propositionsIds as $index => $propositionsId) {
            $reponsesEtudiant[$key] = Reponse::where('etudiant', $idEtudiant)
                                    ->where('proposition', $propositionsId)
                                    ->pluck('proposition')
                                    ->toArray();
            print_r($propositionsId);
        }
        // Construction des données de la question pour la vue
        $data['evaluation']['questions'][] = [
            'libelle' => $question->libelle,
            'points' => $question->nombrePoint,
            'propositions' => $propositions[$key]->pluck('libelle')->toArray(),
            'reponses_etudiant' => $reponsesEtudiant[$key],
        ];
    }
    dd($data, $idEtudiant, $idEvaluation, $propositionsIds, $propositions, $reponsesEtudiant);
    // Retourner la vue avec les données préparées
    return view('enseignant.evaluEtudiant', compact('data'));
}


    
}