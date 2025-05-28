<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('character_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('character_id'); // Связь с таблицей персонажей

            // Основные характеристики
            $table->integer('strength')->default(10); // Сила
            $table->integer('dexterity')->default(10); // Ловкость
            $table->integer('constitution')->default(10); // Телосложение
            $table->integer('intelligence')->default(10); // Интеллект
            $table->integer('wisdom')->default(10); // Мудрость
            $table->integer('charisma')->default(10); // Харизма

            // Навыки
            $table->integer('athletics')->default(0); // Атлетика
            $table->integer('acrobatics')->default(0); // Акробатика
            $table->integer('sleight_of_hand')->default(0); // Ловкость рук
            $table->integer('stealth')->default(0); // Скрытность
            $table->integer('investigation')->default(0); // Анализ
            $table->integer('history')->default(0); // История
            $table->integer('arcana')->default(0); // Магия
            $table->integer('nature')->default(0); // Природа
            $table->integer('religion')->default(0); // Религия
            $table->integer('perception')->default(0); // Восприятие
            $table->integer('survival')->default(0); // Выживание
            $table->integer('medicine')->default(0); // Медицина
            $table->integer('insight')->default(0); // Проницательность
            $table->integer('animal_handling')->default(0); // Уход за животными
            $table->integer('performance')->default(0); // Выступление
            $table->integer('intimidation')->default(0); // Запугивание
            $table->integer('deception')->default(0); // Обман
            $table->integer('persuasion')->default(0); // Убеждение

            $table->integer('passive_perception')->default(10); // Пассивное восприятие
            $table->integer('passive_insight')->default(10);    // Пассивная проницательность
            $table->integer('passive_investigation')->default(10); // Пассивный анализ

            $table->timestamps();

            // Добавляем внешний ключ для связи с таблицей персонажей
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_attributes');
    }
};
