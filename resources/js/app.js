import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
//removeFavoriteUrl
function ajaxRequest(url , userId , movieId){
   $.ajax({
            url: url,  // Use the pre-defined URL
            type: "POST",
            data: {
                user_id: userId,
                movie_id: movieId
            },
            success: function(response, status) {
                if (status === 'success') {
                    console.log('Success:', response);
                } else {
                    console.error('Request failed:', status);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                if (xhr.status === 422) {
                    console.error('Validation Errors:', xhr.responseJSON.errors);
                }
            },
            dataType: 'json'
      });
}
// resources/js/app.js

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
   
    $("#addRemoveFavorite").click(function(e){
         e.preventDefault();
         var userId = user_id;
         var movieId = movie_id;
         if(document.getElementById("addRemoveFavorite").innerHTML.trim() == '♡'){
            console.log("empty");
           
         ajaxRequest(addFavoriteUrl , userId , movieId);
               document.getElementById("addRemoveFavorite").classList.add("text-sm");
                document.getElementById("addRemoveFavorite").innerHTML = "added to favorite!";
             setTimeout(() => {
                 document.getElementById("addRemoveFavorite").classList.remove("text-sm");
             document.getElementById("addRemoveFavorite").innerText = "♥";
        },2000);
        
         } else 
         if(document.getElementById("addRemoveFavorite").innerHTML.trim() == "♥"){
        console.log("fill");
        ajaxRequest(removeFavoriteUrl , userId , movieId);
         document.getElementById("addRemoveFavorite").classList.add("text-sm");
                document.getElementById("addRemoveFavorite").innerHTML = "removed from favorite!";
             setTimeout(() => {
                 document.getElementById("addRemoveFavorite").classList.remove("text-sm");
             document.getElementById("addRemoveFavorite").innerText = "♡";
        },2000);
    
         }
  
      
})
});


/*

    $("#addFavourite").click(function(e){
        if(isSelected){
            
            filledHeart.removeAttribute("hidden");
            emptyHeart.setAttribute("hidden", '');
             filledHeart.innerText = "added to favorite";
               setTimeout(() => {
                filledHeart.innerText = "♥";
             },2000);
            isSelected = false;
        e.preventDefault();
      
        var userId = user_id;
        var movieId = movie_id;
     

        $.ajax({
            url: addFavoriteUrl,  // Use the pre-defined URL
            type: "POST",
            data: {
                user_id: userId,
                movie_id: movieId
            },
            success: function(response, status) {
                if (status === 'success') {
                    console.log('Success:', response);
                } else {
                    console.error('Request failed:', status);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                if (xhr.status === 422) {
                    console.error('Validation Errors:', xhr.responseJSON.errors);
                }
            },
            dataType: 'json'
      });
    }else{
          isSelected = true;
          emptyHeart.removeAttribute("hidden");
          filledHeart.setAttribute("hidden", '');
            var userId = user_id;
            var movieId = movie_id;
            
              $.ajax({
            url: removeFavoriteUrl,  // Use the pre-defined URL
            type: "POST",
            data: {
                user_id: userId,
                movie_id: movieId
            },
            success: function(response, status) {
                if (status === 'success') {
                    console.log('Success:', response);
                } else {
                    console.error('Request failed:', status);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                if (xhr.status === 422) {
                    console.error('Validation Errors:', xhr.responseJSON.errors);
                }
            },
            dataType: 'json'
      });
    }
    });
*/