<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <x-page-heading />

    <!-- Search Form -->
    <x-form action="{{ route('movies.index') }}" method="GET" placeholder="Find your movie">
        <!-- the inpute velue name in movie that why we use 'movie' -->
    </x-form>

    <!-- Display Search Query -->
    <!--if there was something searched in the movie form  it return the serched value  (true/false)-->
    @if($searchQuery)
    <p class="ml-40 mt-4">Search Results for: "{{ $searchQuery }}"</p>
    @endif

    <!-- Movie List -->
    <div class="ml-40">
        <div class="grid grid-cols-2 gap-2">
            @forelse ($movies as $movie)
            <div class="rounded-md border-2 border-solid">
                <a href="{{ route('movies.show', ['movie' => $movie->id , 'genres' => implode(',', $genre->idToNameGenre($movie->genres))]) }}">
                    <div class="grid grid-cols-3 gap-x-1 gap-y-2">
                        <div>
                            <img src="https://image.tmdb.org/t/p/w200/{{ $movie->poster_path }}" alt="{{ $movie->title }}">
                        </div>
                        <div>
                            <strong>{{ $movie->title }} {{ substr($movie->release_date, 0, 4) }}</strong>
                            <br>
                            {{ $movie->overview }}
                            <p class="text-gray-700">
                                @foreach ($genre->IdToNameGenre($movie->genres) as $genreName)
                                {{ htmlspecialchars($genreName) }},
                                @endforeach
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <p>No movies found.</p>
            @endforelse
        </div>
    </div>

    <!-- Pagination Links -->
    <div class="ml-40 mt-4">
        {{ $movies->links() }}
    </div>
</body>

</html>