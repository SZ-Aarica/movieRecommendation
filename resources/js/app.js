import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


let addFavourite = document.getElementById("addFavourite");

let selected = true;

addFavourite.addEventListener("click", function () {
    let emptyHeart = document.getElementById("emptyHeart");
    let filledHeart = document.getElementById("filledHeart");

    if(selected){
       
       filledHeart.removeAttribute("hidden"); // Show filled heart  
        emptyHeart.setAttribute("hidden", '');
         selected = false;  
    }else{
       
            filledHeart.setAttribute("hidden", '');  // Hide filled heart  
            emptyHeart.removeAttribute("hidden");     // Show empty heart  
            selected = true; 
    }
});
