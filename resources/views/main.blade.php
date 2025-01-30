<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Houses&Humans</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-style.css') }}">
    <link rel="stylesheet" href="{{asset('css/modal-authorization.css')}}">
    <link rel="stylesheet" href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css')}}">

</head>
<div></div>
<body>
<header>
    <div class="container">
        <div class="header__inner">
            <nav class="nav">
                <div class="image-text-container">
                    <img src="{{ asset('img/frame1.png') }}" alt="">
                    <a class="text-overlay " href="{{route('character_list')}}">листы персонажей</a>
                </div>
                <div class="image-text-container">
                    <img src="{{ asset('img/frame2.png') }}" alt="">
                    <a style="font-size: 56px; top: 38%; cursor: pointer; " class="text-overlay" onclick="openModal();">авторизация</a>
                </div>
                <div class="image-text-container">
                    <img src="{{asset('img/frame1.png')}}" alt="">
                    <a class="text-overlay" href="">справочник героя</a>
                </div>
            </nav>
        </div>
    </div>

    <div class="modal-bg">
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
                    <input type="text">
                    <input type="text">
                    <div class="buttons-container">
                        <button  type="button">войти через<i style="margin-left: 20px" class="fa-brands fa-google"></i></button>
                        <a style="text-decoration: none" href="{{route('vk.auth')}}"><button  type="button">войти через<i style="margin-left: 20px" class="fa-brands fa-vk"></i></button></a>
                    </div>
                </div>
            </div>
{{--            <div>--}}
{{--                <script src="https://unpkg.com/@vkid/sdk@<3.0.0/dist-sdk/umd/index.js"></script>--}}
{{--                <script type="text/javascript">--}}
{{--                    if ('VKIDSDK' in window) {--}}
{{--                        const VKID = window.VKIDSDK;--}}

{{--                        VKID.Config.init({--}}
{{--                            app: 52983807,--}}
{{--                            redirectUrl: 'https://localhost/vk/auth/callback',--}}
{{--                            responseMode: VKID.ConfigResponseMode.Callback,--}}
{{--                            source: VKID.ConfigSource.LOWCODE,--}}
{{--                            scope: 'email phone', // Заполните нужными доступами по необходимости--}}
{{--                        });--}}

{{--                        const oneTap = new VKID.OneTap();--}}

{{--                        oneTap.render({--}}
{{--                            container: document.currentScript.parentElement,--}}
{{--                            showAlternativeLogin: true--}}
{{--                        })--}}
{{--                            .on(VKID.WidgetEvents.ERROR, vkidOnError)--}}
{{--                            .on(VKID.OneTapInternalEvents.LOGIN_SUCCESS, function (payload) {--}}
{{--                                const code = payload.code;--}}
{{--                                const deviceId = payload.device_id;--}}

{{--                                VKID.Auth.exchangeCode(code, deviceId)--}}
{{--                                    .then(vkidOnSuccess)--}}
{{--                                    .catch(vkidOnError);--}}
{{--                            });--}}

{{--                        function vkidOnSuccess(data) {--}}
{{--                            // Обработка полученного результата--}}
{{--                        }--}}

{{--                        function vkidOnError(error) {--}}
{{--                            // Обработка ошибки--}}
{{--                        }--}}
{{--                    }--}}
{{--                </script>--}}
{{--            </div>--}}
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
