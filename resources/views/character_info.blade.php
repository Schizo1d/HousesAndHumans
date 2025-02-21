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
                @php
                    $attributes = [
                        'strength' => ['Сила', ['athletics' => 'Атлетика']],
                        'dexterity' => ['Ловкость', ['acrobatics' => 'Акробатика', 'sleight-of-hand' => 'Ловкость рук', 'stealth' => 'Скрытность']],
                        'constitution' => ['Телосложение', []],
                        'intelligence' => ['Интеллект', ['analysis' => 'Анализ', 'history' => 'История', 'arcana' => 'Магия', 'nature' => 'Природа', 'religion' => 'Религия']],
                        'wisdom' => ['Мудрость', ['perception' => 'Восприятие', 'survival' => 'Выживание', 'medicine' => 'Медицина', 'insight' => 'Проницательность', 'animal-handling' => 'Уход за животными']],
                        'charisma' => ['Харизма', ['performance' => 'Выступление', 'intimidation' => 'Запугивание', 'deception' => 'Обман', 'persuasion' => 'Убеждение']]
                    ];
                @endphp

                @foreach ($attributes as $key => [$name, $skills])
                    <div class="attribute-item">
                        <span onclick="openModal('{{ $key }}')" style="cursor: pointer;">{{ $name }}:</span>
                        <a href="javascript:void(0);" id="{{ $key }}-button" onclick="openModal('{{ $key }}')" style="cursor: pointer;">
                            {{ $character->attributes->$key ?? 10 }}
                        </a>
                        <input type="hidden" id="{{ $key }}" name="{{ $key }}" value="{{ $character->attributes->$key ?? 10 }}">

                        @if (!empty($skills))
                            <div class="sub-attributes">
                                @foreach ($skills as $skillKey => $skillName)
                                    <label>
                                        <input type="checkbox" class="radio-toggle" data-target="{{ $skillKey }}"> {{ $skillName }}
                                    </label>
                                    <span id="{{ $skillKey }}-value">0</span>
                                    <input type="hidden" name="{{ $skillKey }}" id="{{ $skillKey }}" value="0">
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
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

            function openModal(attr) {
                currentAttr = attr;
                let value = document.getElementById(attr).value;
                document.getElementById("modal-title").innerText = attributeNames[attr] || attr;
                document.getElementById("modal-input").value = value;
                document.getElementById("attributeModal").style.display = "flex";
            }

            function closeModal() {
                document.getElementById("attributeModal").style.display = "none";
            }

            function saveAttribute() {
                let value = document.getElementById("modal-input").value;
                if (!currentAttr) return;

                document.getElementById(`${currentAttr}-button`).textContent = value;
                document.getElementById(currentAttr).value = value;

                closeModal();
            }

            document.querySelectorAll('.radio-toggle').forEach(item => {
                item.addEventListener('click', function () {
                    let targetId = this.getAttribute('data-target');
                    let span = document.getElementById(targetId + "-value");
                    let input = document.getElementById(targetId);

                    let currentValue = parseInt(span.innerText, 10);

                    if (currentValue >= 100) {
                        span.innerText = "-9";  // Сбрасываем в минимальное значение
                        input.value = -9;
                    } else {
                        span.innerText = currentValue + 2;  // Увеличиваем на 2
                        input.value = currentValue + 2;
                    }
                });
            });
        </script>
</body>
</html>
