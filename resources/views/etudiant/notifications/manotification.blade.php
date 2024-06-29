@extends('layouts.client')
@section('content')
@vite('resources/css/app.css')

<div class="w-full h-full text-lg">
    <div class=" rounded-lg   m-auto w-[98%] flex justify-center content-center items-center shadow-lg shadow-black-500/50 hover:shadow-amber-500/50">
        <div class="h-[30em] relative rounded-lg  flex w-[98%] mb-5 mt-5  text-center content-center justify-center items-center shadow-lg shadow-black-500/50 hover:shadow-blue-500/50">

                <div id="notification" class=" w-full backdrop-blur    bg-white rounded-lg justify-center items-center content-center   z-10">
                    <div class=" w-full">
                        <div   class="w-full h-full bg-blue-800 flex  justify-center items-center content-center ">
                            <div class="w-full h-full bg-white ">
                                <div  id="notificationsSection" class="w-[99%] h-full flexbox m-auto justify-center items-center content-center">
                                        <div class="w-full h-full flex justify-center items-center">
                                            <div class="w-1/2 h-78 bg-blue-800 text-white rounded-lg    shadow-lg hover:shadow-yellow-500/50 shadow-black-500/50 flexbox ">
                                                
                                                <div id="manotif"></div>
                                                <div class="flex justity-center items-center cursor-pointer" id="action"></div>
                                                <div class="m-auto mt-5 mb-2 text-lg text-yellow-500 font-semibold flex justify-center">Merci pour votre confiance! </div>
                                            </div>
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
    const manotif = document.getElementById("manotif");
    const action = document.getElementById("action");
    $notification= JSON.parse(@json($notificationjson))
    $id=$notification.id;
    console.log("/Axina/manotif/"+$id);
    
fetch("/Axina/manotif/"+$id)
.then((response) => response.json())
.then((data) => {
// Vérifiez si le tableau data est vide
if (data.length === 0) {
    // Si le tableau est vide, affichez un message indiquant qu'il n'y a pas de notifs
    manotif.class
    manotif.innerHTML = `
        <div class="w-full text-black flex justify-center items-center">
            <p>Vous n'avez aucune notif</p>
        </div>
    `;
} else {
    
console.log(data);

        // Si le tableau n'est pas vide, générez le contenu HTML pour les notifs
    const notifsHTML =  `
            <div class="m-auto mt-5 text-xl font-semibold">${data.data.titre}</div>
            <div class=" mt-5">${data.data.description}</div>
        `;
    

    // Mettez à jour le contenu de la section de notifs
    manotif.innerHTML = notifsHTML;
    action.innerHTML = data.data.redirecte;
   
}
    })
    .catch((error) => {
        console.error("Erreur lors de la récupération des notifs : ", error);
    });
</script>
@endsection