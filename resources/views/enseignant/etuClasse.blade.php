@extends('enseignant.layout')
@section('content')
    <div class="w-[95%] m-auto max-h-screen overflow-visible mt-20">
       <div class="w-full bg-white">
            <span class="font-bold text-blue-900 text-lg flex justify-center items-center">
                Notes des étudiants
            </span>
           
            <table class="mt-5 shadow-md shadow-blue-900/400 rounded-bl-2xl rounded-th-2xl space-y-10 w-full pb-5 p-5">
                <thead class="bg-blue-900 h-10 text-white shadow-md shadow-blue-900/400">
                    <th>Nom</th>
                    <th>Note</th>
                    <th>Appréciation</th>
                </thead>
                <tbody class="text-center ">
                    @foreach ($etudiants as $etudiant)
                        <tr class=" h-12 rounded-lg shadow-lg">
                            <td class="font-bold "><a href="{{route('evaluEtudiant',[$idEva, $etudiant->etudiant])}}">{{$etudiant->nom}}</a></td>
                            <td class="">{{$etudiant->score}}</td>
                            <td class="">{{$etudiant->appreciation}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
       </div>
       
    </div>
@endsection