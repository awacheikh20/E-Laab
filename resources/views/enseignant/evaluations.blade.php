@extends('enseignant.layout')
@section('content')
    <div class="w-[95%] m-auto max-h-screen overflow-visible mt-20">
       <div class="w-full bg-white">
            <span class=" text-blue-800 flex justify-center items-center text-2xl font-bold">
                Mes évaluations
            </span>
            <div class="flex justify-end items-center w-full p-5">               
                    <a href="{{route('EnseignantCreeEvaluation')}}" class="font-bold text-md p-2 rounded-full bg-blue-800 text-white">Ajouter une partie</a>
            </div>
            <table class="mt-5 shadow-md shadow-blue-900/400 rounded-bl-2xl rounded-th-2xl space-y-10 w-full pb-5 p-5">
                <thead class="bg-blue-800 h-10 text-white shadow-md shadow-blue-900/400">
                    <th>Nom</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Durée</th>
                </thead>
                <tbody class="text-center ">
                    @foreach ($evaluations as $evaluation)
                        <tr class=" h-12 rounded-lg">
                            <td class="font-bold"><a href="{{route('EnseignantEvaluation',[$evaluation->id])}}">{{$evaluation->nom}}</a></td>
                            <td class="">{{$evaluation->dateDebut}}</td>
                            <td class="">{{$evaluation->dateDebut}}</td>
                            <td class="">{{$evaluation->duree}} mn(s)</td>                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
       </div>
       
    </div>
@endsection