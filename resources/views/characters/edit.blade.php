@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Редактирование атрибутов персонажа</h2>

        <form action="{{ route('characters.update', $character->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label for="strength">Сила:</label>
                <input type="number" name="strength" id="strength" value="{{ $character->attributes->strength ?? 10 }}" required>
            </div>

            <div>
                <label for="dexterity">Ловкость:</label>
                <input type="number" name="dexterity" id="dexterity" value="{{ $character->attributes->dexterity ?? 10 }}" required>
            </div>

            <div>
                <label for="constitution">Телосложение:</label>
                <input type="number" name="constitution" id="constitution" value="{{ $character->attributes->constitution ?? 10 }}" required>
            </div>

            <div>
                <label for="intelligence">Интеллект:</label>
                <input type="number" name="intelligence" id="intelligence" value="{{ $character->attributes->intelligence ?? 10 }}" required>
            </div>

            <div>
                <label for="wisdom">Мудрость:</label>
                <input type="number" name="wisdom" id="wisdom" value="{{ $character->attributes->wisdom ?? 10 }}" required>
            </div>

            <div>
                <label for="charisma">Харизма:</label>
                <input type="number" name="charisma" id="charisma" value="{{ $character->attributes->charisma ?? 10 }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
@endsection
