document.addEventListener("DOMContentLoaded", function () {
    let form = document.querySelector("form .logado");

    if (form) {
        setTimeout(() => {
            location.href = `${BASE}admin`;
        }, 1000);
    }
});
