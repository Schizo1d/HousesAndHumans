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

    <!-- Модальное окно изначально скрыто -->
    <div id="attributeModal" class="modal" style="display: none;">
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
    // Функция для открытия модального окна
    function openModal(attr, value) {
        document.getElementById("modal-title").innerText = "Изменить " + attr;
        document.getElementById("modal-input").value = value;
        document.getElementById("modal-attribute").value = attr;
        document.getElementById("attributeModal").style.display = "flex"; // показываем модалку
    }

    // Функция для закрытия модального окна
    function closeModal() {
        document.getElementById("attributeModal").style.display = "none"; // скрываем модалку
    }

    // Добавляем обработчики кликов на кнопки, чтобы открыть модалку
    document.querySelectorAll('.open-modal').forEach(button => {
        button.addEventListener('click', function () {
            openModal(this.getAttribute('data-attr'), this.getAttribute('data-value'));
        });
    });

    // Функция для сохранения атрибута
    function saveAttribute() {
        let attr = document.getElementById("modal-attribute").value;
        let value = document.getElementById("modal-input").value;
        document.querySelector(`[data-attr="${attr}"]`).textContent = value; // обновляем текст на кнопке
        document.querySelector(`input[name="${attr}"]`)?.remove(); // удаляем старый скрытый input
        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = attr;
        input.value = value;
        document.querySelector('form').appendChild(input); // добавляем новый input в форму
        closeModal(); // закрываем модалку
    }
</script>
</body>
</html>
