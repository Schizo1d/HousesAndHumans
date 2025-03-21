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

                    <button type="button" onclick="rollDice('strength')">Проверка<p id="strength-modifier" class="modifier">
                            ({{ floor(($character->attributes->strength ?? 10 - 10) / 2) }})
                        </p> </button>

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
                    <button type="button" onclick="rollDice('dexterity')">Проверка<p id="dexterity-modifier" class="modifier">
                            ({{ floor(($character->attributes->dexterity ?? 10 - 10) / 2) }})
                        </p></button>

                    <div class="sub-attributes">
                        <label>
                            <p class="skill-toggle" data-target="acrobatics">
                                Акробатика: <span id="acrobatics-value">+{{ $character->attributes->acrobatics ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="acrobatics" id="acrobatics" value="{{ $character->attributes->acrobatics ?? 0 }}">

                        <label>
                            <p class="skill-toggle" data-target="sleight_of_hand">
                                Ловкость рук: <span id="sleight_of_hand-value">+{{ $character->attributes->sleight_of_hand ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="sleight_of_hand" id="sleight_of_hand" value="{{ $character->attributes->sleight_of_hand ?? 0 }}">

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
                    <button type="button" onclick="rollDice('constitution')">Проверка<p id="constitution-modifier" class="modifier">
                            ({{ floor(($character->attributes->constitution ?? 10 - 10) / 2) }})
                        </p></button>
                </div>

                <!-- Интеллект -->
                <div class="attribute-item">
                    <span onclick="openModal('intelligence')" style="cursor: pointer;">Интеллект:</span>
                    <a href="javascript:void(0);" id="intelligence-button" onclick="openModal('intelligence')" style="cursor: pointer;">
                        {{ $character->attributes->intelligence ?? 10 }}
                    </a>
                    <input type="hidden" id="intelligence" name="intelligence" value="{{ $character->attributes->intelligence ?? 10 }}">
                    <button type="button" onclick="rollDice('intelligence')">Проверка<p id="intelligence-modifier" class="modifier">
                            ({{ floor(($character->attributes->intelligence ?? 10 - 10) / 2) }})
                        </p></button>

                    <div class="sub-attributes">
                        <label>
                            <p class="skill-toggle" data-target="investigation">
                                Анализ: <span id="investigation-value">+{{ $character->attributes->investigation ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="investigation" id="investigation" value="{{ $character->attributes->investigation ?? 0 }}">

                        <label>
                            <p class="skill-toggle" data-target="history">
                                История: <span id="history-value">+{{ $character->attributes->history ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="history" id="history" value="{{ $character->attributes->history ?? 0 }}">

                        <label>
                            <p class="skill-toggle" data-target="arcana">
                                Магия: <span id="arcana-value">+{{ $character->attributes->arcana ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="arcana" id="arcana" value="{{ $character->attributes->arcana ?? 0 }}">

                        <label>
                            <p class="skill-toggle" data-target="nature">
                                Природа: <span id="nature-value">+{{ $character->attributes->nature ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="nature" id="nature" value="{{ $character->attributes->nature ?? 0 }}">

                        <label>
                            <p class="skill-toggle" data-target="religion">
                                Религия: <span id="religion-value">+{{ $character->attributes->religion ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="religion" id="religion" value="{{ $character->attributes->religion ?? 0 }}">
                    </div>
                </div>

                <!-- Мудрость -->
                <div class="attribute-item">
                    <span onclick="openModal('wisdom')" style="cursor: pointer;">Мудрость:</span>
                    <a href="javascript:void(0);" id="wisdom-button" onclick="openModal('wisdom')" style="cursor: pointer;">
                        {{ $character->attributes->wisdom ?? 10 }}
                    </a>
                    <input type="hidden" id="wisdom" name="wisdom" value="{{ $character->attributes->wisdom ?? 10 }}">
                    <button type="button" onclick="rollDice('wisdom')">Проверка<p id="wisdom-modifier" class="modifier">
                            ({{ floor(($character->attributes->wisdom ?? 10 - 10) / 2) }})
                        </p></button>

                    <div class="sub-attributes">
                        <label>
                            <p class="skill-toggle" data-target="perception">
                                Восприятие: <span id="perception-value">+{{ $character->attributes->perception ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="perception" id="perception" value="{{ $character->attributes->perception ?? 0 }}">

                        <label>
                            <p class="skill-toggle" data-target="survival">
                                Выживание: <span id="survival-value">+{{ $character->attributes->survival ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="survival" id="survival" value="{{ $character->attributes->survival ?? 0 }}">

                        <label>
                            <p class="skill-toggle" data-target="medicine">
                                Медицина: <span id="medicine-value">+{{ $character->attributes->medicine ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="medicine" id="medicine" value="{{ $character->attributes->medicine ?? 0 }}">

                        <label>
                            <p class="skill-toggle" data-target="insight">
                                Проницательность: <span id="insight-value">+{{ $character->attributes->insight ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="insight" id="insight" value="{{ $character->attributes->insight ?? 0 }}">

                        <label>
                            <p class="skill-toggle" data-target="animal_handling">
                                Уход за животными: <span id="animal_handling-value">+{{ $character->attributes->animal_handling ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="animal_handling" id="animal_handling" value="{{ $character->attributes->animal_handling ?? 0 }}">
                    </div>
                </div>

                <!-- Харизма -->
                <div class="attribute-item">
                    <span onclick="openModal('charisma')" style="cursor: pointer;">Харизма:</span>
                    <a href="javascript:void(0);" id="charisma-button" onclick="openModal('charisma')" style="cursor: pointer;">
                        {{ $character->attributes->charisma ?? 10 }}
                    </a>
                    <input type="hidden" id="charisma" name="charisma" value="{{ $character->attributes->charisma ?? 10 }}">
                    <button type="button" onclick="rollDice('charisma')">Проверка<p id="charisma-modifier" class="modifier">
                            ({{ floor(($character->attributes->charisma ?? 10 - 10) / 2) }})
                        </p></button>

                    <div class="sub-attributes">
                        <label>
                            <p class="skill-toggle" data-target="performance">
                                Выступление: <span id="performance-value">+{{ $character->attributes->performance ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="performance" id="performance" value="{{ $character->attributes->performance ?? 0 }}">

                        <label>
                            <p class="skill-toggle" data-target="intimidation">
                                Запугивание: <span id="intimidation-value">+{{ $character->attributes->intimidation ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="intimidation" id="intimidation" value="{{ $character->attributes->intimidation ?? 0 }}">

                        <label>
                            <p class="skill-toggle" data-target="deception">
                                Обман: <span id="deception-value">+{{ $character->attributes->deception ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="deception" id="deception" value="{{ $character->attributes->deception ?? 0 }}">

                        <label>
                            <p class="skill-toggle" data-target="persuasion">
                                Убеждение: <span id="persuasion-value">+{{ $character->attributes->persuasion ?? 0 }}</span>
                            </p>
                        </label>
                        <input type="hidden" name="persuasion" id="persuasion" value="{{ $character->attributes->persuasion ?? 0 }}">
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


            // Функция расчета модификатора атрибута (по правилам D&D)
            function getModifier(attributeValue) {
                return Math.floor((attributeValue - 10) / 2);
            }

            // Обновить навыки при изменении атрибута
            function updateSkills(attribute) {
                let attrValue = parseInt(document.getElementById(attribute).value);
                let modifier = getModifier(attrValue);

                let skills = {
                    strength: ["athletics"],
                    dexterity: ["acrobatics", "sleight_of_hand", "stealth"],
                    intelligence: ["investigation", "history", "arcana", "nature", "religion"],
                    wisdom: ["perception", "survival", "medicine", "insight", "animal_handling"],
                    charisma: ["performance", "intimidation", "deception", "persuasion"]
                };

                if (skills[attribute]) {
                    skills[attribute].forEach(skill => {
                        let skillValue = parseInt(document.getElementById(skill).value); // Бонус навыка
                        let finalValue = modifier + skillValue; // Модификатор атрибута + бонус навыка

                        document.getElementById(skill + "-value").innerText = finalValue >= 0 ? `+${finalValue}` : finalValue;
                    });
                }
            }

            // Обработчик клика по навыкам (увеличение циклически)
            document.querySelectorAll('.skill-toggle').forEach(item => {
                item.addEventListener('click', function () {
                    let targetId = this.getAttribute('data-target');
                    let span = document.getElementById(targetId + "-value");
                    let input = document.getElementById(targetId);

                    let currentValue = parseInt(input.value);
                    let newValue = currentValue === 4 ? 0 : currentValue + 2;

                    input.value = newValue;

                    // Найти, к какому атрибуту относится навык
                    let attribute = Object.keys(attributeNames).find(attr =>
                        document.getElementById(attr) && this.closest('.attribute-item').contains(document.getElementById(attr))
                    );

                    let attributeValue = parseInt(document.getElementById(attribute).value);
                    let modifier = getModifier(attributeValue);
                    let finalValue = modifier + newValue;

                    span.innerText = finalValue >= 0 ? `+${finalValue}` : finalValue;
                });
            });

            function rollDice(attribute) {
                let value = parseInt(document.getElementById(attribute).value);
                let modifier = Math.floor((value - 10) / 2);
                let roll = Math.floor(Math.random() * 20) + 1;
                let total = roll + modifier;
                alert(`Результат броска: ${roll} + ${modifier} = ${total}`);
            }

            function updateModifier(attribute) {
                let attrValue = parseInt(document.getElementById(attribute).value);
                let modifier = getModifier(attrValue);
                document.getElementById(`${attribute}-modifier`).textContent = `(${modifier})`;
            }

            function saveAttribute() {
                let value = parseInt(document.getElementById("modal-input").value);
                if (!currentAttr) return;

                document.getElementById(`${currentAttr}-button`).textContent = value;
                document.getElementById(currentAttr).value = value;

                updateModifier(currentAttr);
                updateSkills(currentAttr);

                closeModal();
            }

            document.addEventListener("DOMContentLoaded", function () {
                Object.keys(attributeNames).forEach(attr => updateModifier(attr));
            });
        </script>
</body>
</html>
