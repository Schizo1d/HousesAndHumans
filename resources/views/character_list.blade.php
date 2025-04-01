<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персонажи</title>
    <link rel="stylesheet" href="{{ asset('css/character_list.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
<header>
    <div class="container">
        <div class="header__inner">
            <nav class="nav">
                <a href="{{ route('main') }}"><i class="fa-solid fa-backward"></i></a>
                <h1>Вселенные</h1>
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
    <div class="container">
        <div class="background-image-main">
            <img src="{{asset ('img/clouds.png')}}" alt="контур">
        </div>
        @if(Auth::check())
            <p style="font-size: 36px" class="list-text-title">
                Мои персонажи <span id="character-counter">(0/16)</span>
            </p>
            <div id="character-container" class="characters-container">
                <!-- Загружаем сохранённые персонажи -->
                @foreach($characters as $character)

                        <div class="character-card" data-id="{{ $character->id }}">
                            <a style="text-decoration: none" href="{{route('character_info', ['id' => $character->id])}}">
                            <div class="character-name">{{ $character->name }}</div>
                            </a>
                            <button class="delete-button">Удалить</button>
                        </div>


                @endforeach

                <!-- Кнопка добавления персонажа -->
                <div id="add-character" class="character-card add-character">
                    <i class="fa-solid fa-plus fa-2x"></i>
                </div>
            </div>
            <script>
                const characterContainer = document.getElementById('character-container');
                const addCharacterButton = document.getElementById('add-character');
                const characterCounter = document.getElementById('character-counter');

                // Функция для обновления счетчика
                function updateCharacterCounter() {
                    const totalCharacters = document.querySelectorAll('.character-card').length - 1; // Исключаем кнопку "+"
                    characterCounter.textContent = `(${totalCharacters}/16)`;

                    // Показываем или скрываем кнопку "+"
                    addCharacterButton.style.display = totalCharacters >= 16 ? "none" : "flex";
                }
                // Вызываем функцию при загрузке страницы
                updateCharacterCounter();

                // Добавление нового персонажа
                addCharacterButton.addEventListener('click', async () => {
                    const characterCards = document.querySelectorAll('.character-card').length;
                    updateCharacterCounter();
                    if (characterCards >= 17) {
                        alert("Максимальное количество персонажей достигнуто!");
                        addCharacterButton.style.display = "none"; // Скрываем кнопку добавления
                        return;
                    }

                    let name = prompt("Введите имя персонажа:");
                    name = name ? name.trim() : "Безымянный персонаж"; // Имя по умолчанию

                    try {
                        const response = await fetch('/characters', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({name}),
                        });

                        const character = await response.json();

                        // Создаём новый блок персонажа
                        const newCharacter = document.createElement('div');
                        newCharacter.className = 'character-card';
                        newCharacter.setAttribute('data-id', character.id);
                        newCharacter.innerHTML = `<div class="character-name">${character.name}</div>
        <button class="delete-button">Удалить</button>`;

                        // Подключаем событие удаления
                        newCharacter.querySelector('.delete-button').addEventListener('click', () => {
                            deleteCharacter(character.id, newCharacter);
                        });

                        // Добавляем новый элемент перед кнопкой добавления
                        characterContainer.insertBefore(newCharacter, addCharacterButton);
                        updateCharacterCounter();
                        // Проверяем, если персонажей уже 16, убираем кнопку добавления
                        if (document.querySelectorAll('.character-card').length >= 17) {
                            addCharacterButton.style.display = "none";
                        }
                    } catch (error) {
                        console.error('Ошибка при добавлении персонажа:', error);
                    }
                });


                // Удаление персонажа
                const deleteCharacter = async (id, element) => {
                    if (!confirm('Вы уверены, что хотите удалить этого персонажа?')) return;

                    try {
                        await fetch(`/characters/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                        });

                        // Удаляем элемент из DOM
                        element.remove();

                        // Если персонажей стало меньше 16, показываем кнопку добавления
                        updateCharacterCounter();
                        if (document.querySelectorAll('.character-card').length < 17) {
                            addCharacterButton.style.display = "flex";
                        }
                    } catch (error) {
                        console.error('Ошибка при удалении персонажа:', error);
                    }
                };

                // Подключаем удаление к существующим персонажам
                document.querySelectorAll('.delete-button').forEach(button => {
                    const characterElement = button.closest('.character-card');
                    const characterId = characterElement.getAttribute('data-id');
                    button.addEventListener('click', () => {
                        deleteCharacter(characterId, characterElement);
                    });
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
