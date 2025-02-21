<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персонажи</title>
    <link rel="stylesheet" href="{{ asset('css/character_info.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
<header>
    <div class="container">
        <div class="background-image-main">
            <img src="{{asset ('img/clouds.png')}}" alt="облака">
        </div>
        <div class="header__inner">
            <nav class="nav">
                <a href="{{ route('character_list') }}"><i class="fa-solid fa-backward"></i></a>
                <h1>{{ $character->name }}</h1>
                @if(Auth::check())
                    <div class="user-info-avatar" id="user-info">
                        <img id="avatar" src="{{ session('user_avatar') }}" alt="Avatar"
                             style="width: 50px; height: 50px; border-radius: 50%;">
                    </div>
                @else
                    <a class="window-auth" onclick="openModal();"><i class="fa-regular fa-circle-user"></i></a>
                @endif
            </nav>
        </div>
    </div>
</header>

<main>
    <div class="container-info">
        <form action="{{ route('character_attributes.store', ['character' => $character->id]) }}" method="POST">
            @csrf
            <input type="hidden" name="character_id" value="{{ $character->id }}">

            <div class="attributes">
                <label>Сила:</label>
                <button type="button" class="open-modal" data-attr="strength" data-value="{{ $character->attributes->strength ?? '' }}">
                    {{ $character->attributes->strength ?? '' }}
                </button>

                <label>Ловкость:</label>
                <button type="button" class="open-modal" data-attr="dexterity" data-value="{{ $character->attributes->dexterity ?? '' }}">
                    {{ $character->attributes->dexterity ?? '' }}
                </button>

                <label>Телосложение:</label>
                <button type="button" class="open-modal" data-attr="constitution" data-value="{{ $character->attributes->constitution ?? '' }}">
                    {{ $character->attributes->constitution ?? '' }}
                </button>

                <label>Интеллект:</label>
                <button type="button" class="open-modal" data-attr="intelligence" data-value="{{ $character->attributes->intelligence ?? '' }}">
                    {{ $character->attributes->intelligence ?? '' }}
                </button>

                <label>Мудрость:</label>
                <button type="button" class="open-modal" data-attr="wisdom" data-value="{{ $character->attributes->wisdom ?? '' }}">
                    {{ $character->attributes->wisdom ?? '' }}
                </button>

                <label>Харизма:</label>
                <button type="button" class="open-modal" data-attr="charisma" data-value="{{ $character->attributes->charisma ?? '' }}">
                    {{ $character->attributes->charisma ?? '' }}
                </button>
            </div>

            <button type="submit">Сохранить атрибуты</button>
        </form>
    </div>

    <!-- Модальное окно -->
    <div id="attributeModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3 id="modal-title"></h3>
            <input type="number" id="modal-input" min="1" max="30">
            <input type="hidden" id="modal-attribute">
            <button id="save-attribute">Сохранить</button>
        </div>
    </div>

    <style>
        .modal { display: none; position: fixed; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); }
        .modal-content { background: white; padding: 20px; margin: 15% auto; width: 300px; text-align: center; }
        .close { float: right; font-size: 24px; cursor: pointer; }
        button { display: block; margin: 10px; padding: 10px; }
    </style>

    <script>
        document.querySelectorAll('.open-modal').forEach(button => {
            button.addEventListener('click', function () {
                const attr = this.getAttribute('data-attr');
                const value = this.getAttribute('data-value');
                document.getElementById('modal-title').innerText = `Изменить ${attr}`;
                document.getElementById('modal-input').value = value;
                document.getElementById('modal-attribute').value = attr;
                document.getElementById('attributeModal').style.display = 'block';
            });
        });

        document.querySelector('.close').addEventListener('click', function () {
            document.getElementById('attributeModal').style.display = 'none';
        });

        document.getElementById('save-attribute').addEventListener('click', function () {
            const attr = document.getElementById('modal-attribute').value;
            const value = document.getElementById('modal-input').value;
            document.querySelector(`[data-attr="${attr}"]`).textContent = value;
            document.querySelector(`input[name="${attr}"]`)?.remove();
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = attr;
            input.value = value;
            document.querySelector('form').appendChild(input);
            document.getElementById('attributeModal').style.display = 'none';
        });
    </script>
</main>

</body>

</html>

