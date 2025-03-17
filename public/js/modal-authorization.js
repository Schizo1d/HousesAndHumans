function openLoginModal() {
    document.getElementById("login-modal").style.display = "flex";
    document.getElementById("register-modal").style.display = "none";
}

function openRegisterModal() {
    document.getElementById("register-modal").style.display = "flex";
    document.getElementById("login-modal").style.display = "none";
}

function switchToRegister() {
    openRegisterModal();
}

function switchToLogin() {
    openLoginModal();
}

function closeModal() {
    document.getElementById("login-modal").style.display = "none";
    document.getElementById("register-modal").style.display = "none";
}

