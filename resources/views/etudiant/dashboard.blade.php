@extends('etudiant.layout')
@section('content')
    <div class="w-[95%] m-auto max-h-screen overflow-visible mt-10">
       <div class="space-y-5  w-full bg-white mt-10">
            <span class="font-bold text-blue-900 text-lg flex justify-center items-center">
                Bonjour {{Auth()->user()->prenom.' '.Auth()->user()->nom}}!
            </span>
            <div class="shadow-md shadow-blue-900/400 rounded-bl-2xl rounded-tr-2xl w-full pb-5 pr-5">
                <span class="w-full ml-5 font-bold text-blue-800 text-lg">
                    Évaluations
                </span>
                <div class="flex justify-center items-center mt-3 ">
                    <div class="shadow shadow-gray-600 rounded-bl-full rounded-tr-full  w-1/4  grid grid-cols-1 gap-y-0 items-center text-center text-blue-800 m-auto">
                        <span class="font-bold text-2xl">{{$enattente}}</span>
                        <span class="text-lg">en attente</span>
                    </div>
                    <div class="shadow shadow-gray-600 rounded-bl-full rounded-tr-full  w-1/4  grid grid-cols-1 gap-y-0 items-center text-center text-blue-800 m-auto">
                        <span class="font-bold text-2xl">{{$totalEvaluation}}</span>
                        <span class="text-lg">créée(s)</span>
                    </div>
                    <div class="shadow shadow-gray-600 rounded-bl-full rounded-tr-full  w-1/4  grid grid-cols-1 gap-y-0 items-center text-center text-blue-800 m-auto">
                        <span class="font-bold text-2xl">{{$totalEvaluationAchevee}}</span>
                        <span class="text-lg">achevée(s)</span>
                    </div>
                </div>
                
            </div>
            <div class=" m-auto max-h-screen overflow-visible mt-20">
                <div class="space-y-5  w-full bg-white">
                     <div class="shadow-md shadow-blue-900/400 rounded-bl-2xl rounded-tr-2xl space-y-10 space-x-10 w-full pb-3 pr-5">
                         <span class="w-full ml-5 font-bold text-blue-900 text-lg">
                             Planning
                         </span>
                         
                         <div class=" justify-center items-center mt-3 grid grid-cols-3 grid-row-2 gap-y-10">
                             @foreach ($planElems as $key=>$plan)
                                 <div class="shadow shadow-gray-600 rounded-bl-full rounded-tr-full  px-20 w-  grid grid-cols-1 gap-y-0 items-center text-center text-blue-900">
                                     <span class="font-bold text-2xl">{{$planningJour[$key]}}</span>
                                     <span class="text-lg">{{$planningMoisAnnee[$key]}}</span>
                                     <span class="text-lg font-bold">{{$plan['nom']}}</span>
                                 </div>
                             @endforeach   
                         </div>
                         <div class="w-">{{ $plans->links('pagination::tailwind') }}</div>
                         
                     </div>
                </div>
                
             </div>
       </div>
    </div>
@endsection