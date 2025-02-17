<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    @vite(['resources/css/app.css'])
</head>

<body style="background-image: url('image/taps.jpg');  background-size: cover; ">
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
    <div class="lg:mx-28 sm:mx-2 flex">
        <div class="grid grid-cols-1 gap-2 mt-5 ">
            @forelse ($movies as $movie)
            <div class="rounded-md border-2 border-solid shadow-lg max-w-[1000px] bg-white bg-opacity-30">
                <a href="{{ route('movies.show', ['movie' => $movie->id])}}">
                    <div class="grid grid-flow-col ">
                        <div>
                            <img src="https://image.tmdb.org/t/p/w200/{{ $movie->poster_path }}" alt="{{ trim($movie->title) }}">
                        </div>
                        <div class="ml-5 mt-5">
                            <p class="text-2xl ">{{ trim($movie->title) }} {{ substr($movie->release_date, 0, 4) }}
                            </p>
                            <x-rating class="ml-1 flex text-xl">imdb: {{round($movie['vote_average'] , 1)}}</x-rating>

                            <br>
                            <p class="text-xl"> {{ substr(trim($movie->overview), 0, 500)  }}{{ $movie->overview> 500 ? '...' : '' }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <p>No movies found.</p>
            @endforelse
        </div>
        <div>
            <div class=" ml-10 mt-3 ">
                <h2>Most Favorited Movies</h2>
                <table class="border-collapse border border-gray-400 bg-white bg-opacity-30 animate-pulse shadow-lg shadow-gray-500/50 ring-2 ring-gray-500/50">
                    <thead>
                        <tr>
                            <th class="border border-[#2A004E] p-1">Movie Name</th>
                            <th class="border border-[#2A004E] p-1">Total Likes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topMovies as $index => $movie)
                        <tr>
                            <td class="border border-[#2A004E] p-1">{{ $movie->title }}</td>
                            <td class="border border-[#2A004E] p-1" style="text-align: center;">{{ $movie->total_likes ?? 0 }}</td> <!-- Ensure total_likes is available -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination Links -->
    <div class="ml-40 mt-4">
        {{ $movies->links() }}
    </div>
</body>

</html>