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
        <form id="attributesForm" action="{{ route('character_attributes.store', ['character' => $character->id]) }}"
              method="POST">
            @csrf
            <input type="hidden" name="character_id" value="{{ $character->id }}">

            <div class="attributes">
                <div class="attribute-item">
                    <span onclick="openModal('strength')" style="cursor: pointer;">Сила:</span>
                    <a href="javascript:void(0);" id="strength-button" onclick="openModal('strength')" style="cursor: pointer;">
                        {{ $character->attributes->strength ?? 10 }}
                    </a>
                    <input type="hidden" id="strength" name="strength" value="{{ $character->attributes->strength ?? 10 }}">
                </div>

                <div class="attribute-item">
                    <span onclick="openModal('dexterity')" style="cursor: pointer;">Ловкость:</span>
                    <a href="javascript:void(0);" id="dexterity-button" onclick="openModal('dexterity')" style="cursor: pointer;">
                        {{ $character->attributes->dexterity ?? 10 }}
                    </a>
                    <input type="hidden" id="dexterity" name="dexterity" value="{{ $character->attributes->dexterity ?? 10 }}">
                </div>

                <div class="attribute-item">
                    <span onclick="openModal('constitution')" style="cursor: pointer;">Телосложение:</span>
                    <a href="javascript:void(0);" id="constitution-button" onclick="openModal('constitution')" style="cursor: pointer;">
                        {{ $character->attributes->constitution ?? 10 }}
                    </a>
                    <input type="hidden" id="constitution" name="constitution" value="{{ $character->attributes->constitution ?? 10 }}">
                </div>

                <div class="attribute-item">
                    <span onclick="openModal('intelligence')" style="cursor: pointer;">Интеллект:</span>
                    <a href="javascript:void(0);" id="intelligence-button" onclick="openModal('intelligence')" style="cursor: pointer;">
                        {{ $character->attributes->intelligence ?? 10 }}
                    </a>
                    <input type="hidden" id="intelligence" name="intelligence" value="{{ $character->attributes->intelligence ?? 10 }}">
                </div>

                <div class="attribute-item">
                    <span onclick="openModal('wisdom')" style="cursor: pointer;">Мудрость:</span>
                    <a href="javascript:void(0);" id="wisdom-button" onclick="openModal('wisdom')" style="cursor: pointer;">
                        {{ $character->attributes->wisdom ?? 10 }}
                    </a>
                    <input type="hidden" id="wisdom" name="wisdom" value="{{ $character->attributes->wisdom ?? 10 }}">
                </div>

                <div class="attribute-item">
                    <span onclick="openModal('charisma')" style="cursor: pointer;">Харизма:</span>
                    <a href="javascript:void(0);" id="charisma-button" onclick="openModal('charisma')" style="cursor: pointer;">
                        {{ $character->attributes->charisma ?? 10 }}
                    </a>
                    <input type="hidden" id="charisma" name="charisma" value="{{ $character->attributes->charisma ?? 10 }}">
                </div>
            </div>

            <button type="submit">Сохранить атрибуты</button>
        </form>

        <!-- Модальное окно -->
        <div id="attributeModal" class="modal" style="display: none;">
            <div class="modal-content">
                <button class="modal-close-btn" onclick="closeModal()">✖</button>
                <h3 id="modal-title"></h3>
                <input type="number" id="modal-input" min="1" max="30">
                <button class="modal-save-btn" onclick="saveAttribute()">Сохранить</button>
            </div>
        </div>

        <script>
            let currentAttr = null;

            // Названия атрибутов для отображения
            const attributeNames = {
                strength: "Сила",
                dexterity: "Ловкость",
                constitution: "Телосложение",
                intelligence: "Интеллект",
                wisdom: "Мудрость",
                charisma: "Харизма"
            };

            function openModal(attr) {
                currentAttr = attr;
                let value = document.getElementById(attr).value;

                // Устанавливаем заголовок модального окна
                document.getElementById("modal-title").innerText = (attributeNames[attr] || attr);
                document.getElementById("modal-input").value = value;
                document.getElementById("attributeModal").style.display = "flex";
            }

            function closeModal() {
                document.getElementById("attributeModal").style.display = "none";
            }

            function saveAttribute() {
                let value = document.getElementById("modal-input").value;
                if (!currentAttr) return;

                // Обновляем кнопку
                document.getElementById(`${currentAttr}-button`).textContent = value;

                // Обновляем скрытый input
                document.getElementById(currentAttr).value = value;

                closeModal();
            }
        </script>
</body>
</html>
