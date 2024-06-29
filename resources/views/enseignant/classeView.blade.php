@extends('enseignant.layout')
@section('content')
    <div class="w-[95%] m-auto max-h-screen overflow-visible mt-20">
       <div class="space-y-5  w-full bg-white">
           
           
            <div class="shadow-md shadow-blue-900/400 rounded-bl-2xl rounded-tr-2xl space-y-10 space-x-10 w-full pb-3 pr-5">
                <span class="w-full ml-5 font-bold text-blue-900 text-lg">
                    Évaluations de la classe {{$classe->nom}}
                </span>
                
                <div class=" justify-center items-center mt-5 grid grid-cols-3 grid-row-2 gap-y-5 gap-x-5">
                    @foreach ($evaluations as $key=>$evaluation)
                        <a href="{{route('classesEtu',[$evaluation->id, $classe->id])}}" class="shadow shadow-gray-600 rounded-t-full rounded-b-xl text-md hover:shadow-blue-900 py-12">
                            <div class="  items-center text-center text-blue-900 m-auto">
                                <span class="font-bold text-2xl">{{$evaluation->nom}}</span>
                            </div>
                            <div class="grid grid-cols-4 gap-y-4 mt-3 px-8 text-sm ">
                                <div class="grid grid-cols-2 col-span-3 ">
                                    <div class="text-start w-full m-auto col-span-2">Durée :</div>
                                </div>
                                <div class="grid grid-cols-2 ">
                                    <div class="font-bold text-start w-full m-auto col-span-2">{{$evaluations[$key]->duree}} mn(s)</div>
                                </div>
                                <div class="grid grid-cols-2  ">
                                    <div class="text-start w-full m-auto col-span-2">Matière :</div>
                                </div>
                                <div class="grid grid-cols-2 col-span-3">
                                    <div class="font-bold text-start w-full m-auto col-span-2">{{$matieres[$key]->nom}}</div>
                                </div>
                                <div class="grid grid-cols-2  ">
                                    <div class="text-start w-full m-auto col-span-2">Date :</div>
                                </div>
                                <div class="grid grid-cols-2 col-span-3">
                                    <div class="font-bold text-center w-full m-auto col-span-2">{{$date[$key]}}</div>
                                </div>
                            </div>
                        </a>
                    @endforeach   
                </div>
                
            </div>
       </div>
       
    </div>
@endsection