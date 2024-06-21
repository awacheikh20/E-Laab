<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class Elaab extends Controller
{
   public function login(){
    //   dd(Auth::user());
    //   $user = User::create([
    //     'numero' => '123457', // Remplacez par le numéro souhaité
    //     'nom' => 'BASSENE', // Remplacez par le nom souhaité
    //     'prenom' => 'Massina Sylvanus', // Remplacez par le prénom souhaité
    //     'status' => 'etudiant', // Remplacez par le statut souhaité
    //     'email' => 'massinasylvanusbassene@elaab.sn', // Remplacez par l'e-mail souhaité
    //     'password' => 'password', // Remplacez par le mot de passe souhaité
    // ]);
      return view ('elaab.login',[
          'title' => 'E-Laab | Connexion'
          ]);
   }
   public function seconnect(LoginRequest $request){
       $credentials = $request->validated();     

       if (Auth::attempt($credentials)) {
           $request->session()->regenerate();     

           $user = Auth::user();     
           if ($user->status == 'etudiant') {
               return redirect()->route('EtudiantDashboard');
           } elseif ($user->status == 'enseignant') {
               return redirect()->route('EnseignantDashboard');
           }
      }     

       return redirect()->route('login')->withErrors([
           'numero' => 'Numéro invalide',
       ])->with('error', 'Les informations d\'identification ne correspondent pas.');
   }

  
   public function logout(){
      Auth::logout();
      return to_route('accueil');
   }

   public function accueil(){
    return view('elaab.accueil');
   }

}
