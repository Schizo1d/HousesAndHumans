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
    document.getElementById("register-form").addEventListener("submit", async function (event) {
        event.preventDefault();
        let formData = new FormData(this);

        let response = await fetch("{{ route('register') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
        });

        let data = await response.json();
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    });

    document.getElementById("login-form").addEventListener("submit", async function (event) {
        event.preventDefault();
        let formData = new FormData(this);

        let response = await fetch("{{ route('login') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
        });

        let data = await response.json();
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    });
});
