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
        <form action="{{ route('character_attributes.store', ['character' => $character->id]) }}" method="POST">
            @csrf
            <input type="number" name="character_id" value="{{ $character->id }}">

            <label for="strength"><img src="{{asset('img/strenght.png')}}" alt="">Сила:</label>
            <input type="number" id="strength" name="strength" value="{{ $character->attributes->strength ?? '' }}" required>

            <label for="dexterity"><img src="{{asset('img/agility.png')}}" alt="">Ловкость:</label>
            <input type="number" id="dexterity" name="dexterity" value="{{ $character->attributes->dexterity ?? '' }}" required>

            <label for="constitution"><img src="{{asset('img/Physique.png')}}" alt="">Телосложение:</label>
            <input type="number" id="constitution" name="constitution" value="{{ $character->attributes->constitution ?? '' }}" required>

            <label for="intelligence"><img src="{{asset('img/artificial-intelligence.png')}}" alt="">Интеллект:</label>
            <input type="number" id="intelligence" name="intelligence" value="{{ $character->attributes->intelligence ?? '' }}" required>

            <label for="wisdom"><img src="{{asset('img/Wisdom.png')}}" alt="">Мудрость:</label>
            <input type="number" id="wisdom" name="wisdom" value="{{ $character->attributes->wisdom ?? '' }}" required>

            <label for="charisma"><img src="{{asset('img/charisma.png')}}" alt="">Харизма:</label>
            <input type="number" id="charisma" name="charisma" value="{{ $character->attributes->charisma ?? '' }}" required>

            <button type="submit">Сохранить атрибуты</button>
        </form>

    </div>
</main>

</body>

</html>

