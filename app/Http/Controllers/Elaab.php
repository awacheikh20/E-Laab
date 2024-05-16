<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;


class Elaab extends Controller
{
   public function login(){
      //dd(Auth::user());
      return view ('elaab.login',[
          "title"=>"E-Laab | Connexion",
          
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

       return redirect()->route('elaab.composants.accueil')->withErrors([
           'email' => 'Email invalide',
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
