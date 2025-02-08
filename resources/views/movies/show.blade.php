<x-page-heading />
@vite(['resources/css/app.css', 'resources/js/app.js'])
<div class="grid grid-flow-col grid-rows-3 gap-4 m-16 ">
    <div class="row-span-3"><!--1-->
        <img class="col-span-2 "
            src=" https://image.tmdb.org/t/p/w200/{{$movies->poster_path}}" alt="{{$movies->title}}">
    </div>
    <div class="col-span-2 bg-[#507687]"><!--2-->
        <div class="ml-10 text-[#FCFAEE]">
            <strong class=" text-4xl flex">
                {{$movies->title}}
                ({{substr($movies->release_date , 0 , 4) }})
                @auth
                <button class=" ml-6" id="addFavourite">
                    <div class="text-[#B8001F] text-5xl" id="emptyHeart">♡ </div>
                    <div class="text-[#B8001F] text-5xl" id="filledHeart" hidden>♥ </div>
                </button>
                @endauth
            </strong>
            <p class=" text-2xl">
                {{str_replace("-", "/", $movies->release_date)}} -
                @foreach ($genres->IdToNameGenre($movies->genres) as $genreName)
                <span class=" p-1"> {{ htmlspecialchars($genreName) }}</span>
                @endforeach
                - {{floor($movies->runtime /60)}}h {{$movies->runtime % 60}}m


            </p>


        </div>
        <br>
        <p class="flex  ml-10 text-2xl">
            <x-star-logo />
            imdb: {{$movies['vote_average']}} ({{$movies->vote_count}})
        </p>
        <span class="ml-10 text-3xl font-semibold">Overview:</span>

        <p class="ml-10 text-2xl">{{$movies->overview}}</p>
        <p class="ml-10 text-2xl ">
            @if ( $movies->adult)
            PG-13
            @elseif(!$movies->adult)
            R rated
            @endif

        </p>
    </div>
    <div class=" ml-10 col-span-2 row-span-2 "><!--3-->
        <p class=" text-2xl text-gray-700">

        </p>
    </div>
</div>




comments