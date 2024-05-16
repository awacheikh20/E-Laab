<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Etudiant extends Controller
{
   public function layout(){
    return view('etudiant.layout');
   }
   public function dashboard(){
    return view('etudiant.dashboard');
   }
}
