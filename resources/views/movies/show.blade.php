<x-page-heading />
<div class=" bg-gradient-to-l from-lime-600 py-20 flex flex-row">
    <div class="">
        <strong class="ml-10 text-4xl">{{$movies->title}} {{substr($movies->release_date , 0 , 4) }}
            - imdb: {{$movies['vote_average']}} </strong>
        <p class="ml-10 text-2xl">{{$movies['overview']}}</p>
    </div>
    <div class="basis-1/4">
        <img class="" src=" https://image.tmdb.org/t/p/w200/{{$movies['poster_path']}}" alt="{{$movies['title']}}">
    </div>
</div>

comments