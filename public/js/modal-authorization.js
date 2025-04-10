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
    async function handleFormSubmit(event, route) {
        event.preventDefault(); // Остановим стандартное поведение формы
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
                credentials: "include"
            });

            let data;
            try {
                data = await response.json();
            } catch (e) {
                console.error("Ошибка парсинга JSON:", e);
                window.location.reload(); // Если сервер вернул HTML (редирект), просто перезагрузим страницу
                return;
            }

            if (data.success) {
                console.log("Авторизация/регистрация успешна, перезагрузка страницы...");
                window.location.href = data.redirect;
                window.location.reload(true); // Принудительно обновляем страницу
            } else {
                console.error("Ошибка авторизации/регистрации:", data.message);
            }
        } catch (error) {
            console.error("Ошибка запроса:", error);
            window.location.reload(); // Если что-то пошло не так, принудительно обновим страницу
        }
    }

    // Навешиваем обработчики на формы регистрации и логина
    document.getElementById("register-form")?.addEventListener("submit", (event) =>
        handleFormSubmit(event, "/register")
    );

    document.getElementById("login-form")?.addEventListener("submit", (event) =>
        handleFormSubmit(event, "/login")
    );
});
