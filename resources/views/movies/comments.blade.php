<x-page-heading />
<div class="container" style="background-color: #FCFAEE;">
    <div class="bg-[#507687] text-4xl mt-5 p-5 mb-5">
        <h1 class="ml-16">all the reviews about {{$movie->title}} ({{substr($movie->release_date , 0 , 4) }})</h1>
    </div>
    @foreach ($comments->getComments($movie) as $comment)
    <div class="border-2 rounded-lg mx-16 mt-1 shadow-md text-xl">
        <p class=" p-5">
            A review by {{$user->getUserName( $comment->user_id)}}
            <span class="text-base">
                written on {{str_replace("-", "/",  strstr($comment->created_at , ' ' , true))}}
                {{strtotime(5)}}
            </span>
            <br>
            <span class="text-lg/8 ">{{$comment->comment}}</span>

        </p>
    </div>
    @endforeach
</div>