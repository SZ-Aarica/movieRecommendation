 <form {{$attributes}}>
     @csrf
     <div class="flex justify-left">
         <div class="ml-9  ml-40">
             <label for="movie " class="block text-2xl my-5snv">{{ $slot }}</label>
             <input class="pr-40 rounded" type="text" name="movie" id="movie" placeholder="{{ $attributes->get('placeholder', 'search for a movie') }}">
             <input type="submit" value="search"
                 class="mt-2 inline bg-white px-10 hover:bg-lime-200 duration-500 text-gray-800 
                 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
         </div>
     </div>

 </form>