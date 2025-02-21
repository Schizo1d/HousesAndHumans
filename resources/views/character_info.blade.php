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
                    <span>Сила:</span>
                    <button type="button" class="open-modal" data-attr="strength"
                            data-value="{{ $character->attributes->strength ?? 10 }}">
                        {{ $character->attributes->strength ?? 10 }}
                    </button>
                    <input type="hidden" name="strength" value="{{ $character->attributes->strength ?? 10 }}">
                </div>

                <div class="attribute-item">
                    <span>Ловкость:</span>
                    <button type="button" class="open-modal" data-attr="dexterity"
                            data-value="{{ $character->attributes->dexterity ?? 10 }}">
                        {{ $character->attributes->dexterity ?? 10 }}
                    </button>
                    <input type="hidden" name="dexterity" value="{{ $character->attributes->dexterity ?? 10 }}">
                </div>

                <div class="attribute-item">
                    <span>Телосложение:</span>
                    <button type="button" class="open-modal" data-attr="constitution"
                            data-value="{{ $character->attributes->constitution ?? 10 }}">
                        {{ $character->attributes->constitution ?? 10 }}
                    </button>
                    <input type="hidden" name="constitution" value="{{ $character->attributes->constitution ?? 10 }}">
                </div>

                <div class="attribute-item">
                    <span>Интеллект:</span>
                    <button type="button" class="open-modal" data-attr="intelligence"
                            data-value="{{ $character->attributes->intelligence ?? 10 }}">
                        {{ $character->attributes->intelligence ?? 10 }}
                    </button>
                    <input type="hidden" name="intelligence" value="{{ $character->attributes->intelligence ?? 10 }}">
                </div>

                <div class="attribute-item">
                    <span>Мудрость:</span>
                    <button type="button" class="open-modal" data-attr="wisdom"
                            data-value="{{ $character->attributes->wisdom ?? 10 }}">
                        {{ $character->attributes->wisdom ?? 10 }}
                    </button>
                    <input type="hidden" name="wisdom" value="{{ $character->attributes->wisdom ?? 10 }}">
                </div>

                <div class="attribute-item">
                    <span>Харизма:</span>
                    <button type="button" class="open-modal" data-attr="charisma"
                            data-value="{{ $character->attributes->charisma ?? 10 }}">
                        {{ $character->attributes->charisma ?? 10 }}
                    </button>
                    <input type="hidden" name="charisma" value="{{ $character->attributes->charisma ?? 10 }}">
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
                <input type="hidden" id="modal-attribute">
                <button class="modal-save-btn" onclick="saveAttribute()">Сохранить</button>
            </div>
        </div>

        <script>
            let currentAttr = null;

            function openModal(attr, value) {
                currentAttr = attr;
                document.getElementById("modal-title").innerText = "Изменить " + attr;
                document.getElementById("modal-input").value = value;
                document.getElementById("attributeModal").style.display = "flex";
            }

            function closeModal() {
                document.getElementById("attributeModal").style.display = "none";
            }

            document.querySelectorAll('.open-modal').forEach(button => {
                button.addEventListener('click', function () {
                    openModal(this.getAttribute('data-attr'), this.getAttribute('data-value'));
                });
            });

            function saveAttribute() {
                let value = document.getElementById("modal-input").value;
                if (!currentAttr) return;

                // Обновляем текст на кнопке
                let button = document.querySelector(`[data-attr="${currentAttr}"]`);
                if (button) {
                    button.textContent = value;
                    button.setAttribute('data-value', value);
                }

                // Обновляем скрытый input для формы
                let input = document.querySelector(`input[name="${currentAttr}"]`);
                if (input) {
                    input.value = value;
                }

                closeModal();
            }
        </script>

</body>
</html>
