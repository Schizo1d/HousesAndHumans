<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Houses&Humans</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-style.css') }}">
    <link rel="stylesheet" href="{{asset('css/modal-authorization.css')}}">
    <link rel="stylesheet" href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css')}}">

</head>
<body>
<header>
    <div class="container">
        <div class="header__inner">
            <nav class="nav">
                <div class="image-text-container" style="height: 80px">
                    <img src="{{ asset('img/frame1.png') }}" alt="">
                    <a class="text-overlay " href="{{route('character_list')}}">листы персонажей</a>
                </div>
                <div class="image-text-container">
                    @if (Auth::check())
                        <div id="user-info" style="text-align: center;">
                            <img id="avatar" src="{{ session('user_avatar') }}" alt="Avatar" style="width: 50px; height: 50px; border-radius: 50%; margin-bottom: 10px;">
                            <span id="username" style="font-size: 24px; display: block; margin-bottom: 10px;">{{ session('user_name') }}</span>
                            <!-- Кнопка выхода ниже аватара и имени -->
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" style="font-size: 18px; cursor: pointer; background-color: #db934e; color: white; border: none; padding: 10px 20px; border-radius: 5px; margin-top: 10px;">
                                    Выйти
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- Плашка с кнопкой для авторизации, если пользователь не авторизован -->
                        <img src="{{ asset('img/frame2.png') }}" alt="">
                       <a style="font-size: 56px; top: 38%; cursor: pointer;" class="text-overlay" onclick="openModal();">авторизация</a>
                    @endif
                </div>
                <div class="image-text-container" style="height: 80px">
                    <img src="{{asset('img/frame1.png')}}" alt="">
                    <a class="text-overlay" href="">справочник героя</a>
                </div>
            </nav>
        </div>
    </div>

    <div class="modal-bg" id="login-modal">
        <div class="modal">
            <i class="fa-solid fa-xmark close-modal" onclick="closeModal()"></i>
            <img class="modal-img-frame1-3" src="{{asset('img/frame1-3.png')}}" alt="">
            <img class="modal-img-frame2-3" src="{{asset('img/frame2-3.png')}}" alt="">
            <div class="text-modal-authorization">
                <img class="modal-img-frame3-3" src="{{asset('img/frame3-3.png')}}" alt="">
                <p class="text-authorization">Войти в аккаунт</p>
            </div>
            <div class="input-block">
                <div class="input-text">
                    <form id="login-form">
                        <input type="email" id="login-email" name="email" placeholder="Email" required autocomplete="email">
                        <input type="password" id="login-password" name="password" placeholder="Пароль" required>
                        <button type="submit" class="btn-auth">Войти</button>
                    </form>
                    <div class="buttons-container">
                        <button type="button">
                            Войти через <i class="fa-brands fa-google"></i>
                        </button>
                        <button type="button" onclick="location.href='{{route('vk.auth')}}'">
                            Войти через <i class="fa-brands fa-vk"></i>
                        </button>
                    </div>
                </div>
            </div>

            <p class="switch-modal">Нет аккаунта? <a href="#" id="register-link">Зарегистрироваться</a></p>
        </div>
    </div>

    <div class="modal-bg" id="register-modal" style="display: none;">
        <div class="modal">
            <i class="fa-solid fa-xmark close-modal" onclick="closeModal()"></i>
            <img class="modal-img-frame1-3" src="{{asset('img/frame1-3.png')}}" alt="">
            <img class="modal-img-frame2-3" src="{{asset('img/frame2-3.png')}}" alt="">
            <div class="text-modal-authorization">
                <img class="modal-img-frame3-3" src="{{asset('img/frame3-3.png')}}" alt="">
                <p class="text-authorization">Регистрация</p>
            </div>
            <div class="input-block">
                <div class="input-text">
                    <form id="register-form">
                        <input type="text" id="register-name" name="name" placeholder="Имя" required autocomplete="name">
                        <input type="email" id="register-email" name="email" placeholder="Email" required autocomplete="email">
                        <input type="password" id="register-password" name="password" placeholder="Пароль" required>
                        <input type="password" id="register-password-confirm" name="password_confirmation" placeholder="Подтвердите пароль" required>
                        <button type="submit" class="btn-auth">Зарегистрироваться</button>
                    </form>
                </div>
            </div>
            <p class="switch-modal">Уже есть аккаунт? <a href="#" id="login-link">Войти</a></p>
        </div>
    </div>
</header>
<main>
            <div class="background-image-main">
                <img src="{{asset ('img/clouds.png')}}" alt="облака">
            </div>
            <div class="image-text-container-logo">
                <img src="{{asset('img/logo.png')}}" alt="">
                <p class="text-overlay-logo">клуб настольных<br>ролевых игр</p>
            </div>
            <div class="house-div">
                <img class="house-img" src="{{asset('img/House.png')}}" alt="">
            </div>
            <div class="city-div">
            </div>

</main>
</body>
<script src="{{ asset('js/modal-authorization.js') }}"></script>
</html>

