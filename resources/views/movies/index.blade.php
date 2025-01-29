<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="">
    <x-page-heading />
    <form action="{{ url('/home') }}" method="post">
        @csrf
        <div class="flex justify-left">
            <div class="ml-9  ml-40">
                <label for="movie " class="block text-2xl my-5snv">Movie</label>
                <input class="pr-40 rounded" type="text" name="movie" id="movie" placeholder="search for a movie ">
                <input type="submit" value="search" class="bg-white px-10 hover:bg-lime-200 duration-500 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">

            </div>
        </div>

    </form>

    <div class="ml-40">
        <div class="grid grid-cols-3 gap-4 ">
            @foreach ($movies as $movie)
            <div class=" rounded-md">
                <a href="{{ route('movies.show', ['movie' => $movie->id]) }}">
                    <div>{{ $movie->title }}
                        <br /> {{substr($movie->release_date , 0 , 4)}}
                    </div>
                    <img src="https://image.tmdb.org/t/p/w200/{{$movie['poster_path']}}" alt="{{$movie['title']}}">
                </a>
            </div>
            @endforeach
        </div>
    </div>
    <div class=" ml-9 ml-40">
        {{ $movies->links() }}
    </div>
</body>

</html>