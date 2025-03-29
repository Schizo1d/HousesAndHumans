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
document.getElementById("register-form").addEventListener("submit", function (event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch("/register", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Перезагрузка страницы после успешной регистрации
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error("Ошибка:", error));
});

document.getElementById("login-form").addEventListener("submit", function (event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch("/login", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Перезагрузка страницы после успешного входа
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error("Ошибка:", error));
});
