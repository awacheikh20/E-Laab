@extends('layouts.client')
@section('content')
@vite('resources/css/app.css')

<div class="w-full">
    <div class=" rounded-lg   m-auto w-[98%] flex justify-center content-center items-center shadow-lg shadow-black-500/50 hover:shadow-amber-500/50">
        <div class="relative rounded-lg  flex w-[98%] mb-5 mt-5  text-center content-center justify-center items-center shadow-lg shadow-black-500/50 hover:shadow-blue-500/50">
            <h1 class="text-2xl absolute left-1 top-0 font-semibold">Mes notifications</h1>
            <div class=" h-[31em] overflow-y-auto overflow-x-hidden rounded-lg  bg-white m-auto w-full mt-10  ">

                <div id="notif" class=" w-full backdrop-blur    bg-white rounded-lg justify-center items-center content-center   z-10">
                    <div class="flexbox  w-full">
                        <div   class="w-full  bg-blue-800 flex  justify-center items-center content-center ">
                            <div class="w-full bg-white ">
                                <div  id="notifsSection" class="w-[99%] flexbox m-auto justify-center items-center content-center">
                                   
                                </div>
                            </div>
                              
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
            const notifsSection = document.getElementById("notifsSection");

    fetch("/Axina/mynotif")
        .then((response) => response.json())
        .then((data) => {
        // Vérifiez si le tableau data est vide
        if (data.length === 0) {
            // Si le tableau est vide, affichez un message indiquant qu'il n'y a pas de notifs
            notifsSection.classa
            notifsSection.innerHTML = `
                <div class="w-full text-black flex justify-center items-center">
                    <p>Vous n'avez aucune notif</p>
                </div>
            `;
        } else {
            // Si le tableau n'est pas vide, générez le contenu HTML pour les notifs
            const notifsHTML = data.map((notif) => {
                console.log(notif);
                return `
                    <a href="${notif.data.url}/${notif.id}" class=" hover:bg-yellow-500 border-b-2 m-auto hover:border-blue-800 cursor-pointer w-full ">
                        <div class="grid grid-cols-3 justify-center h-10 items-center hover:bg-yellow-500 text-black hover:text-white border-b-2  hover:border-blue-800 rounded-lg ">
                            <div class="m-auto font-semibold">${notif.data.titre}</div>
                            <div class="m-auto">${notif.data.descrip}</div>
                            <div class="m-auto text-sm text-zinc-400 font-semibold flex justify-end">${notif.data.date}</div>
                        </div>
                    </a>
                `;
            }).join("");

            // Mettez à jour le contenu de la section de notifs
            notifsSection.innerHTML = notifsHTML;
        }
            })
            .catch((error) => {
                console.error("Erreur lors de la récupération des notifs : ", error);
            });
</script>
@endsection