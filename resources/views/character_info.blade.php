<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="character-id" content="{{ $character->id }}">
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
<div class="header-two">
    <div class="container">
        <nav class="nav">
            <div class="character-nav">
                <div class="character-photo" id="character-avatar">
                    <img src="{{ $character->photo ?? asset('img/avatar.png') }}" alt="Персонаж"
                         class="character-photo-img">
                    <div class="dropdown-menu" id="character-dropdown">
                        <button class="dropdown-item" id="settings-btn">Настройки</button>
                    </div>
                </div>
                <div class="character-name">
                    <h2>{{ $character->name }}</h2>
                </div>
            </div>
        </nav>
    </div>
</div>
<main>
    <div class="container-info">
        <form id="attributesForm" action="{{ route('character_attributes.store', ['character' => $character->id]) }}"
              method="POST">
            @csrf
            <input type="hidden" name="character_id" value="{{ $character->id }}">

            <div class="attributes">
                <!-- Сила -->
                <div class="attribute-item">
                    <div class="attribute-main-stat">
                        <a href="javascript:void(0);" class="attribute-link" onclick="openModal('strength')">
                            <span class="attribute-name">Сила</span>
                            <div class="line"></div>
                            <span class="attribute-value" id="strength-button">
                                {{ $character->attributes->strength ?? 10 }}
                            </span>
                        </a>
                        <input type="hidden" id="strength" name="strength"
                               value="{{ $character->attributes->strength ?? 10 }}">
                    </div>
                    <div class="attribute-checks">
                        <!-- Блок для проверки -->
                        <div class="check-block">
                            <div class="attribute-skill-wrap">
                                <a href="#" class="check-link"
                                   onclick="openModal('strength'); return false;">Проверка</a>
                            </div>
                            <button type="button" class="dice-roll-button"
                                    onclick="rollDice('strength'); return false;">
            <span id="strength-modifier" class="modifier">
                {{ floor(($character->attributes->strength ?? 10 - 10) / 2) }}
            </span>
                            </button>
                        </div>

                        <!-- Блок для спасброска -->
                        <div class="save-block">
                            <div class="attribute-skill-wrap">
                                <a href="#" class="save-link"
                                   onclick="openModal('strength'); return false;">Спасбросок</a>
                            </div>
                            <button type="button" class="dice-roll-button"
                                    onclick="rollSave('strength'); return false;">
            <span id="strength-save-modifier" class="modifier">
                {{ floor(($character->attributes->strength ?? 10 - 10) / 2) }}
            </span>
                            </button>
                        </div>
                    </div>
                    <div class="sub-attributes">
                        <div class="attribute-skill">
                            <a href="javascript:void(0);" class="attribute-skill-name" data-target="athletics"
                               onclick="toggleSkill(this)">
                                Атлетика
                            </a>
                            <button type="button" class="dice-roll-button" id="athletics-button"
                                    onclick="document.querySelector('[data-target=athletics]').click()">
                                <span id="athletics-value">{{ $character->attributes->athletics ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="athletics" id="athletics"
                               value="{{ $character->attributes->athletics ?? 0 }}">
                    </div>
                </div>

                <!-- Ловкость -->
                <div class="attribute-item">
                    <div class="attribute-main-stat">
                        <a href="javascript:void(0);" class="attribute-link" onclick="openModal('dexterity')">
                            <span class="attribute-name">Ловкость</span>
                            <div class="line"></div>
                            <span class="attribute-value" id="dexterity-button">
                {{ $character->attributes->dexterity ?? 10 }}
            </span>
                        </a>
                        <input type="hidden" id="dexterity" name="dexterity"
                               value="{{ $character->attributes->dexterity ?? 10 }}">
                    </div>
                    <div class="attribute-checks">
                        <!-- Блок для проверки -->
                        <div class="check-block">
                            <div class="attribute-skill-wrap">
                                <a href="#" class="check-link" onclick="openModal('dexterity'); return false;">Проверка</a>
                            </div>
                            <button type="button" class="dice-roll-button" onclick="rollDice('dexterity'); return false;">
                <span id="dexterity-modifier" class="modifier">
                    {{ floor(($character->attributes->dexterity ?? 10 - 10) / 2) }}
                </span>
                            </button>
                        </div>

                        <!-- Блок для спасброска -->
                        <div class="save-block">
                            <div class="attribute-skill-wrap">
                                <a href="#" class="save-link" onclick="openModal('dexterity'); return false;">Спасбросок</a>
                            </div>
                            <button type="button" class="dice-roll-button" onclick="rollSave('dexterity'); return false;">
                <span id="dexterity-save-modifier" class="modifier">
                    {{ floor(($character->attributes->dexterity ?? 10 - 10) / 2) }}
                </span>
                            </button>
                        </div>
                    </div>
                    <div class="sub-attributes">
                        <div class="attribute-skill">
                            <a href="javascript:void(0);" class="attribute-skill-name" data-target="acrobatics" onclick="toggleSkill(this)">
                                Акробатика
                            </a>
                            <button type="button" class="dice-roll-button" id="acrobatics-button"
                                    onclick="document.querySelector('[data-target=acrobatics]').click()">
                                <span id="acrobatics-value">{{ $character->attributes->acrobatics ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="acrobatics" id="acrobatics"
                               value="{{ $character->attributes->acrobatics ?? 0 }}">

                        <div class="attribute-skill">
                            <a href="javascript:void(0);" class="attribute-skill-name" data-target="sleight_of_hand" onclick="toggleSkill(this)">
                                Ловкость рук
                            </a>
                            <button type="button" class="dice-roll-button" id="sleight_of_hand-button"
                                    onclick="document.querySelector('[data-target=sleight_of_hand]').click()">
                                <span id="sleight_of_hand-value">{{ $character->attributes->sleight_of_hand ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="sleight_of_hand" id="sleight_of_hand"
                               value="{{ $character->attributes->sleight_of_hand ?? 0 }}">

                        <div class="attribute-skill">
                            <a href="javascript:void(0);" class="attribute-skill-name" data-target="stealth" onclick="toggleSkill(this)">
                                Скрытность
                            </a>
                            <button type="button" class="dice-roll-button" id="stealth-button"
                                    onclick="document.querySelector('[data-target=stealth]').click()">
                                <span id="stealth-value">{{ $character->attributes->stealth ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="stealth" id="stealth"
                               value="{{ $character->attributes->stealth ?? 0 }}">
                    </div>
                </div>

                <!-- Телосложение -->
                <div class="attribute-item">
                    <div class="attribute-main-stat">
                        <a href="javascript:void(0);" class="attribute-link" onclick="openModal('constitution')">
                            <span class="attribute-name">Телосложение</span>
                            <div class="line"></div>
                            <span class="attribute-value" id="constitution-button">
                {{ $character->attributes->constitution ?? 10 }}
            </span>
                        </a>
                        <input type="hidden" id="constitution" name="constitution"
                               value="{{ $character->attributes->constitution ?? 10 }}">
                    </div>
                    <div class="attribute-checks">
                        <!-- Блок для проверки -->
                        <div class="check-block">
                            <div class="attribute-skill-wrap">
                                <a href="#" class="check-link" onclick="openModal('constitution'); return false;">Проверка</a>
                            </div>
                            <button type="button" class="dice-roll-button" onclick="rollDice('constitution'); return false;">
                <span id="constitution-modifier" class="modifier">
                    {{ floor(($character->attributes->constitution ?? 10 - 10) / 2) }}
                </span>
                            </button>
                        </div>

                        <!-- Блок для спасброска -->
                        <div class="save-block">
                            <div class="attribute-skill-wrap">
                                <a href="#" class="save-link" onclick="openModal('constitution'); return false;">Спасбросок</a>
                            </div>
                            <button type="button" class="dice-roll-button" onclick="rollSave('constitution'); return false;">
                <span id="constitution-save-modifier" class="modifier">
                    {{ floor(($character->attributes->constitution ?? 10 - 10) / 2) }}
                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Интеллект -->
                <div class="attribute-item">
                    <div class="attribute-main-stat">
                        <a href="javascript:void(0);" class="attribute-link" onclick="openModal('intelligence')">
                            <span class="attribute-name">Интеллект</span>
                            <div class="line"></div>
                            <span class="attribute-value" id="intelligence-button">
                {{ $character->attributes->intelligence ?? 10 }}
            </span>
                        </a>
                        <input type="hidden" id="intelligence" name="intelligence"
                               value="{{ $character->attributes->intelligence ?? 10 }}">
                    </div>
                    <div class="attribute-checks">
                        <!-- Блок для проверки -->
                        <div class="check-block">
                            <div class="attribute-skill-wrap">
                                <a href="#" class="check-link" onclick="openModal('intelligence'); return false;">Проверка</a>
                            </div>
                            <button type="button" class="dice-roll-button" onclick="rollDice('intelligence'); return false;">
                <span id="intelligence-modifier" class="modifier">
                    {{ floor(($character->attributes->intelligence ?? 10 - 10) / 2) }}
                </span>
                            </button>
                        </div>

                        <!-- Блок для спасброска -->
                        <div class="save-block">
                            <div class="attribute-skill-wrap">
                                <a href="#" class="save-link" onclick="openModal('intelligence'); return false;">Спасбросок</a>
                            </div>
                            <button type="button" class="dice-roll-button" onclick="rollSave('intelligence'); return false;">
                <span id="intelligence-save-modifier" class="modifier">
                    {{ floor(($character->attributes->intelligence ?? 10 - 10) / 2) }}
                </span>
                            </button>
                        </div>
                    </div>
                    <div class="sub-attributes">
                        <div class="attribute-skill">
                            <a href="javascript:void(0);" class="attribute-skill-name" data-target="investigation" onclick="toggleSkill(this)">
                                Анализ
                            </a>
                            <button type="button" class="dice-roll-button" id="investigation-button"
                                    onclick="document.querySelector('[data-target=investigation]').click()">
                                <span id="investigation-value">{{ $character->attributes->investigation ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="investigation" id="investigation"
                               value="{{ $character->attributes->investigation ?? 0 }}">

                        <div class="attribute-skill">
                            <a href="javascript:void(0);" class="attribute-skill-name" data-target="history" onclick="toggleSkill(this)">
                                История
                            </a>
                            <button type="button" class="dice-roll-button" id="history-button"
                                    onclick="document.querySelector('[data-target=history]').click()">
                                <span id="history-value">{{ $character->attributes->history ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="history" id="history"
                               value="{{ $character->attributes->history ?? 0 }}">

                        <div class="attribute-skill">
                            <a href="javascript:void(0);" class="attribute-skill-name" data-target="arcana" onclick="toggleSkill(this)">
                                Магия
                            </a>
                            <button type="button" class="dice-roll-button" id="arcana-button"
                                    onclick="document.querySelector('[data-target=arcana]').click()">
                                <span id="arcana-value">{{ $character->attributes->arcana ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="arcana" id="arcana"
                               value="{{ $character->attributes->arcana ?? 0 }}">

                        <div class="attribute-skill">
                            <a href="javascript:void(0);" class="attribute-skill-name" data-target="nature" onclick="toggleSkill(this)">
                                Природа
                            </a>
                            <button type="button" class="dice-roll-button" id="nature-button"
                                    onclick="document.querySelector('[data-target=nature]').click()">
                                <span id="nature-value">{{ $character->attributes->nature ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="nature" id="nature"
                               value="{{ $character->attributes->nature ?? 0 }}">

                        <div class="attribute-skill">
                            <a href="javascript:void(0);" class="attribute-skill-name" data-target="religion" onclick="toggleSkill(this)">
                                Религия
                            </a>
                            <button type="button" class="dice-roll-button" id="religion-button"
                                    onclick="document.querySelector('[data-target=religion]').click()">
                                <span id="religion-value">{{ $character->attributes->religion ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="religion" id="religion"
                               value="{{ $character->attributes->religion ?? 0 }}">
                    </div>
                </div>

                <!-- Мудрость -->
                <div class="attribute-item">
                    <div class="attribute-main-stat">
                        <a href="javascript:void(0);" class="attribute-link" onclick="openModal('wisdom')">
                            <span class="attribute-name">Мудрость</span>
                            <div class="line"></div>
                            <span class="attribute-value" id="wisdom-button">
                {{ $character->attributes->wisdom ?? 10 }}
            </span>
                        </a>
                        <input type="hidden" id="wisdom" name="wisdom"
                               value="{{ $character->attributes->wisdom ?? 10 }}">
                    </div>
                    <div class="attribute-checks">
                        <!-- Блок для проверки -->
                        <div class="check-block">
                            <div class="attribute-skill-wrap">
                                <a href="#" class="check-link" onclick="openModal('wisdom'); return false;">Проверка</a>
                            </div>
                            <button type="button" class="dice-roll-button" onclick="rollDice('wisdom'); return false;">
                <span id="wisdom-modifier" class="modifier">
                    {{ floor(($character->attributes->wisdom ?? 10 - 10) / 2) }}
                </span>
                            </button>
                        </div>

                        <!-- Блок для спасброска -->
                        <div class="save-block">
                            <div class="attribute-skill-wrap">
                                <a href="#" class="save-link" onclick="openModal('wisdom'); return false;">Спасбросок</a>
                            </div>
                            <button type="button" class="dice-roll-button" onclick="rollSave('wisdom'); return false;">
                <span id="wisdom-save-modifier" class="modifier">
                    {{ floor(($character->attributes->wisdom ?? 10 - 10) / 2) }}
                </span>
                            </button>
                        </div>
                    </div>
                    <div class="sub-attributes">
                        <div class="attribute-skill">
                            <a href="javascript:void(0);" class="attribute-skill-name" data-target="perception" onclick="toggleSkill(this)">
                                Восприятие
                            </a>
                            <button type="button" class="dice-roll-button" id="perception-button"
                                    onclick="document.querySelector('[data-target=perception]').click()">
                                <span id="perception-value">{{ $character->attributes->perception ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="perception" id="perception"
                               value="{{ $character->attributes->perception ?? 0 }}">

                        <div class="attribute-skill">
                            <a href="javascript:void(0);" class="attribute-skill-name" data-target="survival" onclick="toggleSkill(this)">
                                Выживание
                            </a>
                            <button type="button" class="dice-roll-button" id="survival-button"
                                    onclick="document.querySelector('[data-target=survival]').click()">
                                <span id="survival-value">{{ $character->attributes->survival ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="survival" id="survival"
                               value="{{ $character->attributes->survival ?? 0 }}">

                        <div class="attribute-skill">
                            <a href="javascript:void(0);" class="attribute-skill-name" data-target="medicine" onclick="toggleSkill(this)">
                                Медицина
                            </a>
                            <button type="button" class="dice-roll-button" id="medicine-button"
                                    onclick="document.querySelector('[data-target=medicine]').click()">
                                <span id="medicine-value">{{ $character->attributes->medicine ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="medicine" id="medicine"
                               value="{{ $character->attributes->medicine ?? 0 }}">

                        <div class="attribute-skill">
                            <a href="javascript:void(0);" class="attribute-skill-name" data-target="insight" onclick="toggleSkill(this)">
                                Проницательность
                            </a>
                            <button type="button" class="dice-roll-button" id="insight-button"
                                    onclick="document.querySelector('[data-target=insight]').click()">
                                <span id="insight-value">{{ $character->attributes->insight ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="insight" id="insight"
                               value="{{ $character->attributes->insight ?? 0 }}">

                        <div class="attribute-skill">
                            <a href="javascript:void(0);" class="attribute-skill-name" data-target="animal_handling" onclick="toggleSkill(this)">
                                Уход за животными
                            </a>
                            <button type="button" class="dice-roll-button" id="animal_handling-button"
                                    onclick="document.querySelector('[data-target=animal_handling]').click()">
                                <span id="animal_handling-value">{{ $character->attributes->animal_handling ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="animal_handling" id="animal_handling"
                               value="{{ $character->attributes->animal_handling ?? 0 }}">
                    </div>
                </div>

                <!-- Харизма -->
                <div class="attribute-item">
                    <div class="attribute-main-stat">
                        <a href="javascript:void(0);" class="attribute-link" onclick="openModal('charisma')">
                            <span class="attribute-name">Харизма</span>
                            <div class="line"></div>
                            <span class="attribute-value" id="charisma-button">
                {{ $character->attributes->charisma ?? 10 }}
            </span>
                        </a>
                        <input type="hidden" id="charisma" name="charisma"
                               value="{{ $character->attributes->charisma ?? 10 }}">
                    </div>
                    <div class="attribute-checks">
                        <!-- Блок для проверки -->
                        <div class="check-block">
                            <div class="attribute-skill-wrap">
                                <a href="#" class="check-link" onclick="openModal('charisma'); return false;">Проверка</a>
                            </div>
                            <button type="button" class="dice-roll-button" onclick="rollDice('charisma'); return false;">
                <span id="charisma-modifier" class="modifier">
                    {{ floor(($character->attributes->charisma ?? 10 - 10) / 2) }}
                </span>
                            </button>
                        </div>

                        <!-- Блок для спасброска -->
                        <div class="save-block">
                            <div class="attribute-skill-wrap">
                                <a href="#" class="save-link" onclick="openModal('charisma'); return false;">Спасбросок</a>
                            </div>
                            <button type="button" class="dice-roll-button" onclick="rollSave('charisma'); return false;">
                <span id="charisma-save-modifier" class="modifier">
                    {{ floor(($character->attributes->charisma ?? 10 - 10) / 2) }}
                </span>
                            </button>
                        </div>
                    </div>
                    <div class="sub-attributes">
                        <div class="attribute-skill">
                            <a href="javascript:void(0);" class="attribute-skill-name" data-target="performance" onclick="toggleSkill(this)">
                                Выступление
                            </a>
                            <button type="button" class="dice-roll-button" id="performance-button"
                                    onclick="document.querySelector('[data-target=performance]').click()">
                                <span id="performance-value">{{ $character->attributes->performance ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="performance" id="performance"
                               value="{{ $character->attributes->performance ?? 0 }}">

                        <div class="attribute-skill">
                            <a href="javascript:void(0);" class="attribute-skill-name" data-target="intimidation" onclick="toggleSkill(this)">
                                Запугивание
                            </a>
                            <button type="button" class="dice-roll-button" id="intimidation-button"
                                    onclick="document.querySelector('[data-target=intimidation]').click()">
                                <span id="intimidation-value">{{ $character->attributes->intimidation ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="intimidation" id="intimidation"
                               value="{{ $character->attributes->intimidation ?? 0 }}">

                        <div class="attribute-skill">
                            <a href="javascript:void(0);" class="attribute-skill-name" data-target="deception" onclick="toggleSkill(this)">
                                Обман
                            </a>
                            <button type="button" class="dice-roll-button" id="deception-button"
                                    onclick="document.querySelector('[data-target=deception]').click()">
                                <span id="deception-value">{{ $character->attributes->deception ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="deception" id="deception"
                               value="{{ $character->attributes->deception ?? 0 }}">

                        <div class="attribute-skill">
                            <a href="javascript:void(0);" class="attribute-skill-name" data-target="persuasion" onclick="toggleSkill(this)">
                                Убеждение
                            </a>
                            <button type="button" class="dice-roll-button" id="persuasion-button"
                                    onclick="document.querySelector('[data-target=persuasion]').click()">
                                <span id="persuasion-value">{{ $character->attributes->persuasion ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="persuasion" id="persuasion"
                               value="{{ $character->attributes->persuasion ?? 0 }}">
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


            // Функция расчета модификатора атрибута (по правилам D&D)
            function getModifier(attributeValue) {
                return Math.floor((attributeValue - 10) / 2);
            }


            document.querySelectorAll('.skill-toggle').forEach(item => {
                item.addEventListener('click', function () {
                    let targetId = this.getAttribute('data-target');
                    let span = document.getElementById(targetId + "-value");
                    let input = document.getElementById(targetId);

                    // Циклически меняем бонус владения: 0 -> 2 -> 4 -> 0
                    let currentValue = parseInt(input.value);
                    let newValue = currentValue === 4 ? 0 : currentValue + 2;
                    input.value = newValue;

                    // Найти родительский атрибут
                    let attribute = Object.keys(attributeNames).find(attr =>
                        document.getElementById(attr) && this.closest('.attribute-item').contains(document.getElementById(attr))
                    );

                    let attributeValue = parseInt(document.getElementById(attribute).value);
                    let modifier = getModifier(attributeValue);
                    let finalValue = modifier + newValue;

                    // Отображаем итоговое значение (модификатор + бонус)
                    span.innerText = finalValue;
                });
            });
            document.addEventListener("DOMContentLoaded", function () {
                Object.keys(attributeNames).forEach(attr => {
                    updateModifier(attr);
                    updateSkills(attr);
                });
            });

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
                        let skillBonus = parseInt(document.getElementById(skill).value);
                        let finalValue = modifier + skillBonus;
                        document.getElementById(skill + "-value").innerText = finalValue;
                    });
                }
            }

            function toggleSkill(element) {
                const targetId = element.getAttribute('data-target');
                const span = document.getElementById(targetId + "-value");
                const input = document.getElementById(targetId);

                // Циклическое изменение значения: 0 → 2 → 4 → 0
                let currentValue = parseInt(input.value);
                let newValue = currentValue === 4 ? 0 : currentValue + 2;
                input.value = newValue;

                // Находим связанный атрибут
                const attribute = Object.keys(attributeNames).find(attr =>
                    element.closest('.attribute-item').contains(document.getElementById(attr))
                );

                // Рассчитываем итоговое значение
                const attributeValue = parseInt(document.getElementById(attribute).value);
                const modifier = Math.floor((attributeValue - 10) / 2);
                const finalValue = modifier + newValue;

                // Обновляем отображение
                span.textContent = finalValue;
            }

            function rollDice(attribute) {
                let value = parseInt(document.getElementById(attribute).value);
                let modifier = Math.floor((value - 10) / 2);
                let roll = Math.floor(Math.random() * 20) + 1;
                let total = roll + modifier;
                showCustomAlert(`Результат броска: ${roll} + ${modifier} = ${total}`);
            }

            function rollSave(attribute) {
                let value = parseInt(document.getElementById(attribute).value);
                let modifier = Math.floor((value - 10) / 2);
                let roll = Math.floor(Math.random() * 20) + 1;
                let total = roll + modifier;
                showCustomAlert(`Результат спасброска: ${roll} + ${modifier} = ${total}`);
            }

            function updateModifier(attribute) {
                let attrValue = parseInt(document.getElementById(attribute).value);
                let modifier = getModifier(attrValue);
                document.getElementById(`${attribute}-modifier`).textContent = modifier;
                document.getElementById(`${attribute}-save-modifier`).textContent = modifier;
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
            document.addEventListener("DOMContentLoaded", function () {
                const characterAvatar = document.getElementById("character-avatar");
                const dropdown = document.getElementById("character-dropdown");

                characterAvatar.addEventListener("click", function (event) {
                    event.stopPropagation();
                    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
                });

                document.addEventListener("click", function () {
                    dropdown.style.display = "none";
                });

                dropdown.addEventListener("click", function (event) {
                    event.stopPropagation();
                });
            });
            document.addEventListener("DOMContentLoaded", function () {
                const settingsBtn = document.getElementById("settings-btn");
                const sidebarModal = document.getElementById("settings-modal");
                const closeSidebar = document.getElementById("close-sidebar");

                settingsBtn.addEventListener("click", function () {
                    sidebarModal.classList.add("show");
                });

                closeSidebar.addEventListener("click", function () {
                    sidebarModal.classList.remove("show");
                });

                document.addEventListener("click", function (event) {
                    if (!sidebarModal.contains(event.target) && !settingsBtn.contains(event.target)) {
                        sidebarModal.classList.remove("show");
                    }
                });
            });
            document.addEventListener("DOMContentLoaded", function () {
                const nameInput = document.getElementById("character-name-input");
                const saveButton = document.getElementById("save-character-name");
                const saveMessage = document.getElementById("save-message");
                const characterNameElement = document.querySelector(".character-name h2");

                saveButton.addEventListener("click", function () {
                    const newName = nameInput.value.trim();

                    // Проверка, чтобы имя не было пустым
                    if (newName === "") {
                        alert("Имя не может быть пустым!");
                        return;
                    }

                    // ID персонажа
                    const characterId = document.querySelector('meta[name="character-id"]').getAttribute("content");

                    // Отправляем запрос
                    fetch("/character/update-name", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: JSON.stringify({name: newName, character_id: characterId})
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                characterNameElement.textContent = data.newName; // Меняем имя на странице
                                saveMessage.textContent = "Имя сохранено!";
                                saveMessage.style.color = "#28a745"; // Зеленый цвет успеха
                            } else {
                                saveMessage.textContent = "Ошибка!";
                                saveMessage.style.color = "red";
                            }
                            saveMessage.style.display = "block";
                            setTimeout(() => saveMessage.style.display = "none", 2000);
                        })
                        .catch(error => console.error("Ошибка:", error));
                });
            });
            function showCustomAlert(message) {
                document.getElementById('customAlertMessage').textContent = message;
                document.getElementById('customAlertOverlay').style.display = 'block';
                document.getElementById('customAlert').style.display = 'block';
            }

            function hideCustomAlert() {
                document.getElementById('customAlertOverlay').style.display = 'none';
                document.getElementById('customAlert').style.display = 'none';
            }

        </script>
        <div class="sidebar-modal" id="settings-modal">
            <div class="sidebar-content">
                <button class="close-sidebar" id="close-sidebar">&times;</button>
                <h2>Настройки</h2>
                <label for="character-name-input">Имя персонажа:</label>
                <input type="text" id="character-name-input" value="{{ $character->name }}">
                <button id="save-character-name">Сохранить</button>
                <p id="save-message" style="display: none; color: #28a745;">Имя сохранено!</p>
            </div>
        </div>
        <div class="custom-alert-overlay" id="customAlertOverlay"></div>
        <div class="custom-alert" id="customAlert">
            <div id="customAlertMessage"></div>
            <button onclick="hideCustomAlert()">OK</button>
        </div>
</body>
</html>
