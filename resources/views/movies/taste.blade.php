 <x-page-heading />
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
 <script>
     const tasteUrl = "{{route('taste')}}";
 </script>

 @vite(['resources/css/app.css', 'resources/js/copy.js'])
 <meta name="csrf-token" content="{{ csrf_token() }}">



 <div style="background-image: url('image/movie.jpg');" class="h-screen bg-cover bg-center">
     <h1 class="text-5xl text-[#0f3119] font-bold  mx-10">Recommendation Search Bar: Discovering Movies Like Never Before</h1>
     <p class="text-2xl font-medium text-[#0f3119] mx-10">The recommendation search bar is a powerful tool
         designed to enhance your movie exploration experience.
         As you type in your search query, this bar dynamically
         suggests movies based on your input. It utilizes advanced
         algorithms to analyze various factors, such as genre, actors,
         directors, and viewer preferences, to find movies that closely
         match your interests. This feature ensures that movie
         enthusiasts can effortlessly navigate through vast content libraries
         and find their next favorite watch</p>
     <div class="w-full max-w-xs ml-16 ">
         <x-form action="{{url('/taste')}}" method="post" placeholder="Find similar movies">
             Movie Title
         </x-form>

     </div>
     <div class="px-4" id="searchResults">
         @if ($datas > 0)
         <strong class="text-3xl text-center">Similar movies</strong>
         <div class="grid grid-cols-4 gap-4">
             @foreach ($datas as $movie)
             <div class="bg-[#0f3119] bg-opacity-80 rounded text-center text-white">
                 <button class="searchMovie" data-movie-name="{{ $movie['name']  }}">

                     <p class="text-to-copy"> {{ $movie['name'] }}</p>
                 </button>
                 <br>

                 <button class="text-xs copy-button pb-1">copy to clipboard</button>

             </div>
             @endforeach
         </div>
         @else
         <p class="ml-8">No similar movies found.</p>
         @endif

     </div>
 </div>