document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("register-link").addEventListener("click", function (event) {
        event.preventDefault();
        openRegisterModal();
    });

    document.getElementById("login-link").addEventListener("click", function (event) {
        event.preventDefault();
        openLoginModal();
    });

    document.querySelectorAll(".close-modal").forEach(button => {
        button.addEventListener("click", closeModal);
    });
});

function openLoginModal() {
    document.getElementById("login-modal").style.display = "flex";
    document.getElementById("register-modal").style.display = "none";
}

function openRegisterModal() {
    document.getElementById("register-modal").style.display = "flex";
    document.getElementById("login-modal").style.display = "none";
}

function closeModal() {
    document.getElementById("login-modal").style.display = "none";
    document.getElementById("register-modal").style.display = "none";
}
