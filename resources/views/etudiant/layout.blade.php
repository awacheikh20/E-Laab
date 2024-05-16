<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    
    <title>E-Laab | Etudiant</title>
</head>
<body >
    @include('elaab.composants.header')
   <div class="flex justify-center items-center w-full relative">
        <div class="bg-blue-900 w-[11%] h-screen fixed left-0 top-0">
            <div class="pt-24 ">
            <a class="" href="">
                <div  class="h-18 flex justify-center items-center">
                    <svg width="71" height="60" viewBox="0 0 71 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g filter="url(#filter0_d_49_3)">
                        <ellipse cx="35.5" cy="26" rx="31.5" ry="26" fill="white"/>
                        </g>
                        <path d="M16 40C16 31.7157 22.7157 25 31 25H43C51.2843 25 58 31.7157 58 40H16Z" fill="#11235A"/>
                        <ellipse cx="37.5" cy="23.5" rx="14.5" ry="10.5" fill="#11235A"/>
                        <ellipse cx="37.5" cy="26" rx="12.5" ry="10" fill="white"/>
                        <defs>
                        <filter id="filter0_d_49_3" x="0" y="0" width="71" height="60" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                        <feOffset dy="4"/>
                        <feGaussianBlur stdDeviation="2"/>
                        <feComposite in2="hardAlpha" operator="out"/>
                        <feColorMatrix type="matrix" values="0 0 0 0 0.0666667 0 0 0 0 0.137255 0 0 0 0 0.352941 0 0 0 1 0"/>
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_49_3"/>
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_49_3" result="shape"/>
                        </filter>
                        </defs>
                        </svg>
                        
                </div>
            </a>
            <a class="" href="">
                <div  class=" h-14 flex justify-center items-center text-center text-white hover:bg-white hover:text-blue-900 hover:rounded-l-full font-bold text-lg">
                    Dashboard
                </div>
            </a>
            <a class="" href="">
                <div  class=" h-14 flex justify-center items-center text-center text-white hover:bg-white hover:text-blue-900 hover:rounded-l-full font-bold text-lg">
                    Evaluations
                </div>
            </a>
            <a class="" href="">
                <div  class=" h-14 flex justify-center items-center text-center text-white hover:bg-white hover:text-blue-900 hover:rounded-l-full font-bold text-lg">
                    Planning
                </div>
            </a>
            </div>
        </div>
        <div class="pt-24">
            @yield('content')
        </div>
   </div>
</body>
</html>