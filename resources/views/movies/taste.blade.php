 <x-page-heading />
 @vite(['resources/css/app.css', 'resources/js/app.js'])
 <div class="m-10">
     <h1 class="text-5xl "> Recommendation Search Bar: Discovering Movies Like Never Before</h1>
     <p class="text-2xl">
         The recommendation search bar is a powerful tool
         designed to enhance your movie exploration experience.
         As you type in your search query, this bar dynamically
         suggests movies based on your input. It utilizes advanced
         algorithms to analyze various factors, such as genre, actors,
         directors, and viewer preferences, to find movies that closely
         match your interests. This feature ensures that movie
         enthusiasts can effortlessly navigate through vast content libraries
         and find their next favorite watch.</p>
 </div>
 <div class="w-full max-w-xs ml-16 ">
     <form action="{{url('/taste')}}" method="post">

         @csrf
         <div class="flex justify-left">
             <div class="ml-9  ml-40">
                 <label for="movie " class=" text-2xl my-5snv text-4xl">Movie Title</label>
                 <input class="pr-40 rounded inline mt-2" type="text" name="movie" id="movie"
                     placeholder="search for a movie ">

                 <input type="submit" value="search"
                     class="mt-2 inline bg-white px-10 hover:bg-lime-200 duration-500 text-gray-800 
                 font-semibold py-2 px-4 border border-gray-400 rounded shadow">

             </div>
         </div>

     </form>
 </div>



 <div class="p-8">
     @if ($datas > 0)
     <strong class="text-3xl text-center">Similar movies</strong>
     <div class="loader"></div>

     <div class="grid grid-cols-4 gap-4">
         @foreach ($datas as $movie)
         <div class="bg-cyan-300 rounded text-center">
             {{ $movie['name'] }}
         </div>
         @endforeach
     </div>
     @else
     <p class="ml-8">No similar movies found.</p>
     @endif

 </div>