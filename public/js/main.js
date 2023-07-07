document.addEventListener('DOMContentLoaded', function () {
    var logos = ['logo1.png', 'logo2.png', 'logo3.png', 'logo4.png'];
    var logoTexts = ['SHGIARE PLACK S1G•P SKIIRQ HARK', 'SHARK SHA PHOKANGE', 'SHARK SHRANAC SPAGK PA PHAGE PHI', 'PHARIG GHARK GHIAR'];
    var logoElement = document.getElementById('logo');
    logoWinner = Math.floor(Math.random() * logos.length);
    logoElement.src = logos[logoWinner];
    logoTextElement.textContent = logoTexts[logoWinner];

    var questionFormElement = document.getElementById('question-form');
    var answerElement = document.getElementById('answer');
    var explanationElement = document.getElementById('explanation');
    var MessageElement = document.getElementById('countMsg');
    var submitButtonElement = document.getElementById('submit-button');
    var lightboxElement = document.getElementById('lightbox');
    var lightboxCloseElement = document.getElementById('lightbox-close');
    var lightboxReopenElement = document.getElementById('lightbox-reopen');

    questionFormElement.addEventListener('submit', function(e) {
        e.preventDefault();
        logoElement.classList.add('wiggle');
        submitButtonElement.disabled = true; // Disables the submit button
        submitButtonElement.classList.add('disabled'); // Greys out the submit button
        var answer = answerElement.value;

        fetch('/backend.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'answer=' + encodeURIComponent(answer)
        })
            .then(response => response.json())
            .then(data => {
                logoElement.classList.remove('wiggle');
                explanationElement.textContent = data.explanation;
                MessageElement.textContent= "This reason has been given "+data.count+" times.";
                explanationElement.classList.remove('d-none', 'alert-success', 'alert-danger', 'happyWiggle', 'angryWiggle');
                submitButtonElement.disabled = false; // Re-enables the submit button
                submitButtonElement.classList.remove('disabled'); // Removes the greying out of the submit button

                if (data.answerIsValid) {
                    explanationElement.classList.add('alert-success', 'happyWiggle');
                } else {
                    explanationElement.classList.add('alert-danger', 'angryWiggle');
                }
            });
    });
});

