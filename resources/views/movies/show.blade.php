<x-page-heading />

<div class="grid grid-flow-col grid-rows-3 gap-4 m-16 ">
    <div class="row-span-3">
        <img class="col-span-2 "
            src=" https://image.tmdb.org/t/p/w200/{{$movies['poster_path']}}" alt="{{$movies['title']}}">
    </div>
    <div class="col-span-2 bg-gradient-to-l from-lime-600">
        <strong class="ml-10 text-4xl">{{$movies->title}} {{substr($movies->release_date , 0 , 4) }}
            <br>

            <p class="flex  ml-10 text-2xl">
                <svg weight="40" height="40" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="-5.0 -10.0 110.0 135.0">
                    <path fill="yellow" d="m28.609 60.73-4.2188 24.621c-0.14844 0.91016 0.21875 1.8203 0.96094 2.3594 0.73828 0.53125 1.7305 0.60937 2.5312 0.17969l22.117-11.641 22.109 11.629c0.35938 0.17969 0.73828 0.26953 1.1211 0.26953 0.5 0 1-0.14844 1.4219-0.44922 0.73828-0.53906 1.1211-1.4609 0.96094-2.3594l-4.2188-24.621 17.891-17.449c0.66016-0.64062 0.89062-1.5898 0.60938-2.4688-0.28906-0.87109-1.0391-1.5-1.9492-1.6406l-24.719-3.6016-11.059-22.398c-0.39844-0.82031-1.2383-1.3398-2.1602-1.3398-0.92187 0-1.75 0.51953-2.1602 1.3398l-11.059 22.398-24.719 3.6016c-0.91016 0.12891-1.6602 0.76953-1.9492 1.6406-0.28125 0.87891-0.050782 1.8281 0.60938 2.4688z" />
                </svg>

                imdb: {{$movies['vote_average']}} ({{$movies->vote_count}})



            </p>

        </strong>
        <p class="ml-10 text-2xl">{{$movies['overview']}}</p>
        <p class="ml-10 text-2xl text-gray-700">
            @if ( $movies['adult'])
            PG-13
            @elseif(!$movies['adult'])
            R rated
            @endif


        </p>
    </div>
    <div class="col-span-2 row-span-2 ">
        <p class="ml-10 text-2xl text-gray-700">
            @foreach ($genres->IdToNameGenre($movies->genres) as $genreName)
            {{ htmlspecialchars($genreName) }},
            @endforeach
        </p>
    </div>
</div>




comments