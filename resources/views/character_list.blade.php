<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персонажи</title>
    <link rel="stylesheet" href="{{asset('css/character_list.css')}}">
    <link rel="stylesheet"
          href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css')}}">
</head>

<body>
<header>
    <div class="container">
        <div class="header__inner">
            <nav class="nav">
                <a href="{{route('main')}}"><i class="fa-solid fa-backward"></i></a>
                <h1>Вселенные</h1>
                @if(Auth::check())
                    <div id="user-info">
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
    <div class="container">
        @if(Auth::check())
            <h1 class="list-text-title">Мои персонажи</h1>
            <div id="character-container" class="character-container">
                <!-- Кнопка добавления персонажа -->
                <div id="add-character" class="character-add">
                    <i class="fa-solid fa-plus"></i>
                </div>
            </div>
            <script>
                // Счётчик для ID персонажей
                let characterCount = 0;

                // Ссылка на контейнер с персонажами
                const characterContainer = document.getElementById('character-container');
                const addCharacterButton = document.getElementById('add-character');

                // Обработчик клика для добавления персонажа
                addCharacterButton.addEventListener('click', () => {
                    characterCount++;
                    const characterId = `character-${characterCount}`; // Это теперь используем для установки id элемента

                    // Создаём новый блок персонажа
                    const newCharacter = document.createElement('div');
                    newCharacter.className = 'character-item';
                    newCharacter.id = characterId;  // Присваиваем новый id персонажу
                    newCharacter.innerHTML = `<div class="character-name">Персонаж ${characterCount}</div>`;

                    // Добавляем обработчик клика для перехода на страницу персонажа
                    newCharacter.addEventListener('click', () => {
                        window.location.href = `/character/${characterCount}`;
                    });

                    // Вставляем персонажа перед кнопкой добавления
                    characterContainer.insertBefore(newCharacter, addCharacterButton);
                });
            </script>
        @else
            <h1 class="list-text-title">Интерактивный лист персонажа для D&D 5e</h1>
            <p class="list-text-subtitle">Чтобы продолжить, войдите в свой аккаунт или создайте новый.</p>
            <ul>
                <li class="list-text-item_list">Синхронизация между несколькими устройствами</li>
                <li class="list-text-item_list">Удобное отслеживание здоровья, опыта и монет</li>
                <li class="list-text-item_list">Безопасное хранилище для ваших персонажей</li>
                <li class="list-text-item_list">Несколько популярных переводов на выбор</li>
                <li class="list-text-item_list">Автоматический расчёт характеристик</li>
                <li class="list-text-item_list">Отправка бросков в Discord</li>
            </ul>
        @endif
    </div>
    <div class="footer"></div>
</main>
</body>

</html>
