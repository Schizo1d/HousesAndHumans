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
                    <!--Атлетика-->

                    <div class="attribute-skill">
                        <span class="attribute-skill-name">Атлетика</span>
                        <label class="double-radio-container">
                            <input type="checkbox" class="double-radio-input" id="athletics-radio"
                                   name="athletics-radio" onclick="handleSkillRadio(this, 'athletics', 'strength')">
                            <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                        </label>
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
                        <!-- Акробатика -->
                        <div class="attribute-skill">
                            <span class="attribute-skill-name">Акробатика</span>
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="acrobatics-radio"
                                       name="acrobatics-radio" onclick="handleSkillRadio(this, 'acrobatics', 'dexterity')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <button type="button" class="dice-roll-button" onclick="rollSkill('acrobatics', 'dexterity')">
                                <span id="acrobatics-value">{{ $character->attributes->acrobatics ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="acrobatics" id="acrobatics"
                               value="{{ $character->attributes->acrobatics ?? 0 }}">

                        <div class="attribute-skill">
                            <span class="attribute-skill-name">Ловкость рук</span>
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="sleight_of_hand-radio"
                                       name="sleight_of_hand-radio" onclick="handleSkillRadio(this, 'sleight_of_hand', 'dexterity')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <button type="button" class="dice-roll-button" onclick="rollSkill('sleight_of_hand', 'dexterity')">
                                <span id="sleight_of_hand-value">{{ $character->attributes->sleight_of_hand ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="sleight_of_hand" id="sleight_of_hand"
                               value="{{ $character->attributes->sleight_of_hand ?? 0 }}">

                        <div class="attribute-skill">
                            <span class="attribute-skill-name">Скрытность</span>
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="stealth-radio"
                                       name="stealth-radio" onclick="handleSkillRadio(this, 'stealth', 'dexterity')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
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
                        <!--Анализ-->
                        <div class="attribute-skill">
                            <span class="attribute-skill-name">Анализ</span>
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="investigation-radio"
                                       name="investigation-radio" onclick="handleSkillRadio(this, 'investigation', 'intelligence')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <button type="button" class="dice-roll-button" onclick="rollSkill('investigation', 'intelligence')">
                                <span id="investigation-value">{{ $character->attributes->investigation ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="investigation" id="investigation"
                               value="{{ $character->attributes->investigation ?? 0 }}">
                        <!--История-->
                        <div class="attribute-skill">
                            <span class="attribute-skill-name">История</span>
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="history-radio"
                                       name="history-radio" onclick="handleSkillRadio(this, 'history', 'intelligence')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <button type="button" class="dice-roll-button" onclick="rollSkill('history', 'intelligence')">
                                <span id="history-value">{{ $character->attributes->history ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="history" id="history"
                               value="{{ $character->attributes->history ?? 0 }}">

                        <!--Магия-->
                        <div class="attribute-skill">
                            <span class="attribute-skill-name">Магия</span>
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="arcana-radio"
                                       name="arcana-radio" onclick="handleSkillRadio(this, 'arcana', 'intelligence')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <button type="button" class="dice-roll-button" onclick="rollSkill('arcana', 'intelligence')">
                                <span id="arcana-value">{{ $character->attributes->arcana ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="arcana" id="arcana"
                               value="{{ $character->attributes->arcana ?? 0 }}">

                        <!--Природа-->

                        <div class="attribute-skill">
                            <span class="attribute-skill-name">Природа</span>
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="nature-radio"
                                       name="nature-radio" onclick="handleSkillRadio(this, 'nature', 'intelligence')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <button type="button" class="dice-roll-button" onclick="rollSkill('nature', 'intelligence')">
                                <span id="nature-value">{{ $character->attributes->nature ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="nature" id="nature"
                               value="{{ $character->attributes->nature ?? 0 }}">

                        <!--Религия-->

                        <div class="attribute-skill">
                            <span class="attribute-skill-name">Религия</span>
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="religion-radio"
                                       name="religion-radio" onclick="handleSkillRadio(this, 'religion', 'intelligence')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <button type="button" class="dice-roll-button" onclick="rollSkill('religion', 'intelligence')">
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
                        <!-- Восприятие -->
                        <div class="attribute-skill">
                            <span class="attribute-skill-name">Восприятие</span>
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="perception-radio"
                                       name="perception-radio" onclick="handleSkillRadio(this, 'perception', 'wisdom')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <button type="button" class="dice-roll-button" onclick="rollSkill('perception', 'wisdom')">
                                <span id="perception-value">{{ $character->attributes->perception ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="perception" id="perception"
                               value="{{ $character->attributes->perception ?? 0 }}">

                        <!--Выживание-->

                        <div class="attribute-skill">
                            <span class="attribute-skill-name">Выживание</span>
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="survival-radio"
                                       name="survival-radio" onclick="handleSkillRadio(this, 'survival', 'wisdom')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <button type="button" class="dice-roll-button" onclick="rollSkill('survival', 'wisdom')">
                                <span id="survival-value">{{ $character->attributes->survival ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="survival" id="survival"
                               value="{{ $character->attributes->survival ?? 0 }}">

                        <!--Медицина-->

                        <div class="attribute-skill">
                            <span class="attribute-skill-name">Медицина</span>
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="medicine-radio"
                                       name="medicine-radio" onclick="handleSkillRadio(this, 'medicine', 'wisdom')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <button type="button" class="dice-roll-button" onclick="rollSkill('medicine', 'wisdom')">
                                <span id="medicine-value">{{ $character->attributes->medicine ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="medicine" id="medicine"
                               value="{{ $character->attributes->medicine ?? 0 }}">

                        <!--Проницательность-->

                        <div class="attribute-skill">
                            <span class="attribute-skill-name">Проницательность</span>
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="insight-radio"
                                       name="insight-radio" onclick="handleSkillRadio(this, 'insight', 'wisdom')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <button type="button" class="dice-roll-button" onclick="rollSkill('insight', 'wisdom')">
                                <span id="insight-value">{{ $character->attributes->insight ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="insight" id="insight"
                               value="{{ $character->attributes->insight ?? 0 }}">

                        {{--Уход за животными--}}

                        <div class="attribute-skill">
                            <span class="attribute-skill-name">Уход за животными</span>
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="animal_handling-radio"
                                       name="animal_handling-radio" onclick="handleSkillRadio(this, 'animal_handling', 'wisdom')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <button type="button" class="dice-roll-button" onclick="rollSkill('animal_handling', 'wisdom')">
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

                        <!--Выступление-->

                        <div class="attribute-skill">
                            <span class="attribute-skill-name">Выступление</span>
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="performance-radio"
                                       name="performance-radio" onclick="handleSkillRadio(this, 'performance', 'charisma')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <button type="button" class="dice-roll-button" onclick="rollSkill('performance', 'charisma')">
                                <span id="performance-value">{{ $character->attributes->performance ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="performance" id="performance"
                               value="{{ $character->attributes->performance ?? 0 }}">

                        <!--Запугивание-->

                        <div class="attribute-skill">
                            <span class="attribute-skill-name">Запугивание</span>
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="intimidation-radio"
                                       name="intimidation-radio" onclick="handleSkillRadio(this, 'intimidation', 'charisma')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <button type="button" class="dice-roll-button" onclick="rollSkill('intimidation', 'charisma')">
                                <span id="intimidation-value">{{ $character->attributes->intimidation ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="intimidation" id="intimidation"
                               value="{{ $character->attributes->intimidation ?? 0 }}">

                        <!--Обман-->

                        <div class="attribute-skill">
                            <span class="attribute-skill-name">Обман</span>
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="deception-radio"
                                       name="deception-radio" onclick="handleSkillRadio(this, 'deception', 'charisma')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <button type="button" class="dice-roll-button" onclick="rollSkill('deception', 'charisma')">
                                <span id="deception-value">{{ $character->attributes->deception ?? 0 }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="deception" id="deception"
                               value="{{ $character->attributes->deception ?? 0 }}">

                        <!--Убеждение-->

                        <div class="attribute-skill">
                            <span class="attribute-skill-name">Убеждение</span>
                            <label class="double-radio-container">
                                <input type="checkbox" class="double-radio-input" id="persuasion-radio"
                                       name="persuasion-radio" onclick="handleSkillRadio(this, 'persuasion', 'charisma')">
                                <span class="double-radio-custom">
                    <span class="radio-dot dot-1"></span>
                    <span class="radio-dot dot-2"></span>
                </span>
                            </label>
                            <button type="button" class="dice-roll-button" onclick="rollSkill('persuasion', 'charisma')">
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

            // Общая функция для обработки всех радио-кнопок навыков
            function handleSkillRadio(element, skillId, attributeId) {
                const hiddenInput = document.getElementById(skillId);
                const displaySpan = document.getElementById(skillId + '-value');
                const customRadio = element.nextElementSibling;

                // Циклическое изменение значения: 0 → 2 → 4 → 0
                let currentValue = parseInt(hiddenInput.value) || 0;
                let newValue;

                if (currentValue === 0) newValue = 2;
                else if (currentValue === 2) newValue = 4;
                else newValue = 0;

                // Обновляем скрытое поле
                hiddenInput.value = newValue;

                // Рассчитываем итоговое значение с модификатором атрибута
                const attributeValue = parseInt(document.getElementById(attributeId).value) || 10;
                const modifier = Math.floor((attributeValue - 10) / 2);
                const finalValue = modifier + newValue;

                // Обновляем отображаемое значение
                displaySpan.textContent = finalValue;

                // Обновляем визуальное состояние радио-кнопки
                customRadio.classList.remove('half-checked', 'fully-checked');
                if (newValue === 2) {
                    customRadio.classList.add('half-checked');
                } else if (newValue === 4) {
                    customRadio.classList.add('fully-checked');
                }

                // Предотвращаем стандартное поведение checkbox
                element.checked = false;
            }

            // Инициализация состояний при загрузке страницы
            document.addEventListener("DOMContentLoaded", function() {
                // Навыки ловкости
                initSkillRadio('acrobatics');
                initSkillRadio('sleight_of_hand');
                initSkillRadio('stealth');

                // Навыки интеллекта
                initSkillRadio('investigation');
                initSkillRadio('history');
                initSkillRadio('arcana');
                initSkillRadio('nature');
                initSkillRadio('religion');

                // Навыки мудрости
                initSkillRadio('perception');
                initSkillRadio('survival');
                initSkillRadio('medicine');
                initSkillRadio('insight');
                initSkillRadio('animal_handling');

                // Навыки харизмы
                initSkillRadio('performance');
                initSkillRadio('intimidation');
                initSkillRadio('deception');
                initSkillRadio('persuasion');
            });

            // Функция инициализации радио-кнопки навыка
            function initSkillRadio(skillId) {
                const skillValue = parseInt(document.getElementById(skillId).value) || 0;
                const radioCustom = document.querySelector('#' + skillId + '-radio + .double-radio-custom');

                if (!radioCustom) return;

                radioCustom.classList.remove('half-checked', 'fully-checked');
                if (skillValue === 2) {
                    radioCustom.classList.add('half-checked');
                } else if (skillValue === 4) {
                    radioCustom.classList.add('fully-checked');
                }
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
                const value = parseInt(document.getElementById(attribute).value) || 10; // Значение по умолчанию 10
                const modifier = Math.floor((value - 10) / 2);
                const roll = Math.floor(Math.random() * 20) + 1;
                const total = roll + modifier;

                addNotification(
                    'ПРОВЕРКА',
                    attribute,
                    roll,
                    modifier,
                    total
                );
            }

            function rollSave(attribute) {
                const value = parseInt(document.getElementById(attribute).value) || 10; // Значение по умолчанию 10
                const modifier = Math.floor((value - 10) / 2);
                const roll = Math.floor(Math.random() * 20) + 1;
                const total = roll + modifier;

                addNotification(
                    'СПАСБРОСОК',
                    attribute,
                    roll,
                    modifier,
                    total
                );
            }
            // Функция для броска навыка
            function rollSkill(skill, attribute) {
                const skillBonus = parseInt(document.getElementById(skill).value) || 0;
                const attrValue = parseInt(document.getElementById(attribute).value) || 10;
                const attrModifier = Math.floor((attrValue - 10) / 2);
                const roll = Math.floor(Math.random() * 20) + 1;
                const total = roll + attrModifier + skillBonus;

                // Переводим название навыка
                const skillNames = {
                    'athletics': 'АТЛЕТИКА',
                    'acrobatics': 'АКРОБАТИКА',
                    'sleight_of_hand': 'ЛОВКОСТЬ РУК',
                    'stealth': 'СКРЫТНОСТЬ',
                    'investigation': 'АНАЛИЗ',
                    'history': 'ИСТОРИЯ',
                    'arcana': 'МАГИЯ',
                    'nature': 'ПРИРОДА',
                    'religion': 'РЕЛИГИЯ',
                    'perception': 'ВОСПРИЯТИЕ',
                    'survival': 'ВЫЖИВАНИЕ',
                    'medicine': 'МЕДИЦИНА',
                    'insight': 'ПРОНИЦАТЕЛЬНОСТЬ',
                    'animal_handling': 'УХОД ЗА ЖИВОТНЫМИ',
                    'performance': 'ВЫСТУПЛЕНИЕ',
                    'intimidation': 'ЗАПУГИВАНИЕ',
                    'deception': 'ОБМАН',
                    'persuasion': 'УБЕЖДЕНИЕ'
                };

                addNotification(
                    'НАВЫК',
                    skillNames[skill] || skill,
                    roll,
                    attrModifier + skillBonus,
                    total
                );
            }
            // Функция для перевода названий атрибутов
            function attributeName(attr) {
                const names = {
                    'strength': 'СИЛА',
                    'dexterity': 'ЛОВКОСТЬ',
                    'constitution': 'ТЕЛОСЛОЖЕНИЕ',
                    'intelligence': 'ИНТЕЛЛЕКТ',
                    'wisdom': 'МУДРОСТЬ',
                    'charisma': 'ХАРИЗМА'
                };
                return names[attr] || attr;
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
                document.getElementById('save-character-settings').addEventListener('click', function() {
                    const characterId = {{ $character->id }};
                    const name = document.getElementById('character-name-input').value;
                    const race = document.getElementById('character-race-input').value;
                    const characterClass = document.getElementById('character-class-input').value;
                    const subclass = document.getElementById('character-subclass-input').value;

                    fetch('/characters/update-settings', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            character_id: characterId,
                            name: name,
                            race: race,
                            class: characterClass,
                            subclass: subclass
                        })
                    })
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
            const MAX_NOTIFICATIONS = 4;
            let currentNotifications = 0;

            function addNotification(type, attribute, roll, modifier, result) {
                const container = document.getElementById('notificationsContainer');
                const closeBtn = document.querySelector('.close-all-btn');

                const isCheck = type === 'ПРОВЕРКА';
                const typeClass = isCheck ? 'check-text' : 'save-text';
                const notificationType = isCheck ? 'check' : 'save';
                const modifierDisplay = modifier >= 0 ? `+ ${modifier}` : modifier;

                // Преобразуем старые уведомления
                document.querySelectorAll('.notification.new').forEach(notif => {
                    const oldTypeClass = notif.dataset.notificationType === 'check' ? 'check-text' : 'save-text';
                    notif.className = `notification old ${notif.dataset.notificationType}`;
                    notif.innerHTML = `
            <span>${notif.dataset.result} </span>
            <span class="${oldTypeClass}">${notif.dataset.type}</span>
            <span> ${notif.dataset.attribute}</span>
        `;
                });

                // Создаем новое уведомление
                const notification = document.createElement('div');
                notification.className = 'notification new';
                notification.dataset.type = type;
                notification.dataset.attribute = attributeName(attribute);
                notification.dataset.result = result;
                notification.dataset.notificationType = notificationType;

                notification.innerHTML = `
        <div class="notification-header">
            <span class="${typeClass}">${type}</span> ${attributeName(attribute)}
        </div>
        <div class="notification-content">
            <div class="notification-formula">${roll} ${modifierDisplay}</div>
            <div class="notification-result">${result}</div>
        </div>
    `;

                container.insertBefore(notification, container.firstChild);

                // Лимит уведомлений
                while (container.children.length > MAX_NOTIFICATIONS) {
                    container.lastChild.remove();
                }
                if (container.children.length === 1) {
                    document.querySelector('.close-all-btn').classList.add('visible');
                }
            }
            // Показываем/скрываем крестик при наличии уведомлений
            function clearAllNotifications() {
                const container = document.getElementById('notificationsContainer');
                container.innerHTML = '';
                currentNotifications = 0;
            }
            function showBottomLeftAlert(header, formula, result) {
                const alertElement = document.getElementById('bottomLeftAlert');
                document.getElementById('alertHeader').textContent = header;
                document.getElementById('rollFormula').textContent = formula;
                document.getElementById('rollResult').textContent = result;
                alertElement.style.display = 'block';
            }

            function hideBottomLeftAlert() {
                document.getElementById('bottomLeftAlert').style.display = 'none';
            }

            function showCustomAlert(message) {
                document.getElementById('customAlertMessage').textContent = message;
                document.getElementById('customAlertOverlay').style.display = 'block';
                document.getElementById('customAlert').style.display = 'block';
            }

            function hideCustomAlert() {
                document.getElementById('customAlertOverlay').style.display = 'none';
                document.getElementById('customAlert').style.display = 'none';
            }

            // Добавляем обработчик для ручного управления видимостью
            document.getElementById('notificationsWrapper').addEventListener('mouseenter', function() {
                if (this.querySelector('.notifications-container').children.length > 0) {
                    this.querySelector('.close-all-btn').style.opacity = '1';
                }
            });

            document.getElementById('notificationsWrapper').addEventListener('mouseleave', function() {
                this.querySelector('.close-all-btn').style.opacity = '0';
            });
            function updateNotificationsState() {
                const wrapper = document.getElementById('notificationsWrapper');
                const hasNotifications = document.getElementById('notificationsContainer').children.length > 0;

                if (hasNotifications) {
                    wrapper.classList.add('has-notifications');
                } else {
                    wrapper.classList.remove('has-notifications');
                }
            }
            function hideCloseButtonInstantly() {
                const btn = document.querySelector('.close-all-btn');
                btn.style.transition = 'none'; // Отключаем анимацию
                btn.classList.remove('visible'); // Мгновенно скрываем
                setTimeout(() => {
                    btn.style.transition = ''; // Восстанавливаем анимацию
                }, 10);
            }

        </script>
        <div class="sidebar-modal" id="settings-modal">
            <div class="sidebar-content">
                <button class="close-sidebar" id="close-sidebar">&times;</button>
                <h2>Настройки</h2>

                <label for="character-name-input">Имя персонажа:</label>
                <input type="text" id="character-name-input" value="{{ $character->name }}">

                <label for="character-race-input">Раса:</label>
                <input type="text" id="character-race-input" value="{{ $character->race ?? '' }}">

                <label for="character-class-input">Класс:</label>
                <input type="text" id="character-class-input" value="{{ $character->class ?? '' }}">

                <label for="character-subclass-input">Подкласс:</label>
                <input type="text" id="character-subclass-input" value="{{ $character->subclass ?? '' }}">

                <button id="save-character-settings">Сохранить</button>
                <p id="save-message" style="display: none; color: #28a745;">Настройки сохранены!</p>
            </div>
        </div>
        <div class="notifications-wrapper">
            <div class="notifications-container" id="notificationsContainer"></div>
            <button class="close-all-btn" onclick="hideCloseButtonInstantly(); clearAllNotifications()">×</button>
        </div>
</body>
</html>
