/**
* Google Apps Script Form Validation - v1.0
* Adapted from BootstrapMade's PHP Email Form
* Modified for Google Apps Script Endpoints
*/
(function () {
    "use strict";

    let forms = document.querySelectorAll('.php-email-form');

    forms.forEach(function (e) {
        e.addEventListener('submit', function (event) {
            event.preventDefault();

            let thisForm = this;

            let action = thisForm.getAttribute('action');

            if (!action) {
                displayError(thisForm, 'The form action property is not set!');
                return;
            }
            thisForm.querySelector('.loading').classList.add('d-block');
            thisForm.querySelector('.error-message').classList.remove('d-block');
            thisForm.querySelector('.sent-message').classList.remove('d-block');

            let formData = new FormData(thisForm);

            // For Google Apps Script, we need to handle the response differently
            google_script_form_submit(thisForm, action, formData);
        });
    });

    function google_script_form_submit(thisForm, action, formData) {
        // Convert FormData to a plain object for Google Apps Script
        let formObject = {};
        for (let [key, value] of formData.entries()) {
            formObject[key] = value;
        }

        fetch(action, {
            method: 'POST',
            body: JSON.stringify(formObject),
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => {
                if (response.ok) {
                    return response.json(); // Google Script typically returns JSON
                } else {
                    throw new Error(`${response.status} ${response.statusText} ${response.url}`);
                }
            })
            .then(data => {
                thisForm.querySelector('.loading').classList.remove('d-block');

                // Google Apps Script usually returns {result: "success"} or similar
                // Adjust this condition based on your actual Google Script's response
                if (data.result === "success" || data.status === "success") {
                    thisForm.querySelector('.sent-message').classList.add('d-block');
                    thisForm.reset();
                } else {
                    // If Google Script returns an error message in the response
                    const errorMsg = data.message || data.error || 'Form submission failed. Please try again.';
                    throw new Error(errorMsg);
                }
            })
            .catch((error) => {
                displayError(thisForm, error);
            });
    }

    function displayError(thisForm, error) {
        thisForm.querySelector('.loading').classList.remove('d-block');
        thisForm.querySelector('.error-message').innerHTML = error;
        thisForm.querySelector('.error-message').classList.add('d-block');
    }

})();