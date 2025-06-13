<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="character-id" content="{{ $character->id }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персонажи</title>
    <link rel="stylesheet" href="{{ asset('css/character_info.css') }}">
    <link rel="stylesheet" href="{{asset('css/character_content_right.css')}}">
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
        <nav class="digital-nav">
            <div class="character-nav">
                <div class="character-photo" id="character-avatar">
                    <img src="{{ $character->photo ?? asset('img/avatar2.png') }}" alt="Персонаж"
                         class="character-photo-img">
                    <div class="dropdown-menu" id="character-dropdown">
                        <button class="dropdown-item" id="settings-btn">Настройки</button>
                    </div>
                </div>
                <div class="character-header-info">
                    <p class="character-header-name">
                        <span class="font-style">{{ $character->name }}</span>
                    </p>
                    <p class="character-header-subinfo">
                        <span class="font-style">{{ $character->race}}</span>
                        <span> — </span>
                        <span class="font-style">{{ $character->class}}</span>
                    </p>
                    <div class="character-header-exp">
                        <span class="character-level">Уровень {{ $character->level }}</span>
                        <div class="mini-progress-container" onclick="openLevelUpModal()"
                             data-current-xp="{{ $totalXp }}"
                             data-current-level="{{ $character->level }}"
                             data-next-level-xp="{{ $nextLevelXp }}">
                            <div class="mini-progress-bar" id="mini-xp-progress-bar"
                                 style="width: {{ $progressPercent }}%"></div>
                            <div class="mini-progress-text" id="mini-xp-progress-text">
                                {{ $totalXp }}/{{ $nextLevelXp }}
                            </div>
                        </div>
                    </div>
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
                        <input type="hidden" id="dexterity" name="dexterity" value="{{ $character->attributes->dexterity ?? 10 }}">
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


                <div class="passive-skills">
                    <h3>Пассивные чувства</h3>

                    <div class="passive-skill-item">
                        <button class="passive-skill-value" id="passive-perception-button">
                            {{ $character->attributes->passive_perception ?? 10 }}
                        </button>
                        <a href="javascript:void(0);" onclick="openModal('wisdom')" class="passive-link">
                            <span class="passive-skill-name">Восприятие (Мудрость):</span>
                        </a>
                        <input type="hidden" id="passive_perception" name="passive_perception"
                               value="{{ $character->attributes->passive_perception ?? 10 }}">
                    </div>

                    <div class="passive-skill-item">
                        <button class="passive-skill-value" id="passive-insight-button">
                            {{ $character->attributes->passive_insight ?? 10 }}
                        </button>
                        <a href="javascript:void(0);" onclick="openModal('wisdom')" class="passive-link">
                            <span class="passive-skill-name">Проницательность (Мудрость):</span>
                        </a>
                        <input type="hidden" id="passive_insight" name="passive_insight"
                               value="{{ $character->attributes->passive_insight ?? 10 }}">
                    </div>

                    <div class="passive-skill-item">
                        <button class="passive-skill-value" id="passive-investigation-button">
                            {{ $character->attributes->passive_investigation ?? 10 }}
                        </button>
                        <a href="javascript:void(0);" onclick="openModal('intelligence')" class="passive-link">
                            <span class="passive-skill-name">Анализ (Интеллект):</span>
                        </a>
                        <input type="hidden" id="passive_investigation" name="passive_investigation"
                               value="{{ $character->attributes->passive_investigation ?? 10 }}">
                    </div>
                </div>

                <button type="submit">Сохранить атрибуты</button>
            </div>
        </form>

        <form id="attributesForm" action="{{ route('character_attributes.store', ['character' => $character->id]) }}"
              method="POST">
            @csrf
            <input type="hidden" name="character_id" value="{{ $character->id }}">
            <div class="digital_content_right">
                <div>
                    <div class="digital_box">
                        <div class="digital_box_button">
                            <button class="digital_button" type="button" onclick="rollInitiative()">
                                <p id="initiative-mod" class="initiative"></p>
                            </button>
                        </div>
                        <span>инициатива</span>
                    </div>
                    <div class="digital_box">
                        <div class="digital_box_button">
                            <label class="inspiration"></label>
                        </div>
                        <span>вдохновение</span>
                    </div>
                    <div class="digital_box">
                        <div class="digital_box_button">
                            <label class="digital-exhaustion-wrap">
                                <select class="digital-exhaustion">

                                </select>
                                <span>

                            </span>
                            </label>
                        </div>
                        <span>истощение</span>
                    </div>
                    <div>
                        <div>
                            <div>
                                <a href=""></a>
                            </div>
                        </div>
                        <span>состояние</span>
                    </div>
                </div>
                <div>

                </div>
            </div>
        </form>

        <!-- Модальное окно -->
        <div id="attributeModal" class="modal" style="display: none;">
            <div class="modal-content">
                <button class="modal-close-btn" onclick="closeModal()">✖</button>
                <h3 id="modal-title"></h3>
                <input type="number" id="modal-input" min="1" max="30">

                <!-- Секция для пассивных чувств -->
                <div id="passive-skills-section" style="margin-top: 20px; display: none;">
                    <h4>Пассивные чувства</h4>
                    <div class="passive-skill" data-skill="perception">
                        <label>Восприятие:</label>
                        <input type="number" id="modal-passive-perception" min="1" max="30">
                        <button onclick="resetPassiveSkill('perception')">Сброс</button>
                    </div>
                    <div class="passive-skill" data-skill="insight">
                        <label>Проницательность:</label>
                        <input type="number" id="modal-passive-insight" min="1" max="30">
                        <button onclick="resetPassiveSkill('insight')">Сброс</button>
                    </div>
                    <div class="passive-skill" data-skill="investigation" style="display: none;">
                        <label>Анализ:</label>
                        <input type="number" id="modal-passive-investigation" min="1" max="30">
                        <button onclick="resetPassiveSkill('investigation')">Сброс</button>
                    </div>
                </div>

                <button class="modal-save-btn" onclick="saveAttribute()">Сохранить</button>
            </div>
        </div>

        <script>

            // Глобальные переменные
            const levelUpModal = document.getElementById('level-up-modal');
            const levelUpBtn = document.querySelector('.level-up-btn');
            let isLevelUpModalOpen = false;
            let currentLevel = {{ $character->level ?? 1 }};
            let currentXp = {{ $character->experience ?? 0 }};
            let currentExpression = '0';
            const characterId = document.querySelector('meta[name="character-id"]').getAttribute('content');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const passiveSkillNames = {
                'perception': 'Восприятие',
                'insight': 'Проницательность',
                'investigation': 'Анализ'
            };

            const XP_TABLE = {
                1: 0,
                2: 300,
                3: 900,
                4: 2700,
                5: 6500,
                6: 14000,
                7: 23000,
                8: 34000,
                9: 48000,
                10: 64000,
                11: 85000,
                12: 100000,
                13: 120000,
                14: 140000,
                15: 165000,
                16: 195000,
                17: 225000,
                18: 265000,
                19: 305000,
                20: 355000
            };
            let nextLevelXp = XP_TABLE[currentLevel + 1] || XP_TABLE[20];
            let currentAttr = null;

            const attributeNames = {
                strength: "Сила",
                dexterity: "Ловкость",
                constitution: "Телосложение",
                intelligence: "Интеллект",
                wisdom: "Мудрость",
                charisma: "Харизма"
            };

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
            document.addEventListener("DOMContentLoaded", function () {
                // Навыки силы
                initSkillRadio('athletics');

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
                    'charisma': 'ХАРИЗМА',
                    'initiative': 'ИНИЦИАТИВА'
                };
                return names[attr] || attr;
            }

            function saveAttribute() {
                try {
                    const attrValue = parseInt(document.getElementById("modal-input").value) || 10;
                    document.getElementById(currentAttr).value = attrValue;
                    document.getElementById(`${currentAttr}-button`).textContent = attrValue;

                    updateBaseModifier(currentAttr);
                    updateSkills(currentAttr);

                    if (currentAttr === "wisdom") {
                        ["perception", "insight"].forEach(skill => {
                            const val = parseInt(document.getElementById(`modal-passive-${skill}`).value) || 10;
                            const modifier = getModifier(attrValue);
                            const auto = 10 + modifier;

                            document.getElementById(`passive_${skill}`).value = val;
                            const button = document.getElementById(`passive-${skill}-button`);
                            button.textContent = val;

                            // 🟡 Только если значение отличается от авто — делаем его ручным
                            if (val !== auto) {
                                button.classList.add("manual");
                                localStorage.setItem(`passive_${skill}_manual`, val);
                                localStorage.removeItem(`passive_${skill}_auto`);
                            } else {
                                button.classList.remove("manual");
                                localStorage.removeItem(`passive_${skill}_manual`);
                                localStorage.setItem(`passive_${skill}_auto`, val);
                            }
                        });
                    }else if (currentAttr === "intelligence") {
                        const val = parseInt(document.getElementById(`modal-passive-investigation`).value) || 10;
                        const modifier = getModifier(attrValue);
                        const auto = 10 + modifier;

                        document.getElementById("passive_investigation").value = val;
                        const button = document.getElementById("passive-investigation-button");
                        button.textContent = val;

                        // 🟡 Только если значение отличается от авто — делаем ручным
                        if (val !== auto) {
                            button.classList.add("manual");
                            localStorage.setItem("passive_investigation_manual", val);
                            localStorage.removeItem("passive_investigation_auto");
                        } else {
                            button.classList.remove("manual");
                            localStorage.removeItem("passive_investigation_manual");
                            localStorage.setItem("passive_investigation_auto", val);
                        }
                    }

                    document.getElementById("attributeModal").style.display = "none";
                } catch (e) {
                    console.error("Ошибка сохранения:", e);
                }
            }

            function updateModifier(attribute, forceUpdate = false) {
                let attrValue = parseInt(document.getElementById(attribute).value);
                let modifier = getModifier(attrValue);

                // Обновляем модификаторы для проверок и спасбросков
                document.getElementById(`${attribute}-modifier`).textContent = modifier;
                document.getElementById(`${attribute}-save-modifier`).textContent = modifier;

                // Обновляем связанные навыки
                updateSkills(attribute);

                // Автоматически обновляем только НЕручные пассивные чувства
                if (attribute === 'wisdom') {
                    const perceptionButton = document.getElementById("passive-perception-button");
                    const insightButton = document.getElementById("passive-insight-button");

                    if (!perceptionButton.classList.contains('manual-value') || forceUpdate) {
                        const passivePerception = 10 + modifier;
                        document.getElementById("passive_perception").value = passivePerception;
                        perceptionButton.textContent = passivePerception;
                        if (forceUpdate) perceptionButton.classList.remove('manual-value');
                    }

                    if (!insightButton.classList.contains('manual-value') || forceUpdate) {
                        const passiveInsight = 10 + modifier;
                        document.getElementById("passive_insight").value = passiveInsight;
                        insightButton.textContent = passiveInsight;
                        if (forceUpdate) insightButton.classList.remove('manual-value');
                    }
                }
                else if (attribute === 'intelligence') {
                    const investigationButton = document.getElementById("passive-investigation-button");

                    if (!investigationButton.classList.contains('manual-value') || forceUpdate) {
                        const passiveInvestigation = 10 + modifier;
                        document.getElementById("passive_investigation").value = passiveInvestigation;
                        investigationButton.textContent = passiveInvestigation;
                        if (forceUpdate) investigationButton.classList.remove('manual-value');
                    }
                }
            }

            function resetPassiveSkill(skill) {
                const attr = skill === "investigation" ? "intelligence" : "wisdom";
                const attrValue = parseInt(document.getElementById(attr).value);
                const mod = getModifier(attrValue);
                const value = 10 + mod;

                const button = document.getElementById(`passive-${skill}-button`);
                const input = document.getElementById(`passive_${skill}`);

                input.value = value;
                button.textContent = value;

                // ✅ Удаляем класс для сброса цвета
                if (button.classList.contains("manual")) {
                    button.classList.remove("manual");
                }

                localStorage.removeItem(`passive_${skill}_manual`);
                localStorage.setItem(`passive_${skill}_auto`, value);

                // Обновляем инпут модального окна, если оно открыто
                const modal = document.getElementById("attributeModal");
                if (modal && modal.style.display === "flex") {
                    document.getElementById(`modal-passive-${skill}`).value = value;
                }
            }

            // Открыть модальное окно для изменения значения атрибута
            function openModal(attr) {
                currentAttr = attr;
                let value = document.getElementById(attr).value;
                document.getElementById("modal-title").innerText = attributeNames[attr];
                document.getElementById("modal-input").value = value;

                const passiveSection = document.getElementById("passive-skills-section");
                passiveSection.style.display = "block";

                document.querySelectorAll('.passive-skill').forEach(el => {
                    el.style.display = "none";
                });

                if (attr === 'wisdom') {
                    // Показываем сохраненные значения
                    document.getElementById("modal-passive-perception").value =
                        document.getElementById("passive_perception").value;

                    document.getElementById("modal-passive-insight").value =
                        document.getElementById("passive_insight").value;

                    document.querySelector('.passive-skill[data-skill="perception"]').style.display = "block";
                    document.querySelector('.passive-skill[data-skill="insight"]').style.display = "block";
                }
                else if (attr === 'intelligence') {
                    document.getElementById("modal-passive-investigation").value =
                        document.getElementById("passive_investigation").value;

                    document.querySelector('.passive-skill[data-skill="investigation"]').style.display = "block";
                }
                else {
                    passiveSection.style.display = "none";
                }

                document.getElementById("attributeModal").style.display = "flex";
            }

            function updatePassiveSkills() {
                const wisdomModifier = getModifier(parseInt(document.getElementById("wisdom").value));
                const intelligenceModifier = getModifier(parseInt(document.getElementById("intelligence").value));

                const skills = {
                    "perception": wisdomModifier,
                    "insight": wisdomModifier,
                    "investigation": intelligenceModifier
                };

                Object.keys(skills).forEach(skill => {
                    const button = document.getElementById(`passive-${skill}-button`);
                    if (!button.classList.contains('manual')) {
                        const passiveValue = 10 + skills[skill];
                        document.getElementById(`passive_${skill}`).value = passiveValue;
                        button.textContent = passiveValue;
                    }
                });
            }

            function updateBaseModifier(attribute) {
                let attrValue = parseInt(document.getElementById(attribute).value);
                let modifier = getModifier(attrValue);
                document.getElementById(`${attribute}-modifier`).textContent = modifier;
                document.getElementById(`${attribute}-save-modifier`).textContent = modifier;
            }


            document.addEventListener("DOMContentLoaded", function () {
                // Инициализация модификаторов
                Object.keys(attributeNames).forEach(attr => {
                    updateBaseModifier(attr);
                    updateSkills(attr);
                });

                // Инициализация модификатора инициативы
                const dexValue = parseInt(document.getElementById("dexterity").value) || 10;
                const initiativeMod = getModifier(dexValue);
                const initiativeModElement = document.getElementById("initiative-mod");
                initiativeModElement.textContent = initiativeMod >= 0 ? `+${initiativeMod}` : initiativeMod;

                // Восстановление пассивных навыков
                ["perception", "insight", "investigation"].forEach(skill => {
                    const manual = localStorage.getItem(`passive_${skill}_manual`);
                    const auto = localStorage.getItem(`passive_${skill}_auto`);
                    const button = document.getElementById(`passive-${skill}-button`);

                    if (manual) {
                        document.getElementById(`passive_${skill}`).value = manual;
                        button.textContent = manual;
                        button.classList.add("manual");
                    } else if (auto) {
                        document.getElementById(`passive_${skill}`).value = auto;
                        button.textContent = auto;
                        button.classList.remove("manual");
                    } else {
                        // Авторасчёт, если ничего не сохранено
                        const attr = skill === "investigation" ? "intelligence" : "wisdom";
                        const mod = getModifier(parseInt(document.getElementById(attr).value));
                        const value = 10 + mod;
                        document.getElementById(`passive_${skill}`).value = value;
                        button.textContent = value;
                        button.classList.remove("manual");
                    }
                });

                // Обработка ручного изменения в модальном окне
                ["perception", "insight", "investigation"].forEach(skill => {
                    const input = document.getElementById(`modal-passive-${skill}`);
                    if (input) {
                        input.addEventListener("change", function () {
                            const value = parseInt(this.value) || 10;
                            document.getElementById(`passive-${skill}-button`).classList.add("manual");
                            document.getElementById(`passive_${skill}`).value = value;
                            document.getElementById(`passive-${skill}-button`).textContent = value;
                            localStorage.setItem(`passive_${skill}_manual`, value);
                            localStorage.removeItem(`passive_${skill}_auto`);
                        });
                    }
                });
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

                // В обработчике открытия модального окна настроек
                settingsBtn.addEventListener("click", function () {
                    const backdrop = document.getElementById('settings-backdrop');
                    backdrop.style.display = 'block';
                    setTimeout(() => {
                        sidebarModal.classList.add("show");
                        backdrop.classList.add('active');
                    }, 10);
                });

                // В обработчике закрытия
                closeSidebar.addEventListener("click", function () {
                    const backdrop = document.getElementById('settings-backdrop');
                    sidebarModal.classList.remove("show");
                    backdrop.classList.remove('active');
                    setTimeout(() => {
                        backdrop.style.display = 'none';
                    }, 300);
                });

                // Обновите обработчик клика вне модального окна
                document.addEventListener("click", function (event) {
                    const backdrop = document.getElementById('settings-backdrop');
                    if (!sidebarModal.contains(event.target) &&
                        !settingsBtn.contains(event.target) &&
                        backdrop.classList.contains('active')) {
                        sidebarModal.classList.remove("show");
                        backdrop.classList.remove('active');
                        setTimeout(() => {
                            backdrop.style.display = 'none';
                        }, 300);
                    }
                });
                document.getElementById('save-character-settings').addEventListener('click', function () {
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
            document.getElementById('notificationsWrapper').addEventListener('mouseenter', function () {
                if (this.querySelector('.notifications-container').children.length > 0) {
                    this.querySelector('.close-all-btn').style.opacity = '1';
                }
            });

            document.getElementById('notificationsWrapper').addEventListener('mouseleave', function () {
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

            // Инициализация при открытии модального окна
            function openLevelUpModal() {
                if (isLevelUpModalOpen) return;

                const modal = document.getElementById('level-up-modal');
                const backdrop = document.getElementById('modal-backdrop');

                backdrop.style.display = 'block';
                modal.style.display = 'block';

                setTimeout(() => {
                    backdrop.classList.add('active');
                    modal.classList.add('show');
                    isLevelUpModalOpen = true;

                    // Обновляем данные при открытии модального окна
                    updateProgressBar();
                }, 10);

                document.getElementById('xp-input').value = '0';
                currentExpression = '0';
            }


            function closeLevelUpModal() {
                if (!isLevelUpModalOpen) return;

                const modal = document.getElementById('level-up-modal');
                const backdrop = document.getElementById('modal-backdrop');

                modal.classList.remove('show');
                backdrop.classList.remove('active');

                setTimeout(() => {
                    modal.style.display = 'none';
                    backdrop.style.display = 'none';
                    isLevelUpModalOpen = false;

                    // Принудительное обновление после закрытия модалки
                    updateAllProgress();
                }, 300);
                updateMiniProgressBar(currentLevel, currentXp);
            }

            // Обработчик открытия по кнопке
            document.querySelector('.level-up-btn').addEventListener('click', function(e) {
                e.stopPropagation();
                openLevelUpModal();
            });

            // Обработчик закрытия по крестику
            document.querySelector('#level-up-modal .modal-close-btn').addEventListener('click', function(e) {
                e.stopPropagation();
                closeLevelUpModal();
            });

            // Закрытие при клике на backdrop
            document.getElementById('modal-backdrop').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeLevelUpModal();
                }
            });

            // Защита от закрытия при клике внутри модального окна
            document.getElementById('level-up-modal').addEventListener('click', function(e) {
                e.stopPropagation();
            });

            // Функция для изменения значения опыта
            function changeXp(amount) {
                const input = document.getElementById('xp-input');
                if (!input) return;

                let value = parseInt(input.value) || 0;
                value = Math.max(0, value + amount);
                input.value = value;
            }

            // Функция для обновления уровня персонажа на сервере
            function updateCharacterLevel(newLevel) {
                try {
                    const characterId = document.querySelector('meta[name="character-id"]')?.getAttribute('content');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    if (!characterId || !csrfToken) {
                        console.error('Missing required meta tags');
                        return;
                    }

                    fetch('/character/update-level', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            character_id: characterId,
                            level: newLevel
                        })
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (!data.success) {
                                console.error('Ошибка при обновлении уровня:', data.error);
                                // Откатываем изменение на клиенте
                                const levelElement = document.querySelector('.character-level');
                                if (levelElement) {
                                    levelElement.textContent = `Уровень ${newLevel - 1}`;
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Ошибка:', error);
                            const levelElement = document.querySelector('.character-level');
                            if (levelElement) {
                                levelElement.textContent = `Уровень ${newLevel - 1}`;
                            }
                        });
                } catch (error) {
                    console.error('Error in updateCharacterLevel:', error);
                }
            }
            // Функции для работы с калькулятором
            function appendNumber(num) {
                if (currentExpression === '0') {
                    currentExpression = num.toString();
                } else {
                    currentExpression += num.toString();
                }
                document.getElementById('xp-input').value = currentExpression;
            }

            function appendOperator(operator) {
                const lastChar = currentExpression.slice(-1);
                if (['+', '-'].includes(lastChar)) {
                    currentExpression = currentExpression.slice(0, -1) + operator;
                } else {
                    currentExpression += operator;
                }
                document.getElementById('xp-input').value = currentExpression;
            }

            function calculateExpression() {
                try {
                    return eval(currentExpression.replace(/[^-+0-9]/g, '')) || 0;
                } catch (e) {
                    console.error('Error calculating expression:', e);
                    return 0;
                }
            }

            async function calculateAndAdd() {
                try {
                    const amount = calculateExpression();
                    if (amount <= 0) {
                        alert('Введите положительное число');
                        return;
                    }

                    const newXp = currentXp + amount;
                    await saveExperience(newXp);

                    // Мгновенное обновление UI
                    currentXp = newXp;
                    updateProgressBar();
                    clearInput();
                } catch (error) {
                    console.error('Add XP error:', error);
                    alert('Ошибка: ' + (error.message || 'Не удалось добавить опыт'));
                }
            }

            async function calculateAndSubtract() {
                try {
                    const amount = calculateExpression();
                    if (amount <= 0) {
                        alert('Введите положительное число');
                        return;
                    }

                    const newXp = Math.max(0, currentXp - amount);
                    await saveExperience(newXp);

                    // Мгновенное обновление UI
                    currentXp = newXp;
                    updateProgressBar();
                    clearInput();
                } catch (error) {
                    console.error('Subtract XP error:', error);
                    alert('Ошибка: ' + (error.message || 'Не удалось вычесть опыт'));
                }
            }

            function clearInput() {
                currentExpression = '0';
                document.getElementById('xp-input').value = currentExpression;
            }


            // Функция для прибавления опыта
            async function addXp() {
                const input = document.getElementById('xp-input');
                if (!input) return;

                const amount = parseInt(input.value) || 0;
                if (amount <= 0) return;

                try {
                    currentXp += amount;
                    await saveExperience(currentXp);
                    updateXpDisplay();
                    checkLevelUp();
                    input.value = "0";
                } catch (error) {
                    // Откатываем изменения при ошибке
                    currentXp -= amount;
                    updateXpDisplay();
                    alert('Ошибка при сохранении опыта');
                }
            }
            // Функция для вычитания опыта
            async function subtractXp() {
                const input = document.getElementById('xp-input');
                const amount = parseInt(input.value) || 0;
                if (amount <= 0) return;

                const newXp = Math.max(0, currentXp - amount);
                const currentLevelXp = XP_TABLE[currentLevel] || 0;

                try {
                    // 1. Проверяем, нужно ли понизить уровень
                    const shouldLevelDown = newXp < currentLevelXp && currentLevel > 1;

                    // 2. Получаем новые границы XP
                    let newLevel = shouldLevelDown ? currentLevel - 1 : currentLevel;
                    const newLevelXp = XP_TABLE[newLevel] || 0;
                    const nextLevelXp = XP_TABLE[newLevel + 1] || XP_TABLE[20];

                    // 3. Рассчитываем новый прогресс
                    const progressPercent = ((newXp - newLevelXp) / (nextLevelXp - newLevelXp)) * 100;

                    // 4. Анимируем изменение
                    const progressBar = document.getElementById('xp-progress-bar');

                    if (shouldLevelDown) {
                        // Мгновенно обновляем уровень и текстовые значения
                        currentLevel = newLevel;
                        document.getElementById('current-level-value').textContent = currentLevel;
                        document.getElementById('next-level-value').textContent = currentLevel + 1;
                        document.getElementById('current-level-xp').textContent = newLevelXp + ' XP';
                        document.getElementById('next-level-xp').textContent = nextLevelXp + ' XP';

                        // Мгновенный сброс в 0% (без анимации)
                        progressBar.style.transition = 'none';
                        progressBar.style.width = '0%';

                        // Микро-задержка для корректного отображения
                        await new Promise(resolve => setTimeout(resolve, 10));
                    }

                    // Плавное заполнение до нового значения
                    progressBar.style.transition = 'width 0.5s ease';
                    progressBar.style.width = `${progressPercent}%`;

                    // 5. Обновляем остальные значения
                    currentXp = newXp;
                    document.getElementById('current-xp-display').textContent = currentXp;
                    updateMiniProgressBar();

                    // 6. Сохраняем изменения
                    await saveExperience(currentXp, currentLevel);

                } catch (error) {
                    console.error('Ошибка:', error);
                    alert('Ошибка: ' + error.message);
                    updateProgressBar();
                }

                input.value = "0";
            }

            // Обновление отображения текущего опыта
            function updateXpDisplay() {
                const currentXpElement = document.getElementById('current-xp');
                if (currentXpElement) {
                    currentXpElement.textContent = currentXp;
                }
            }

            // Проверка возможности повышения уровня
            function checkLevelUp() {
                const nextLevel = currentLevel + 1;
                const nextLevelXp = XP_TABLE[nextLevel] || XP_TABLE[20];

                if (currentXp >= nextLevelXp && nextLevel <= 20) {
                    document.getElementById('level-up-btn').style.display = 'block';
                } else {
                    document.getElementById('level-up-btn').style.display = 'none';
                }
            }
            // Функция повышения уровня
            async function levelUpCharacter() {
                const nextLevel = currentLevel + 1;
                const nextLevelXp = XP_TABLE[nextLevel] || XP_TABLE[20];

                if (currentXp >= nextLevelXp) {
                    try {
                        // Мгновенное обновление UI
                        currentLevel = nextLevel;
                        updateProgressBar();

                        // Анимация
                        animateLevelUp();

                        // Сохраняем на сервере
                        await saveExperience(currentXp, nextLevel);
                    } catch (error) {
                        console.error('Ошибка при повышении уровня:', error);
                        alert('Ошибка при повышении уровня: ' + error.message);
                    }
                } else {
                    alert('Недостаточно опыта для повышения уровня!');
                }
            }
            // Анимация повышения уровня
            function animateLevelUp() {
                const progressBar = document.getElementById('xp-progress-bar');
                progressBar.style.transition = 'none';
                progressBar.style.width = '0%';

                setTimeout(() => {
                    progressBar.style.transition = 'width 0.5s ease';
                    updateProgressBar();
                }, 10);
            }


            // Функция обновления прогресс-бара
            function updateProgressBar(disableAnimation = false) {
                const currentLevelXp = XP_TABLE[currentLevel] || 0;
                const nextLevelXp = XP_TABLE[currentLevel + 1] || XP_TABLE[20];
                const prevLevelXp = XP_TABLE[currentLevel - 1] || 0;

                // Определяем границы для прогресса
                let startXp, endXp;
                if (currentXp < currentLevelXp) {
                    // Если XP меньше текущего уровня, показываем прогресс от предыдущего уровня
                    startXp = prevLevelXp;
                    endXp = currentLevelXp;
                } else {
                    // Иначе показываем прогресс к следующему уровню
                    startXp = currentLevelXp;
                    endXp = nextLevelXp;
                }

                // Рассчитываем процент прогресса
                let progressPercent = 0;
                if (endXp > startXp) {
                    progressPercent = ((currentXp - startXp) / (endXp - startXp)) * 100;
                }

                const progressBar = document.getElementById('xp-progress-bar');

                // Если XP меньше текущего уровня - принудительно 0%
                if (currentXp < currentLevelXp) {
                    progressPercent = 0;
                }

                if (disableAnimation) {
                    progressBar.style.transition = 'none';
                    progressBar.style.width = `${progressPercent}%`;
                    setTimeout(() => progressBar.style.transition = 'width 0.5s ease', 10);
                } else {
                    progressBar.style.width = `${progressPercent}%`;
                }

                // Обновляем текстовые значения
                document.getElementById('current-level-value').textContent = currentLevel;
                document.getElementById('next-level-value').textContent = currentLevel + 1;
                document.getElementById('current-level-xp').textContent = currentLevelXp + ' XP';
                document.getElementById('next-level-xp').textContent = nextLevelXp + ' XP';
                document.getElementById('current-xp-display').textContent = currentXp;

                updateMiniProgressBar();
                checkLevelButtons();
            }


            function checkLevelButtons() {
                const currentLevelXp = XP_TABLE[currentLevel] || 0;
                const nextLevelXp = XP_TABLE[currentLevel + 1] || XP_TABLE[20];

                // Показываем кнопку повышения только если опыт >= следующего уровня
                const levelUpBtn = document.getElementById('level-up-btn');
                if (levelUpBtn) {
                    levelUpBtn.style.display = (currentXp >= nextLevelXp && currentLevel < 20) ? 'block' : 'none';
                }

                // Показываем кнопку понижения только если опыт < текущего уровня и уровень > 1
                const levelDownBtn = document.getElementById('level-down-btn');
                if (levelDownBtn) {
                    levelDownBtn.style.display = (currentXp < currentLevelXp && currentLevel > 1) ? 'block' : 'none';
                }
            }

            // Функция для сохранения опыта на сервере
            async function saveExperience(newXp, newLevel = currentLevel) {
                try {
                    const response = await fetch('/character/update-experience', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            character_id: characterId,
                            experience: newXp,
                            level: newLevel
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        currentXp = newXp;
                        currentLevel = newLevel;
                        nextLevelXp = XP_TABLE[currentLevel + 1] || XP_TABLE[20];

                        updateProgressBar();
                        updateMiniProgressBar();

                        // Проверяем обе кнопки после изменения
                        checkLevelUp();
                        checkLevelDown();
                    }

                    return data;
                } catch (error) {
                    console.error('Ошибка сохранения опыта:', error);
                    throw error;
                }
            }
            // Проверка возможности понижения уровня
            function checkLevelDown() {
                const currentLevelXp = XP_TABLE[currentLevel] || 0;
                const shouldShowLevelDown = currentXp < currentLevelXp && currentLevel > 1;

                const levelDownBtn = document.getElementById('level-down-btn');
                if (levelDownBtn) {
                    levelDownBtn.style.display = shouldShowLevelDown ? 'block' : 'none';
                }

                // Также скрываем кнопку повышения, если опыт меньше текущего уровня
                const levelUpBtn = document.getElementById('level-up-btn');
                if (levelUpBtn) {
                    levelUpBtn.style.display = currentXp >= currentLevelXp ? 'block' : 'none';
                }
            }
            // Функция понижения уровня
            async function levelDownCharacter() {
                if (currentLevel <= 1) return; // Нельзя понизить ниже 1 уровня

                const newLevel = currentLevel - 1;
                const newLevelXp = XP_TABLE[newLevel] || 0;
                const nextLevelXp = XP_TABLE[newLevel + 1] || XP_TABLE[20];

                try {
                    // 1. Сначала анимируем сброс полоски в начало
                    const progressBar = document.getElementById('xp-progress-bar');
                    progressBar.style.transition = 'width 0.3s ease';
                    progressBar.style.width = '0%';

                    // Ждем завершения анимации сброса
                    await new Promise(resolve => setTimeout(resolve, 300));

                    // 2. Обновляем данные уровня (без анимации)
                    currentLevel = newLevel;

                    // 3. Рассчитываем новый прогресс от 0 до текущего XP
                    const progressPercent = (currentXp - newLevelXp) / (nextLevelXp - newLevelXp) * 100;

                    // 4. Временно отключаем анимацию для мгновенного сброса
                    progressBar.style.transition = 'none';
                    progressBar.style.width = '0%';

                    // 5. Включаем анимацию и запускаем заполнение
                    setTimeout(() => {
                        progressBar.style.transition = 'width 0.5s ease';
                        progressBar.style.width = `${progressPercent}%`;

                        // Обновляем текстовые значения
                        document.getElementById('current-level-value').textContent = currentLevel;
                        document.getElementById('next-level-value').textContent = currentLevel + 1;
                        document.getElementById('current-level-xp').textContent = newLevelXp + ' XP';
                        document.getElementById('next-level-xp').textContent = nextLevelXp + ' XP';
                        document.getElementById('current-xp-display').textContent = currentXp;

                        // Обновляем мини-прогресс бар
                        updateMiniProgressBar();
                    }, 10);

                    // 6. Сохраняем изменения на сервере
                    await saveExperience(currentXp, newLevel);

                } catch (error) {
                    console.error('Ошибка при понижении уровня:', error);
                    alert('Ошибка: ' + error.message);
                    updateProgressBar(); // Восстанавливаем состояние при ошибке
                }
            }

            function deleteLastChar() {
                if (currentExpression.length > 1) {
                    currentExpression = currentExpression.slice(0, -1);
                } else {
                    currentExpression = '0';
                }
                document.getElementById('xp-input').value = currentExpression;
            }
            document.addEventListener("DOMContentLoaded", function() {
                // Получаем данные из data-атрибутов
                const miniProgress = document.querySelector('.mini-progress-container');
                currentLevel = parseInt(miniProgress.dataset.currentLevel) || 1;
                currentXp = parseInt(miniProgress.dataset.currentXp) || 0;

                // Инициализируем прогресс-бары
                updateMiniProgressBar(currentLevel, currentXp);

                // Обработчики для кнопок
                document.getElementById('level-up-btn').addEventListener('click', levelUpCharacter);
            });

            document.getElementById('settings-backdrop').addEventListener('click', function() {
                const sidebarModal = document.getElementById('settings-modal');
                const backdrop = document.getElementById('settings-backdrop');
                sidebarModal.classList.remove("show");
                backdrop.classList.remove('active');
                setTimeout(() => {
                    backdrop.style.display = 'none';
                }, 300);
            });
            document.addEventListener("DOMContentLoaded", function() {
                const miniProgress = document.querySelector('.mini-progress-container');
                currentLevel = parseInt(miniProgress.dataset.currentLevel) || 1;
                currentXp = parseInt(miniProgress.dataset.currentXp) || 0;
                nextLevelXp = parseInt(miniProgress.dataset.nextLevelXp) || XP_TABLE[currentLevel + 1];

                updateMiniProgressBar();
                updateProgressBar();
            });
            // Функция обновления мини-прогресс бара
            function updateMiniProgressBar() {
                const currentLevelXp = XP_TABLE[currentLevel] || 0;
                const nextLevelXp = XP_TABLE[currentLevel + 1] || XP_TABLE[20];
                const prevLevelXp = XP_TABLE[currentLevel - 1] || 0;

                let startXp, endXp;
                if (currentXp < currentLevelXp) {
                    startXp = prevLevelXp;
                    endXp = currentLevelXp;
                } else {
                    startXp = currentLevelXp;
                    endXp = nextLevelXp;
                }

                const progressPercent = ((currentXp - startXp) / (endXp - startXp)) * 100;

                const miniBar = document.getElementById('mini-xp-progress-bar');
                const miniText = document.getElementById('mini-xp-progress-text');

                if (miniBar && miniText) {
                    miniBar.style.width = `${progressPercent}%`;
                    miniText.textContent = `${currentXp}/${endXp}`;
                }

                document.querySelector('.character-level').textContent = `Уровень ${currentLevel}`;
            }

            document.addEventListener("DOMContentLoaded", function() {
                // Отключаем анимацию при первой загрузке
                const progressBar = document.getElementById('xp-progress-bar');
                progressBar.style.transition = 'none';

                updateProgressBar();

                // Включаем анимацию после небольшой задержки
                setTimeout(() => {
                    progressBar.style.transition = 'width 0.5s ease';
                }, 100);
            });

            // Инициализация при загрузке
            document.addEventListener("DOMContentLoaded", function() {
                initProgressBars();
            });

            function initProgressBars() {
                const miniProgress = document.querySelector('.mini-progress-container');
                currentLevel = parseInt(miniProgress.dataset.currentLevel) || 1;
                currentXp = parseInt(miniProgress.dataset.currentXp) || 0;

                updateProgressBar();
                updateMiniProgressBar();

                // Проверяем обе кнопки при загрузке
                checkLevelUp();
                checkLevelDown();
            }

            document.addEventListener("DOMContentLoaded", function() {
                updateMiniProgressBar();
            });
            document.addEventListener("DOMContentLoaded", function() {
                // Получаем начальные значения
                const miniProgress = document.querySelector('.mini-progress-container');
                currentLevel = parseInt(miniProgress.dataset.currentLevel) || 1;
                currentXp = parseInt(miniProgress.dataset.currentXp) || 0;

                // Инициализируем прогресс-бары
                updateProgressBar();
            });
            //////ПРАВАЯ СТОРОНА ПЕРСОНАЖА

            function rollInitiative() {
                const dexterityValue = parseInt(document.getElementById("dexterity").value) || 10;
                const dexMod = getModifier(dexterityValue);
                const roll = Math.floor(Math.random() * 20) + 1;
                const total = roll + dexMod;

                // Обновляем отображение модификатора
                document.getElementById("initiative-mod").textContent = dexMod >= 0 ? `+${dexMod}` : dexMod;

                addNotification(
                    "ИНИЦИАТИВА",
                    "ЛОВКОСТЬ",
                    roll,
                    dexMod,
                    total
                );
            }

            // 👇 Автоматическое обновление модификатора при загрузке
            document.addEventListener("DOMContentLoaded", function () {
                const dexEl = document.getElementById("dexterity");
                const modEl = document.getElementById("initiative-mod");

                if (dexEl && modEl) {
                    const mod = getModifier(parseInt(dexEl.value) || 10);
                    modEl.textContent = mod >= 0 ? `+${mod}` : mod;
                }
            });

            document.addEventListener("DOMContentLoaded", function () {
                const dexInput = document.getElementById("dexterity");
                const initiativeEl = document.getElementById("initiative-mod");

                function updateInitiative() {
                    if (dexInput && initiativeEl) {
                        const dexMod = getModifier(parseInt(dexInput.value) || 10);
                        initiativeEl.textContent = dexMod >= 0 ? `+${dexMod}` : dexMod;
                    }
                }

                // Отображаем модификатор сразу при загрузке
                updateInitiative();

                // Обновляем при изменении ловкости
                dexInput?.addEventListener("change", updateInitiative);
            });
        </script>
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
                    <div class="level-marker current-level">
                        <span class="level-number" id="current-level-value">1</span>
                        <span class="level-xp" id="current-level-xp">0 XP</span>
                    </div>
                    <div class="progress-container">
                        <div class="progress-track">
                            <div class="progress-bar" id="xp-progress-bar">
                                <div class="progress-indicator">
                                    <span class="current-xp-value" id="current-xp-display">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="level-marker next-level">
                        <span class="level-number" id="next-level-value">2</span>
                        <span class="level-xp" id="next-level-xp">300 XP</span>
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
                        <button type="button" class="xp-action-btn level-down-btn" id="level-down-btn" onclick="levelDownCharacter()">ПОНИЗИТЬ</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-backdrop" class="modal-backdrop"></div>
        <div id="settings-backdrop" class="modal-backdrop"></div>
</body>
</html>

