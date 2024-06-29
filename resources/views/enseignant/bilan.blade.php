@extends('enseignant.layout')
@section('content')
    <div class="w-[95%] m-auto max-h-screen overflow-visible mt-20">
        <div class="flex justify-center items-center pb-5 ">
            <p class="text-blue-900 font-bold text-2xl italic">Bilan de l'évaluation : {{$evaluation['nom']}}</p>
        </div>
        <div class="justify-center items-center shadow-lg p-5">
            <form action="" method="post">
                @csrf
                <div class="w-full bg-white">
                     <span class="text-blue-900 text-lg flex justify-center items-center">
                        <label class="text-lg font-bold" for="nom">Nom l'évaluation : </label>
                        <input readonly name="nom" type="text" value=" {{$evaluation['nom']}}" placeholder="Entrez le libellé de l'évaluation"><br> 
                     </span>
                </div>
                <div class="w-full bg-white flex justify-center items-center p-5">
                    <div class="text-blue-900 text-lg flex justify-center items-center m-auto">
                       <label class="text-lg font-bold" for="date">Date :</label>
                       <input readonly name="date" value="{{$evaluation['date']}}" type="date"><br>
                    </div>
                    <div class="text-blue-900 text-lg flex justify-center items-center m-auto">
                        <label class="text-lg font-bold" for="debut">Début :</label>
                        <input readonly name="debut" value="{{$evaluation['debut']}}" type="time"><br> 
                     </div>
                     <div class="text-blue-900 text-lg flex justify-center items-center m-auto">
                        <label class="text-lg font-bold" for="duree">Durée : </label>
                        <input readonly name="duree" class="w-" value="{{$evaluation['duree']}}" type="number" placeholder="Entrez la durée en minutes"><br> 
                     </div>
               </div>
               <div class="flex justify-center items-center p-2">
                    <h3 class="font-bold">Veuillez cocher la ou les bonnes réponses</h3>
                </div>
                <div id="questions">
                    @foreach ($evaluation['questions'] as $index => $question)
                        <div class="question shadow-md shadow-blue-900/400 hover:shadow-blue-900 rounded-b-2xl w-full mb-5">
                            <div class="w-full ml-5  text-blue-900 text-lg p-5 space-x-2 flex justify-center items-center">
                                <div class="w-5/6">
                                <label class="font-bold" for="">Question {{$index+1}} : </label><input readonly class="w-[80%]" name="questions[0]" type="text" value="{{$question['libelle']}}" placeholder="Entrez le libellé de la question"> <br>
                                </div>
                                <div class="w-1/6">
                                    <label class="font-bold" for="">Points : </label><input readonly class="w-24 "  type="number" name="" id="" value="{{$question['points']}}" placeholder="Points">
                                </div>
                            </div>
                            @foreach ($question['propositions'] as $slug => $proposition)
                                <div class="propositions p-1">
                                   <input class="ml-16" type="checkbox" name="corrections[{{$index}}][]" id="" value="{{$proposition}}">
                                   <span class="ml-4">{{$slug+1}}.</span><input readonly class="ml-2 w-[80%]" type="text" value="{{$proposition}}" name="propositions[0][]" placeholder="Entrez une proposition"><br><br>
                                </div>
                            @endforeach
                            
                            
                        </div>
                    @endforeach
                    
                </div>
               
                <div class="flex justify-center items-center p-5">
                    <div class="flex justify-center items-center p-5">
                        <input class="h-12 bg-blue-900 rounded-lg p-3 font-bold text-white cursor-pointer" type="submit" value="Suivant">
                    </div>
                    {{-- <a href="{{route('EnseignantValidationpartie')}}" class="h-12 bg-blue-900 rounded-lg p-3 font-bold text-white cursor-pointer">Créer l'évaluation</a> --}}
                </div>
            </form>
        </div>
        {{-- <form method="POST" action="{{ route('logout') }}">
            @csrf
            @method('DELETE')
            <button type="submit">Se déconnecter</button>
        </form> --}}
      </div>
@endsection
