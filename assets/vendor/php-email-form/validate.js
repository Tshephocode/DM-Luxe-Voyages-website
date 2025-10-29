document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("newsletter-form");

    form.addEventListener("submit", function (e) {
        e.preventDefault();
        const loading = form.querySelector(".loading");
        const error = form.querySelector(".error-message");
        const success = form.querySelector(".sent-message");

        loading.classList.add("d-block");
        error.classList.remove("d-block");
        success.classList.remove("d-block");

        fetch(form.action, {
            method: "POST",
            body: new FormData(form),
        })
            .then((res) => res.json())
            .then((data) => {
                loading.classList.remove("d-block");
                if (data.status === "success") {
                    success.classList.add("d-block");
                    form.reset();
                } else {
                    error.innerHTML = data.message;
                    error.classList.add("d-block");
                }
            })
            .catch(() => {
                loading.classList.remove("d-block");
                error.innerHTML = "Something went wrong. Please try again.";
                error.classList.add("d-block");
            });
    });
});

