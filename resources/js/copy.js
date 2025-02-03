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