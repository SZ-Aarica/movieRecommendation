   <x-page-heading />
   <x-app-layout>
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
       @vite(['resources/css/app.css', 'resources/js/app.js'])
       <meta name="csrf-token" content="{{ csrf_token() }}">

       <div style="background-color: #FCFAEE;">
           <div class="py-12 " style="background-color: #FCFAEE;">
               <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                   <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                       <div class="p-6 text-gray-900">


                           Hi {{ auth()->user()->name }} {{ __("You're logged in!") }}
                           you have been with us since {{ auth()->user()->created_at }}

                       </div>

                   </div>

               </div>

           </div>

           <div class="mx-40 ">
               <div class="text-2xl">Your Favorites</div>
               <div class="grid grid-cols-1 gap-2 mt-5 ">

                   @forelse ($favoriteMovies as $movie)
                   <div class="rounded-md border-2 border-solid shadow-lg max-w-[1000px]">
                       <a href="{{ route('movies.show', ['movie' => $movie->id])}}">
                           <div class="grid grid-flow-col  ">
                               <div>
                                   <img src="https://image.tmdb.org/t/p/w200/{{ $movie->poster_path }}" alt="{{ $movie->title }}">
                               </div>
                               <div class="ml-5 mt-5">
                                   <p class="text-2xl ">{{ $movie->title }} {{ substr($movie->release_date, 0, 4) }}
                                   </p>
                                   <br>
                                   <p class="text-xl"> {{ $movie->overview }}</p>
                               </div>

                           </div>
                   </div>

                   </a>
               </div>
               @empty
               <p>No movies found.</p>
               @endforelse
           </div>
       </div>

       </div>
   </x-app-layout>