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
                credentials: "include",
                redirect: "follow" // Позволяет fetch автоматически следовать редиректам
            });

            // Если браузер сам обработал редирект, просто завершаем выполнение
            if (response.redirected) {
                window.location.href = response.url;
                return;
            }

            // Проверяем, что сервер вернул JSON
            let contentType = response.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                throw new Error("Сервер вернул не JSON, возможно, произошёл редирект или ошибка.");
            }

            let data = await response.json();

            if (data.success) {
                window.location.replace(data.redirect || '/'); // Перенаправляем на главную
            } else {
                console.error("Ошибка авторизации/регистрации:", data.message);
            }
        } catch (error) {
            console.error("Ошибка запроса:", error);
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
