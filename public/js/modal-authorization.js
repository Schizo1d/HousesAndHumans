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

    async function handleFormSubmit(event, route) {
        event.preventDefault();
        let form = event.target;
        let formData = new FormData(form);

        try {
            let response = await fetch(route, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Accept": "application/json"
                },
                credentials: "include"  // 💥 ВАЖНО! Позволяет браузеру сохранять сессию
            });

            let data = await response.json();
            if (data.success) {
                window.location.href = "/";  // 💥 Вместо reload, редирект на главную
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error("Ошибка запроса:", error);
            alert("Ошибка соединения с сервером.");
        }
    }

    document.getElementById("register-form").addEventListener("submit", (event) =>
        handleFormSubmit(event, "/register")
    );

    document.getElementById("login-form").addEventListener("submit", (event) =>
        handleFormSubmit(event, "/login")
    );
});
