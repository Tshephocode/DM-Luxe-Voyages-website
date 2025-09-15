
(function () {
    "use strict";
    let form = document.querySelector('#newsletter-form');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        let thisForm = this;

        thisForm.querySelector('.loading').classList.add('d-block');
        thisForm.querySelector('.error-message').classList.remove('d-block');
        thisForm.querySelector('.sent-message').classList.remove('d-block');

        let formData = new FormData(thisForm);

        fetch(thisForm.action, {
            method: 'POST',
            body: formData
        })
            .then(res => res.text())
            .then(data => {
                thisForm.querySelector('.loading').classList.remove('d-block');
                if (data.trim() === 'OK') {
                    thisForm.querySelector('.sent-message').classList.add('d-block');
                    thisForm.reset();
                } else {
                    thisForm.querySelector('.error-message').innerHTML = data;
                    thisForm.querySelector('.error-message').classList.add('d-block');
                }
            })
            .catch(err => {
                thisForm.querySelector('.loading').classList.remove('d-block');
                thisForm.querySelector('.error-message').innerHTML = err;
                thisForm.querySelector('.error-message').classList.add('d-block');
            });
    });
})();
