<x-page-heading />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@auth
<script>
    const addFavoriteUrl = "{{ route('add.favorite') }}";
    const removeFavoriteUrl = "{{route('remove.favorite')}}";
    const movie_id = "{{$movies->id}}";
    const user_id = "{{ auth()->user()->id }}";
</script>
@endauth
@vite(['resources/css/app.css', 'resources/js/app.js'])
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    <div class=" grid grid-flow-col gap-2">
        <div class="row-span-3 mt-16 "><!--1-->
            <img class="col-span-2 ml-2"
                src=" https://image.tmdb.org/t/p/w200/{{$movies->poster_path}}" width="220" height="220" alt="{{$movies->title}}">
        </div>
        <div class="col-span-2 bg-white bg-opacity-50 mt-16 lg:mr-3"><!--2-->
            <div class="pl-4 pt-2 ">
                <strong class=" text-4xl flex">
                    {{$movies->title}}
                    ({{substr($movies->release_date , 0 , 4) }})
                    @auth
                    @php
                    $existsMovieInFavorite = App\Models\favourite::existInFavorite($movies->id , auth()->user()->id);
                    $emptyHeart = "♡";
                    $fillHeart = "♥";

                    @endphp
                    <button id="addRemoveFavorite" class="text-[#B8001F] text-4xl ml-6">
                        @if (!$existsMovieInFavorite)
                        {{$emptyHeart}}
                        @else
                        {{ $fillHeart }}
                        @endif
                    </button>
                    @else
                    <div class="text-[#B8001F] text-5xl" id="emptyHeart">♡</div>
                    @endauth

                </strong>

                <p class=" text-2xl">
                    {{str_replace("-", "/", $movies->release_date)}} -
                    @foreach ($genres->IdToNameGenre($movies->genres) as $genreName)
                    <span class=" p-1"> {{ htmlspecialchars($genreName) }}</span>
                    @endforeach
                    - {{floor($movies->runtime /60)}}h {{ $movies->runtime % 60}}m
                </p>
            </div>
            <br>
            <x-rating>imdb: {{round($movies['vote_average'] , 1)}}</x-rating>
            <p class="ml-10 text-2xl ">
                @if ( $movies->adult)
                PG-13
                @elseif(!$movies->adult)
                R rated
                @endif
            </p>
            <span class="ml-10 text-3xl font-semibold">Overview:</span>
            <p class="ml-10 text-2xl">{{$movies->overview}}</p>

        </div>
        <span class="text-3xl">cast</span>
        <div class=" col-span-2 flex  overflow-x-auto gap-2 "><!--3-->
            @forelse ($movies->actors as $actor)
            <p class="text-base border-2 p-1  min-w-[150px]  bg-white bg-opacity-50">
                {{ $actor->name }}
                /
                @if ($actor->pivot->character)
                <span class=" pl-3">as
                    {{ $actor->pivot->character }}
                </span>
                @endif
                @empty
                <li class="text-xl ">No actors found for this movie.</li>
                @endforelse

        </div>
    </div>
    <div>
        <div class="grid grid-cols-2 gap-1">
            <div><!--col 1-->
                @php
                $movieComments = $comments->getComments($movies);
                @endphp
                <div class="comments lg:text-2xl sm:text-xl">
                    @foreach ($comments->getComments($movies) as $comment)
                    @if ($loop->iteration <= 2)
                        <div class="border-2 rounded-lg lg:mx-16 sm:mx-6 mt-1 shadow-md ">
                        <p class=" p-5">
                            A review by {{$user->getUserName( $comment->user_id)}}:
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
                @if ($movieComments->isNotEmpty())
                <div class="mt-4"> <a href="{{ route('movies.comments', ['movie' => $movies->id]) }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white lg:font-bold lg:text-lg text-xl py-2 px-4 rounded lg:m-16 sm:ml-8 md:ml-2">Show More Comments</a>
                </div>

                @endif
            </div>
        </div>
        <div><!--col 2-->
            <form method="post" action="{{ route('movies.show' , ['movie' => $movies->id ]) }}">
                @auth
                @csrf
                <div class="col-span-4">
                    <input type="text" name="user_id" value="{{auth()->user()->id }}" hidden>
                    <input type="text" name="movie_id" value="{{$movies->id}}" hidden>
                    <label for="name" class="block text-2xl my-5snv">share your opinion:</label>
                    <input type="text" id="name" class="pl-5 mt-1 h-[3rem] block rounded" value="{{auth()->user()->name }}" disabled>
                    <textarea name="comment" class="w-[500px] h-[7rem] block rounded mt-3" id="comment">
                    </textarea>
                    <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
                </div>
                @else
                <div class="col-span-4 blur-[2px]">
                    <label for="name" class="block text-2xl my-5snv">share your opinion:</label>
                    <input type="text" id="name" class="pr-10 block rounded" disabled>
                    <textarea name="comment" class="pr-40 block rounded mt-3" id="comment" disabled>
                        </textarea>
                    <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded" disabled>Submit</button>
                </div>
            </form>
            <a href="{{ url('/dashboard') }}" class="bg-blue-500 hover:bg-blue-700 text-white lg:font-bold sm:text-sm py-2 px-4 rounded">sign up and leave a comment</a>
            @endauth
        </div>
    </div>
</div>
</div>