document.querySelectorAll('.copy-button').forEach(button => {
    button.addEventListener('click', function() {
        // Find the nearest .text-to-copy element relative to the button
        const text = this.parentElement.querySelector('.text-to-copy').innerText;
        navigator.clipboard.writeText(text).then(() => {
           this.innerText = "Copied!";
             setTimeout(() => {
                this.innerText = "Copy to clipboard";
        },2000);
    }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    });
});

$(document).ready(function() { $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
   $(document).on('click', '.searchMovie', function() {
        // Get the movie name from the data attribute
        const movieName = $(this).data('movie-name');
        ajaxRequest(tasteUrl,movieName);

        console.log(movieName); // Log the name of the clicked movie
    });
});

function ajaxRequest(url , MovieName ){
   $.ajax({
            url: url,  // Use the pre-defined URL
            type: "POST",
            data: {
                movie : MovieName
            },
            success: function(response, status) {
                if (status === 'success') {
                    $("#searchResults").html(response);
                    console.log('updated');
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
