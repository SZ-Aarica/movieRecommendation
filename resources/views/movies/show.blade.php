<x-page-heading />

@vite(['resources/css/app.css', 'resources/js/app.js'])
<!-- Include CSRF Token in Meta Tag -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container" style="background-color: #FCFAEE;">
    <div class="grid grid-flow-col  gap-4 " id="favorites-container"
        @auth
        data-user-id="{{ auth()->user()->id }}"
        data-movie-id="{{ $movies->id }}"
        @endauth>

        <div class="row-span-3 mt-16"><!--1-->
            <img class="col-span-2 "
                src=" https://image.tmdb.org/t/p/w200/{{$movies->poster_path}}" alt="{{$movies->title}}">
        </div>
        <div class="col-span-2 bg-[#507687] mt-16"><!--2-->
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
        <div class=" ml-10 col-span-2 "><!--3-->
            <p class=" text-2xl text-gray-700">
                the actors and directors
            </p>
        </div>
    </div>

    <div>
        <div class="grid grid-cols-2 gap-1">
            <div><!--col 1-->
                <div class="comments text-2xl">
                    @foreach ($comments->getComments($movies) as $comment)
                    @if ($loop->iteration <= 2)
                        <div class="border-2 rounded-lg mx-16 mt-1 shadow-md ">
                        <p class=" p-5">
                            A review by {{$user->getUserName( $comment->user_id)}}
                            <span class="text-base">
                                written on {{str_replace("-", "/",  strstr($comment->created_at , ' ' , true))}}
                                {{strtotime(5)}}
                            </span>
                            <br>
                            {{$comment->comment}}
                        </p>
                </div>
                @endif
                @endforeach
                <a href="{{ route('movies.comments', ['movie' => $movies->id]) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">show more comments</a>
            </div>

        </div>
        <div><!--col 2-->

            @auth
            <form method="post" action="{{ route('movies.show' , ['movie' => $movies->id ]) }}">
                @csrf
                <div class="col-span-4">
                    <input type="text" name="user_id" value="{{auth()->user()->id }}" hidden>
                    <input type="text" name="movie_id" value="{{$movies->id}}" hidden>
                    <label for="name" class="block text-2xl my-5snv">share your opinion:</label>
                    <input type="text" class="pl-5 mt-1 h-[3rem] block rounded" value="{{auth()->user()->name }}" disabled>
                    <textarea name="comment" class="w-[500px] h-[7rem] block rounded mt-3" id="comment">
                    </textarea>
                    <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
                </div>
            </form>
            @else
            <form class="blur-[2px]">
                @csrf
                <div class="col-span-4">
                    <label for="name" class="block text-2xl my-5snv">share your opinion:</label>
                    <input type="text" class="pr-10 block rounded" disabled>
                    <textarea name="comment" class="pr-40 block rounded mt-3" id="comment" disabled>
                        </textarea>
                    <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded" disabled>Submit</button>
                </div>
            </form>
            <a href="{{ url('/dashboard') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">sign up and leave a comment</a>
            @endauth
        </div>
    </div>
</div>
</div>
<script>
    window.movieId = <?php echo json_encode($movies->id); ?>;
</script>