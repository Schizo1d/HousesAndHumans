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
        <form id="attributesForm" action="{{ route('character_attributes.store', ['character' => $character->id]) }}" method="POST">
            @csrf
            <input type="hidden" name="character_id" value="{{ $character->id }}">

            <div class="attributes">
                <!-- Сила -->
                <div class="attribute-item">
                    <span onclick="openModal('strength')" style="cursor: pointer;">Сила:</span>
                    <a href="javascript:void(0);" id="strength-button" onclick="openModal('strength')" style="cursor: pointer;">
                        {{ $character->attributes->strength ?? 10 }}
                    </a>
                    <input type="hidden" id="strength" name="strength" value="{{ $character->attributes->strength ?? 10 }}">

                    <div class="sub-attributes">
                        <label>
                            <p class="skill-toggle" data-target="athletics">
                                Атлетика: <span id="athletics-value">+{{ $character->attributes->athletics ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="athletics" id="athletics" value="{{ $character->attributes->athletics ?? 0 }}">
                    </div>
                </div>

                <!-- Ловкость -->
                <div class="attribute-item">
                    <span onclick="openModal('dexterity')" style="cursor: pointer;">Ловкость:</span>
                    <a href="javascript:void(0);" id="dexterity-button" onclick="openModal('dexterity')" style="cursor: pointer;">
                        {{ $character->attributes->dexterity ?? 10 }}
                    </a>
                    <input type="hidden" id="dexterity" name="dexterity" value="{{ $character->attributes->dexterity ?? 10 }}">

                    <div class="sub-attributes">
                        <label>
                            <p class="skill-toggle" data-target="acrobatics">
                                Акробатика: <span id="acrobatics-value">+{{ $character->attributes->acrobatics ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="acrobatics" id="acrobatics" value="{{ $character->attributes->acrobatics ?? 0 }}">

                        <label>
                            <p class="skill-toggle" data-target="sleight-of-hand">
                                Ловкость рук: <span id="sleight-of-hand-value">+{{ $character->attributes->sleight_of_hand ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="sleight-of-hand" id="sleight-of-hand" value="{{ $character->attributes->sleight_of_hand ?? 0 }}">

                        <label>
                            <p class="skill-toggle" data-target="stealth">
                                Скрытность: <span id="stealth-value">+{{ $character->attributes->stealth ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="stealth" id="stealth" value="{{ $character->attributes->stealth ?? 0 }}">
                    </div>
                </div>

                <!-- Телосложение -->
                <div class="attribute-item">
                    <span onclick="openModal('constitution')" style="cursor: pointer;">Телосложение:</span>
                    <a href="javascript:void(0);" id="constitution-button" onclick="openModal('constitution')" style="cursor: pointer;">
                        {{ $character->attributes->constitution ?? 10 }}
                    </a>
                    <input type="hidden" id="constitution" name="constitution" value="{{ $character->attributes->constitution ?? 10 }}">
                </div>

                <!-- Интеллект -->
                <div class="attribute-item">
                    <span onclick="openModal('intelligence')" style="cursor: pointer;">Интеллект:</span>
                    <a href="javascript:void(0);" id="intelligence-button" onclick="openModal('intelligence')" style="cursor: pointer;">
                        {{ $character->attributes->intelligence ?? 10 }}
                    </a>
                    <input type="hidden" id="intelligence" name="intelligence" value="{{ $character->attributes->intelligence ?? 10 }}">

                    <div class="sub-attributes">
                        <label>
                            <p class="skill-toggle" data-target="analysis">
                                Анализ: <span id="analysis-value">+{{ $character->attributes->analysis ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="analysis" id="analysis" value="{{ $character->attributes->analysis ?? 0 }}">

                        <label>
                            <p class="skill-toggle" data-target="history">
                                История: <span id="history-value">+{{ $character->attributes->history ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="history" id="history" value="{{ $character->attributes->history ?? 0 }}">


                        <label>
                            <input type="radio" class="radio-toggle" data-target="arcana"> Магия
                        </label>
                        <span id="arcana-value">0</span>
                        <input type="hidden" name="arcana" id="arcana" value="0">
                        <label>
                            <input type="radio" class="radio-toggle" data-target="nature"> Природа
                        </label>
                        <span id="nature-value">0</span>
                        <input type="hidden" name="nature" id="nature" value="0">
                        <label>
                            <input type="radio" class="radio-toggle" data-target="religion"> Религия
                        </label>
                        <span id="religion-value">0</span>
                        <input type="hidden" name="religion" id="religion" value="0">
                    </div>
                </div>

                <!-- Мудрость -->
                <div class="attribute-item">
                    <span onclick="openModal('wisdom')" style="cursor: pointer;">Мудрость:</span>
                    <a href="javascript:void(0);" id="wisdom-button" onclick="openModal('wisdom')" style="cursor: pointer;">
                        {{ $character->attributes->wisdom ?? 10 }}
                    </a>
                    <input type="hidden" id="wisdom" name="wisdom" value="{{ $character->attributes->wisdom ?? 10 }}">

                    <div class="sub-attributes">
                        <label>
                            <input type="radio" class="radio-toggle" data-target="perception"> Восприятие
                        </label>
                        <span id="perception-value">0</span>
                        <input type="hidden" name="perception" id="perception" value="0">
                        <label>
                            <input type="radio" class="radio-toggle" data-target="survival"> Выживание
                        </label>
                        <span id="survival-value">0</span>
                        <input type="hidden" name="survival" id="survival" value="0">
                        <label>
                            <input type="radio" class="radio-toggle" data-target="medicine"> Медицина
                        </label>
                        <span id="medicine-value">0</span>
                        <input type="hidden" name="medicine" id="medicine" value="0">
                        <label>
                            <input type="radio" class="radio-toggle" data-target="insight"> Проницательность
                        </label>
                        <span id="insight-value">0</span>
                        <input type="hidden" name="insight" id="insight" value="0">
                        <label>
                            <input type="radio" class="radio-toggle" data-target="animal-handling"> Уход за животными
                        </label>
                        <span id="animal-handling-value">0</span>
                        <input type="hidden" name="animal-handling" id="animal-handling" value="0">
                    </div>
                </div>

                <!-- Харизма -->
                <div class="attribute-item">
                    <span onclick="openModal('charisma')" style="cursor: pointer;">Харизма:</span>
                    <a href="javascript:void(0);" id="charisma-button" onclick="openModal('charisma')" style="cursor: pointer;">
                        {{ $character->attributes->charisma ?? 10 }}
                    </a>
                    <input type="hidden" id="charisma" name="charisma" value="{{ $character->attributes->charisma ?? 10 }}">

                    <div class="sub-attributes">
                        <label>
                            <input type="radio" class="radio-toggle" data-target="performance"> Выступление
                        </label>
                        <span id="performance-value">0</span>
                        <input type="hidden" name="performance" id="performance" value="0">
                        <label>
                            <input type="radio" class="radio-toggle" data-target="intimidation"> Запугивание
                        </label>
                        <span id="intimidation-value">0</span>
                        <input type="hidden" name="intimidation" id="intimidation" value="0">
                        <label>
                            <input type="radio" class="radio-toggle" data-target="deception"> Обман
                        </label>
                        <span id="deception-value">0</span>
                        <input type="hidden" name="deception" id="deception" value="0">
                        <label>
                            <input type="radio" class="radio-toggle" data-target="persuasion"> Убеждение
                        </label>
                        <span id="persuasion-value">0</span>
                        <input type="hidden" name="persuasion" id="persuasion" value="0">
                    </div>
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

            const attributeNames = {
                strength: "Сила",
                dexterity: "Ловкость",
                constitution: "Телосложение",
                intelligence: "Интеллект",
                wisdom: "Мудрость",
                charisma: "Харизма"
            };

            // Открыть модальное окно для изменения значения атрибута
            function openModal(attr) {
                currentAttr = attr;
                let value = document.getElementById(attr).value;
                document.getElementById("modal-title").innerText = attributeNames[attr] || attr;
                document.getElementById("modal-input").value = value;
                document.getElementById("attributeModal").style.display = "flex";
            }

            // Закрыть модальное окно
            function closeModal() {
                document.getElementById("attributeModal").style.display = "none";
            }

            // Сохранить значение атрибута
            function saveAttribute() {
                let value = document.getElementById("modal-input").value;
                if (!currentAttr) return;

                document.getElementById(`${currentAttr}-button`).textContent = value;
                document.getElementById(currentAttr).value = value;

                closeModal();
            }

            // Обработчик для изменения значений радиокнопок навыков
            document.querySelectorAll('.skill-toggle').forEach(item => {
                item.addEventListener('click', function () {
                    let targetId = this.getAttribute('data-target');
                    let span = document.getElementById(targetId + "-value");
                    let input = document.getElementById(targetId);

                    let currentValue = parseInt(input.value);

                    // Логика циклического изменения значений: 0 → 2 → 4 → 0
                    let newValue = currentValue === 4 ? 0 : currentValue + 2;

                    span.innerText = `+${newValue}`;
                    input.value = newValue;
                });
            });

        </script>
</body>
</html>
