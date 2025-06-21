<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <a href="{{ route('main') }}" class="back-button">На главную</a>
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
            <img src="{{asset ('img/clouds.png')}}" alt="облака">
        </div>
        @if(Auth::check())
            <p style="font-size: 36px" class="list-text-title">
                Мои персонажи <span id="character-counter">({{ count($characters) }}/16)</span>
            </p>
            <div id="character-container" class="characters-container">
                <!-- Загружаем сохранённые персонажи -->
                @foreach($characters as $character)
                    <div class="character-card" data-id="{{ $character->id }}">
                        <div class="menu">
                            <button class="menu-button">⋮</button>
                            <div class="menu-content">
                                <button class="delete-button">Удалить</button>
                            </div>
                        </div>
                        <a style="text-decoration: none" href="{{ route('character_info', ['id' => $character->id]) }}">
                            <div class="character-name">{{ $character->name }}</div>
                        </a>
                    </div>
                @endforeach

                <!-- Кнопка добавления персонажа -->
                @if(count($characters) < 16)
                    <div id="add-character" class="character-card add-character">
                        <i class="fa-solid fa-plus fa-2x"></i>
                    </div>
                @endif
            </div>
            <script>
                const characterContainer = document.getElementById('character-container');
                const addCharacterButton = document.getElementById('add-character');
                const characterCounter = document.getElementById('character-counter');

                // Функция для обновления счетчика
                function updateCharacterCounter() {
                    const totalCharacters = document.querySelectorAll('.character-card:not(.add-character)').length;
                    characterCounter.textContent = `(${totalCharacters}/16)`;

                    // Показываем или скрываем кнопку "+"
                    if (addCharacterButton) {
                        addCharacterButton.style.display = totalCharacters >= 16 ? "none" : "flex";
                    }
                }

                // Функция для создания HTML нового персонажа
                function createCharacterCard(character) {
                    const card = document.createElement('div');
                    card.className = 'character-card';
                    card.setAttribute('data-id', character.id);

                    const menuHtml = `
                        <div class="menu">
                            <button class="menu-button">⋮</button>
                            <div class="menu-content">
                                <button class="delete-button">Удалить</button>
                            </div>
                        </div>
                    `;

                    // Используем тот же маршрут, что и в Blade-шаблоне
                    const linkHtml = `
                        <a style="text-decoration: none" href="/character/${character.id}">
                            <div class="character-name">${character.name}</div>
                        </a>
                    `;

                    card.innerHTML = menuHtml + linkHtml;

                    // Добавляем обработчики событий
                    setupCharacterCardEvents(card);

                    return card;
                }

                // Функция для настройки обработчиков событий карточки персонажа
                function setupCharacterCardEvents(card) {
                    const deleteButton = card.querySelector('.delete-button');
                    const menuButton = card.querySelector('.menu-button');
                    const characterId = card.getAttribute('data-id');

                    // Обработчик удаления
                    deleteButton.addEventListener('click', (e) => {
                        e.stopPropagation();
                        deleteCharacter(characterId, card);
                    });

                    // Обработчик меню
                    menuButton.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const menu = e.target.closest('.menu');
                        document.querySelectorAll('.menu').forEach(m => {
                            if (m !== menu) m.classList.remove('open');
                        });
                        menu.classList.toggle('open');
                    });
                }

                // Добавление нового персонажа
                if (addCharacterButton) {
                    addCharacterButton.addEventListener('click', async () => {
                        const totalCharacters = document.querySelectorAll('.character-card:not(.add-character)').length;
                        if (totalCharacters >= 16) {
                            alert("Максимальное количество персонажей достигнуто!");
                            return;
                        }

                        let name = prompt("Введите имя персонажа:");
                        name = name ? name.trim() : "Безымянный персонаж";

                        try {
                            const response = await fetch('/characters', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                },
                                body: JSON.stringify({ name }),
                            });

                            if (!response.ok) {
                                throw new Error(`Ошибка при создании персонажа: ${response.status}`);
                            }

                            const character = await response.json();

                            // Создаём и добавляем нового персонажа
                            const newCharacter = createCharacterCard(character);
                            characterContainer.insertBefore(newCharacter, addCharacterButton);

                            updateCharacterCounter();

                            // Если достигли лимита, скрываем кнопку добавления
                            if (document.querySelectorAll('.character-card:not(.add-character)').length >= 16) {
                                addCharacterButton.style.display = "none";
                            }
                        } catch (error) {
                            console.error('Ошибка при добавлении персонажа:', error);
                            alert('Не удалось создать персонажа. Попробуйте ещё раз.');
                        }
                    });
                }

                // Удаление персонажа
                const deleteCharacter = async (id, element) => {
                    if (!confirm('Вы уверены, что хотите удалить этого персонажа?')) return;

                    try {
                        const response = await fetch(`/characters/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                            },
                        });

                        const data = await response.json();

                        if (!response.ok || !data.success) {
                            throw new Error(data.error || "Ошибка при удалении персонажа");
                        }

                        element.remove();
                        updateCharacterCounter();

                        // Показываем кнопку "Добавить", если персонажей < 16
                        if (addCharacterButton && document.querySelectorAll('.character-card:not(.add-character)').length < 16) {
                            addCharacterButton.style.display = "flex";
                        }
                    } catch (error) {
                        console.error('Ошибка при удалении персонажа:', error);
                        alert('Не удалось удалить персонажа. Попробуйте ещё раз.');
                    }
                };

                // Инициализация меню для существующих персонажей
                function initializeCharacterCards() {
                    document.querySelectorAll(".character-card").forEach(card => {
                        if (!card.classList.contains('add-character')) {
                            setupCharacterCardEvents(card);
                        }
                    });

                    // Закрываем меню при клике вне его
                    document.addEventListener("click", function () {
                        document.querySelectorAll(".menu").forEach(menu => menu.classList.remove("open"));
                    });

                    // Остановка всплытия для содержимого меню
                    document.querySelectorAll(".menu-content").forEach(menu => {
                        menu.addEventListener("click", function (e) {
                            e.stopPropagation();
                        });
                    });
                }

                // Инициализируем карточки при загрузке страницы
                document.addEventListener("DOMContentLoaded", initializeCharacterCards);
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
