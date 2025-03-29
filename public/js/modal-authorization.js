const modal = document.getElementsByClassName("modal-bg")[0];
const openModal = () => {
    modal.style.display = "block";
}

function switchToRegister() {
    document.getElementById("login-modal").style.display = "none";
    document.getElementById("register-modal").style.display = "flex";
}

function switchToLogin() {
    document.getElementById("register-modal").style.display = "none";
    document.getElementById("login-modal").style.display = "flex";
}

function closeModal() {
    document.getElementById("login-modal").style.display = "none";
    document.getElementById("register-modal").style.display = "none";
}

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("register-link").addEventListener("click", function (event) {
        event.preventDefault();
        switchToRegister();
    });

    document.getElementById("login-link").addEventListener("click", function (event) {
        event.preventDefault();
        switchToLogin();
    });
});
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("register-form").addEventListener("submit", function (event) {
        event.preventDefault();
        this.submit(); // Отправка формы без AJAX, браузер сам перезагрузит страницу
    });

    document.getElementById("login-form").addEventListener("submit", function (event) {
        event.preventDefault();
        this.submit(); // Отправка формы без AJAX
    });
});
