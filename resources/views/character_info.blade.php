<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персонажи</title>
    <link rel="stylesheet" href="{{ asset('css/character_info.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            padding: 20px;
            width: 320px;
            text-align: center;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .modal-close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 26px;
            cursor: pointer;
            color: #555;
            background: none;
            border: none;
        }

        .modal-close-btn:hover {
            color: #000;
        }

        .modal-save-btn {
            display: block;
            margin: 10px auto;
            padding: 10px 15px;
            border: none;
            background: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .modal-save-btn:hover {
            background: #0056b3;
        }
    </style>
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
                @foreach(['strength' => 'Сила', 'dexterity' => 'Ловкость', 'constitution' => 'Телосложение', 'intelligence' => 'Интеллект', 'wisdom' => 'Мудрость', 'charisma' => 'Харизма'] as $attr => $label)
                    <label>{{ $label }}:</label>
                    <button type="button" class="open-modal" data-attr="{{ $attr }}" data-value="{{ $character->attributes->$attr ?? '' }}">
                        {{ $character->attributes->$attr ?? '' }}
                    </button>
                @endforeach
            </div>
            <button type="submit">Сохранить атрибуты</button>
        </form>
    </div>

    <div id="attributeModal" class="modal">
        <div class="modal-content">
            <button class="modal-close-btn" onclick="closeModal()">✖</button>
            <h3 id="modal-title"></h3>
            <input type="number" id="modal-input" min="1" max="30">
            <input type="hidden" id="modal-attribute">
            <button class="modal-save-btn" onclick="saveAttribute()">Сохранить</button>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('attributeModal');
        const modalInput = document.getElementById('modal-input');
        const modalTitle = document.getElementById('modal-title');
        const modalAttribute = document.getElementById('modal-attribute');
        const saveButton = document.getElementById('save-attribute');

        // Находим все кнопки для открытия модального окна
        document.querySelectorAll('.open-modal').forEach(button => {
            button.addEventListener('click', function () {
                const attr = this.getAttribute('data-attr');
                const value = this.getAttribute('data-value');

                modalTitle.innerText = `Изменить ${attr}`;
                modalInput.value = value;
                modalAttribute.value = attr;

                modal.style.display = 'block';
            });
        });

        // Закрытие модального окна при нажатии на крестик
        document.querySelector('.close').addEventListener('click', function () {
            modal.style.display = 'none';
        });

        // Закрытие при клике вне модального окна
        window.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Обновление значения при сохранении
        saveButton.addEventListener('click', function () {
            const attr = modalAttribute.value;
            const value = modalInput.value;

            document.querySelector(`[data-attr="${attr}"]`).textContent = value;

            // Удаляем старый input, если он уже существует
            document.querySelector(`input[name="${attr}"]`)?.remove();

            // Создаем новый скрытый input с обновленным значением
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = attr;
            input.value = value;
            document.querySelector('form').appendChild(input);

            modal.style.display = 'none';
        });
    });
</script>
</body>
</html>

