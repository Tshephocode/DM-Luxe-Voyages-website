// validate.js
(function () {
    "use strict";

    let forms = document.querySelectorAll('.php-email-form');

    forms.forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            let thisForm = this;

            // Use the URL you got from deploying your Google Apps Script
            let action = thisForm.getAttribute('action') || 'https://script.google.com/macros/s/YOUR_DEPLOYMENT_URL/exec';

            thisForm.querySelector('.loading').classList.add('d-block');
            thisForm.querySelector('.error-message').classList.remove('d-block');
            thisForm.querySelector('.sent-message').classList.remove('d-block');

            // Prepare form data for JSON submission
            let formData = new FormData(thisForm);
            let formObject = {};
            for (let [key, value] of formData.entries()) {
                formObject[key] = value;
            }

            // Send the data to Google Apps Script
            fetch(action, {
                method: 'POST',
                body: JSON.stringify(formObject),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json()) // Parse the JSON response
                .then(data => {
                    thisForm.querySelector('.loading').classList.remove('d-block');
                    if (data.result === "success") {
                        thisForm.querySelector('.sent-message').textContent = data.message;
                        thisForm.querySelector('.sent-message').classList.add('d-block');
                        thisForm.reset();
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch((error) => {
                    displayError(thisForm, error);
                });
        });
    });

    function displayError(thisForm, error) {
        thisForm.querySelector('.loading').classList.remove('d-block');
        thisForm.querySelector('.error-message').innerHTML = error.message || error;
        thisForm.querySelector('.error-message').classList.add('d-block');
    }

})();