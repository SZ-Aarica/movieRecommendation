import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// resources/js/app.js

document.addEventListener('DOMContentLoaded', () => {
    const favoritesContainer = document.getElementById('favorites-container');
    if (!favoritesContainer) return;

    const userId = favoritesContainer.getAttribute('data-user-id');
    const movieId = favoritesContainer.getAttribute('data-movie-id');

    const addFavouriteButton = document.getElementById("addFavourite");
    if (!addFavouriteButton) return;

    const emptyHeart = document.getElementById("emptyHeart");
    const filledHeart = document.getElementById("filledHeart");

    // Retrieve CSRF Token from Meta Tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Initialize the state based on the heart icon visibility
    let isSelected = filledHeart && !filledHeart.hasAttribute('hidden');

    addFavouriteButton.addEventListener("click", function () {
        if (!isSelected) {
            // Show filled heart and hide empty heart
            filledHeart.removeAttribute("hidden");
            emptyHeart.setAttribute("hidden", '');
            isSelected = true;

            // Send POST request to add favorite
            fetch('/add-favorite', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ user_id: userId, movie_id: movieId })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message);
                // Optionally, handle UI updates or notifications here
            })
            .catch(error => {
              
                // Optionally, revert UI changes or notify the user of the error
            });

        } else {
            // Hide filled heart and show empty heart
            filledHeart.setAttribute("hidden", '');
            emptyHeart.removeAttribute("hidden");
            isSelected = false;

            // Send POST request to remove favorite
            fetch('/remove-favorite', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ user_id: userId, movie_id: movieId })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message);
                // Optionally, handle UI updates or notifications here
            })
            .catch(error => {
                console.error('Error:', error);
                // Optionally, revert UI changes or notify the user of the error
            });
        }
    });
});