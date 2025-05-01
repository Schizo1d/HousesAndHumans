<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="character-id" content="{{ $character->id }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персонажи</title>
    <link rel="stylesheet" href="{{ asset('css/character_info.css') }}">
    <script src="{{ asset('js/character_info.js') }}" defer></script>
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
                <div class="character-header-info">
                    <p class="character-header-name">
                        <span class="font-style">{{ $character->name }}</span>
                        <span class="character-level">Уровень {{ $character->level }}</span>
                        <button class="level-up-btn" onclick="openLevelUpModal()">Поднять уровень</button>
                    </p>
                    <p class="character-header-subinfo">
                        <span class="font-style">{{ $character->race}}</span>
                        <span> — </span>
                        <span class="font-style">{{ $character->class}}</span>
                    </p>
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
                    <!--Атлетика-->

                    <div class="attribute-skill">
                        <label class="double-radio-container">
                            <input type="checkbox" class="double-radio-input" id="athletics-radio"
                                   name="athletics-radio" onclick="handleSkillRadio(this, 'athletics', 'strength')">
                            <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                        </label>
                        <span class="attribute-skill-name">Атлетика</span>
                        <button type="button" class="dice-roll-button" onclick="rollSkill('athletics', 'strength')">
                            <span id="athletics-value">{{ $character->attributes->athletics ?? 0 }}</span>
                        </button>
                    </div>
                    <input type="hidden" name="athletics" id="athletics"
                           value="{{ $character->attributes->athletics ?? 0 }}">

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
                                <a href="#" class="check-link"
                                   onclick="openModal('dexterity'); return false;">Проверка</a>
                            </div>
                            <button type="button" class="dice-roll-button"
                                    onclick="rollDice('dexterity'); return false;">
                <span id="dexterity-modifier" class="modifier">
                    {{ floor(($character->attributes->dexterity ?? 10 - 10) / 2) }}
                </span>
                            </button>
                        </div>

                        <!-- Блок для спасброска -->
                        <div class="save-block">
                            <div class="attribute-skill-wrap">
                                <a href="#" class="save-link"
                                   onclick="openModal('dexterity'); return false;">Спасбросок</a>
                            </div>
                            <button type="button" class="dice-roll-button"
                                    onclick="rollSave('dexterity'); return false;">
                <span id="dexterity-save-modifier" class="modifier">
                    {{ floor(($character->attributes->dexterity ?? 10 - 10) / 2) }}
                </span>
                            </button>
                        </div>
                    </div>
                    <div class="sub-attributes">
                        <!-- Акробатика -->
                        <div class="attribute-skill">
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="acrobatics-radio"
                                       name="acrobatics-radio"
                                       onclick="handleSkillRadio(this, 'acrobatics', 'dexterity')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <span class="attribute-skill-name">Акробатика</span>

                            <button type="button" class="dice-roll-button"
                                    onclick="rollSkill('acrobatics', 'dexterity')">
                                <span id="acrobatics-value">{{ $character->attributes->acrobatics ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="acrobatics" id="acrobatics"
                               value="{{ $character->attributes->acrobatics ?? 0 }}">

                        <div class="attribute-skill">
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="sleight_of_hand-radio"
                                       name="sleight_of_hand-radio"
                                       onclick="handleSkillRadio(this, 'sleight_of_hand', 'dexterity')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <span class="attribute-skill-name">Ловкость рук</span>

                            <button type="button" class="dice-roll-button"
                                    onclick="rollSkill('sleight_of_hand', 'dexterity')">
                                <span
                                    id="sleight_of_hand-value">{{ $character->attributes->sleight_of_hand ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="sleight_of_hand" id="sleight_of_hand"
                               value="{{ $character->attributes->sleight_of_hand ?? 0 }}">

                        <div class="attribute-skill">
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="stealth-radio"
                                       name="stealth-radio" onclick="handleSkillRadio(this, 'stealth', 'dexterity')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <span class="attribute-skill-name">Скрытность</span>

                            <button type="button" class="dice-roll-button" onclick="rollSkill('stealth', 'dexterity')">
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
                            <button type="button" class="dice-roll-button"
                                    onclick="rollDice('constitution'); return false;">
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
                            <button type="button" class="dice-roll-button"
                                    onclick="rollSave('constitution'); return false;">
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
                            <button type="button" class="dice-roll-button"
                                    onclick="rollDice('intelligence'); return false;">
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
                            <button type="button" class="dice-roll-button"
                                    onclick="rollSave('intelligence'); return false;">
                <span id="intelligence-save-modifier" class="modifier">
                    {{ floor(($character->attributes->intelligence ?? 10 - 10) / 2) }}
                </span>
                            </button>
                        </div>
                    </div>
                    <div class="sub-attributes">
                        <!--Анализ-->
                        <div class="attribute-skill">
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="investigation-radio"
                                       name="investigation-radio"
                                       onclick="handleSkillRadio(this, 'investigation', 'intelligence')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <span class="attribute-skill-name">Анализ</span>

                            <button type="button" class="dice-roll-button"
                                    onclick="rollSkill('investigation', 'intelligence')">
                                <span id="investigation-value">{{ $character->attributes->investigation ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="investigation" id="investigation"
                               value="{{ $character->attributes->investigation ?? 0 }}">
                        <!--История-->
                        <div class="attribute-skill">
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="history-radio"
                                       name="history-radio" onclick="handleSkillRadio(this, 'history', 'intelligence')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <span class="attribute-skill-name">История</span>

                            <button type="button" class="dice-roll-button"
                                    onclick="rollSkill('history', 'intelligence')">
                                <span id="history-value">{{ $character->attributes->history ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="history" id="history"
                               value="{{ $character->attributes->history ?? 0 }}">

                        <!--Магия-->
                        <div class="attribute-skill">
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="arcana-radio"
                                       name="arcana-radio" onclick="handleSkillRadio(this, 'arcana', 'intelligence')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <span class="attribute-skill-name">Магия</span>

                            <button type="button" class="dice-roll-button"
                                    onclick="rollSkill('arcana', 'intelligence')">
                                <span id="arcana-value">{{ $character->attributes->arcana ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="arcana" id="arcana"
                               value="{{ $character->attributes->arcana ?? 0 }}">

                        <!--Природа-->

                        <div class="attribute-skill">
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="nature-radio"
                                       name="nature-radio" onclick="handleSkillRadio(this, 'nature', 'intelligence')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <span class="attribute-skill-name">Природа</span>

                            <button type="button" class="dice-roll-button"
                                    onclick="rollSkill('nature', 'intelligence')">
                                <span id="nature-value">{{ $character->attributes->nature ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="nature" id="nature"
                               value="{{ $character->attributes->nature ?? 0 }}">

                        <!--Религия-->

                        <div class="attribute-skill">
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="religion-radio"
                                       name="religion-radio"
                                       onclick="handleSkillRadio(this, 'religion', 'intelligence')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <span class="attribute-skill-name">Религия</span>

                            <button type="button" class="dice-roll-button"
                                    onclick="rollSkill('religion', 'intelligence')">
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
                                <a href="#" class="save-link"
                                   onclick="openModal('wisdom'); return false;">Спасбросок</a>
                            </div>
                            <button type="button" class="dice-roll-button" onclick="rollSave('wisdom'); return false;">
                <span id="wisdom-save-modifier" class="modifier">
                    {{ floor(($character->attributes->wisdom ?? 10 - 10) / 2) }}
                </span>
                            </button>
                        </div>
                    </div>
                    <div class="sub-attributes">
                        <!-- Восприятие -->
                        <div class="attribute-skill">
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="perception-radio"
                                       name="perception-radio" onclick="handleSkillRadio(this, 'perception', 'wisdom')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <span class="attribute-skill-name">Восприятие</span>

                            <button type="button" class="dice-roll-button" onclick="rollSkill('perception', 'wisdom')">
                                <span id="perception-value">{{ $character->attributes->perception ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="perception" id="perception"
                               value="{{ $character->attributes->perception ?? 0 }}">

                        <!--Выживание-->

                        <div class="attribute-skill">
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="survival-radio"
                                       name="survival-radio" onclick="handleSkillRadio(this, 'survival', 'wisdom')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <span class="attribute-skill-name">Выживание</span>

                            <button type="button" class="dice-roll-button" onclick="rollSkill('survival', 'wisdom')">
                                <span id="survival-value">{{ $character->attributes->survival ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="survival" id="survival"
                               value="{{ $character->attributes->survival ?? 0 }}">

                        <!--Медицина-->

                        <div class="attribute-skill">
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="medicine-radio"
                                       name="medicine-radio" onclick="handleSkillRadio(this, 'medicine', 'wisdom')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <span class="attribute-skill-name">Медицина</span>

                            <button type="button" class="dice-roll-button" onclick="rollSkill('medicine', 'wisdom')">
                                <span id="medicine-value">{{ $character->attributes->medicine ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="medicine" id="medicine"
                               value="{{ $character->attributes->medicine ?? 0 }}">

                        <!--Проницательность-->

                        <div class="attribute-skill">
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="insight-radio"
                                       name="insight-radio" onclick="handleSkillRadio(this, 'insight', 'wisdom')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <span class="attribute-skill-name">Проницательность</span>

                            <button type="button" class="dice-roll-button" onclick="rollSkill('insight', 'wisdom')">
                                <span id="insight-value">{{ $character->attributes->insight ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="insight" id="insight"
                               value="{{ $character->attributes->insight ?? 0 }}">

                        {{--Уход за животными--}}

                        <div class="attribute-skill">
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="animal_handling-radio"
                                       name="animal_handling-radio"
                                       onclick="handleSkillRadio(this, 'animal_handling', 'wisdom')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <span class="attribute-skill-name">Уход за животными</span>

                            <button type="button" class="dice-roll-button"
                                    onclick="rollSkill('animal_handling', 'wisdom')">
                                <span
                                    id="animal_handling-value">{{ $character->attributes->animal_handling ?? 0 }}</span>
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
                                <a href="#" class="check-link"
                                   onclick="openModal('charisma'); return false;">Проверка</a>
                            </div>
                            <button type="button" class="dice-roll-button"
                                    onclick="rollDice('charisma'); return false;">
                <span id="charisma-modifier" class="modifier">
                    {{ floor(($character->attributes->charisma ?? 10 - 10) / 2) }}
                </span>
                            </button>
                        </div>

                        <!-- Блок для спасброска -->
                        <div class="save-block">
                            <div class="attribute-skill-wrap">
                                <a href="#" class="save-link"
                                   onclick="openModal('charisma'); return false;">Спасбросок</a>
                            </div>
                            <button type="button" class="dice-roll-button"
                                    onclick="rollSave('charisma'); return false;">
                <span id="charisma-save-modifier" class="modifier">
                    {{ floor(($character->attributes->charisma ?? 10 - 10) / 2) }}
                </span>
                            </button>
                        </div>
                    </div>
                    <div class="sub-attributes">

                        <!--Выступление-->

                        <div class="attribute-skill">
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="performance-radio"
                                       name="performance-radio"
                                       onclick="handleSkillRadio(this, 'performance', 'charisma')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <span class="attribute-skill-name">Выступление</span>

                            <button type="button" class="dice-roll-button"
                                    onclick="rollSkill('performance', 'charisma')">
                                <span id="performance-value">{{ $character->attributes->performance ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="performance" id="performance"
                               value="{{ $character->attributes->performance ?? 0 }}">

                        <!--Запугивание-->

                        <div class="attribute-skill">
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="intimidation-radio"
                                       name="intimidation-radio"
                                       onclick="handleSkillRadio(this, 'intimidation', 'charisma')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <span class="attribute-skill-name">Запугивание</span>

                            <button type="button" class="dice-roll-button"
                                    onclick="rollSkill('intimidation', 'charisma')">
                                <span id="intimidation-value">{{ $character->attributes->intimidation ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="intimidation" id="intimidation"
                               value="{{ $character->attributes->intimidation ?? 0 }}">

                        <!--Обман-->

                        <div class="attribute-skill">
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="deception-radio"
                                       name="deception-radio" onclick="handleSkillRadio(this, 'deception', 'charisma')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <span class="attribute-skill-name">Обман</span>

                            <button type="button" class="dice-roll-button" onclick="rollSkill('deception', 'charisma')">
                                <span id="deception-value">{{ $character->attributes->deception ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="deception" id="deception"
                               value="{{ $character->attributes->deception ?? 0 }}">

                        <!--Убеждение-->

                        <div class="attribute-skill">
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="persuasion-radio"
                                       name="persuasion-radio"
                                       onclick="handleSkillRadio(this, 'persuasion', 'charisma')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <span class="attribute-skill-name">Убеждение</span>

                            <button type="button" class="dice-roll-button"
                                    onclick="rollSkill('persuasion', 'charisma')">
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
        <div class="sidebar-modal" id="settings-modal">
            <div class="sidebar-content">
                <button class="close-sidebar" id="close-sidebar">&times;</button>
                <h2 class="settings-title">Настройки</h2>

                <div class="modal-row">
                    <div class="modal-col">
                        <div class="modal-wrapper">
                            <input class="modal-input" type="text" id="character-name-input"
                                   value="{{ $character->name }}">
                            <label for="character-name-input">имя</label>
                        </div>
                    </div>
                    <div class="modal-col">
                        <div class="modal-wrapper">
                            <input class="modal-input" type="text" id="character-race-input"
                                   value="{{ $character->race ?? '' }}">
                            <label for="character-race-input">раса</label>
                        </div>
                    </div>
                </div>

                <div class="modal-row">
                    <div class="modal-col">
                        <div class="modal-wrapper">
                            <input class="modal-input" type="text" id="character-class-input"
                                   value="{{ $character->class ?? '' }}">
                            <label for="character-class-input">класс</label>
                        </div>
                    </div>

                    <div class="modal-col">
                        <div class="modal-wrapper">
                            <input class="modal-input" type="text" id="character-subclass-input"
                                   value="{{ $character->subclass ?? '' }}">
                            <label for="character-subclass-input">подкласс</label>
                        </div>
                    </div>
                </div>

                <button id="save-character-settings">Сохранить</button>
                <p id="save-message" style="display: none; color: #28a745;">Настройки сохранены!</p>
            </div>
        </div>
        <div class="notifications-wrapper">
            <div class="notifications-container" id="notificationsContainer"></div>
            <button class="close-all-btn" onclick="hideCloseButtonInstantly(); clearAllNotifications()">×</button>
        </div>
        <!-- Модальное окно повышения уровня -->
        <div id="level-up-modal" class="level-modal">
            <div class="level-up-content">
                <button class="modal-close-btn" onclick="closeLevelUpModal()">✖</button>
                <h3>Прогресс уровня</h3>

                <!-- Блок с уровнем и прогресс-баром -->
                <div class="level-progress-container">
                    <div class="level-info">
                        <span class="current-level">Уровень <span id="current-level-value">{{ $character->level ?? 1 }}</span></span>
                        <span class="next-level">До <span id="next-level-value">{{ ($character->level ?? 1) + 1 }}</span>:
            <span id="xp-remaining">0</span> XP</span>
                    </div>

                    <div class="progress-bar-container">
                        <div class="progress-bar" id="xp-progress-bar"></div>
                        <div class="progress-text" id="xp-progress-text">0/0 XP</div>
                    </div>
                </div>

                <!-- Калькулятор опыта -->
                <div class="xp-calculator">
                    <div class="xp-input-container">
                        <input type="text" id="xp-input" value="0" placeholder="Введите XP">
                        <button type="button" class="delete-btn" onclick="deleteLastChar()">⌫</button>
                    </div>

                    <div class="xp-calculator-grid">
                        <button type="button" class="xp-btn num-btn" onclick="appendNumber(7)">7</button>
                        <button type="button" class="xp-btn num-btn" onclick="appendNumber(8)">8</button>
                        <button type="button" class="xp-btn num-btn" onclick="appendNumber(9)">9</button>

                        <button type="button" class="xp-btn num-btn" onclick="appendNumber(4)">4</button>
                        <button type="button" class="xp-btn num-btn" onclick="appendNumber(5)">5</button>
                        <button type="button" class="xp-btn num-btn" onclick="appendNumber(6)">6</button>

                        <button type="button" class="xp-btn num-btn" onclick="appendNumber(1)">1</button>
                        <button type="button" class="xp-btn num-btn" onclick="appendNumber(2)">2</button>
                        <button type="button" class="xp-btn num-btn" onclick="appendNumber(3)">3</button>

                        <button type="button" class="xp-btn num-btn" onclick="appendNumber(0)">0</button>
                        <button type="button" class="xp-btn plus-btn" onclick="appendOperator('+')">+</button>
                        <button type="button" class="xp-btn minus-btn" onclick="appendOperator('-')">-</button>
                    </div>

                    <div class="xp-action-buttons">
                        <button type="button" class="xp-action-btn add-btn" onclick="calculateAndAdd()">ПРИБАВИТЬ</button>
                        <button type="button" class="xp-action-btn subtract-btn" onclick="calculateAndSubtract()">ОТНЯТЬ</button>
                        <button type="button" class="xp-action-btn level-up-btn" id="level-up-btn" onclick="levelUpCharacter()">ПОВЫСИТЬ</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-backdrop" class="modal-backdrop"></div>
        <div id="settings-backdrop" class="modal-backdrop"></div>
</body>
</html>
