@extends('enseignant.layout')
@section('content')
    <div class="w-[95%] m-auto max-h-screen overflow-visible mt-20">
       <div class="space-y-5  w-full bg-white">
            <div class="shadow-md shadow-blue-900/400 rounded-bl-2xl rounded-tr-2xl space-y-10 space-x-10 w-full pb-3 pr-5">
                <span class="w-full ml-5 font-bold text-blue-900 text-lg">
                    Liste des classes
                </span>
                
                <div class=" justify-center items-center mt-3 grid grid-cols-3 grid-row-2 gap-x-5 ">
                    @foreach ($classeList as $key=>$classe)
                        <a  class="group  text-blue-900 shadow shadow-gray-600 hover:rounded-t-full rounded-full h-14  px-5 w- flex justify-center items-center hover:block hover:h-auto hover:shadow-blue-900 hover:border-blue-900" href="{{route('classesEvalu',[$classe->id])}}">
                            <div class="flex justify-center items-center text-center  m-auto">
                                <span class="font-bold text-2xl">{{$classe['nom']}}</span>
                            </div>
                            <div class="hidden group-hover:grid grid-cols-4 text-sm p-3 text-gray-600 font-semibold space-y-2">
                                <div class="grid grid-cols-2 col-span-3 ">
                                    <div class="text-start w-full m-auto col-span-2">Niveau :</div>
                                </div>
                                <div class="grid grid-cols-2 ">
                                    <div class="text-start w-full m-auto col-span-2">Année {{$classe->niveau}} </div>
                                </div>
                                <div class="grid grid-cols-2 col-span-3 ">
                                    <div class="text-start w-full m-auto col-span-2">Nombre d'étudiant :</div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="text-start">{{$etudiant[$key]}}</div>
                                </div>
                                
                            </div>
                        </a>
                    @endforeach   
                </div>
                
            </div>
       </div>
       
    </div>
@endsection